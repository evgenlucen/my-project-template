<?php

declare(strict_types=1);

namespace App\Tests;

use App\Shared\Infrastructure\Kernel;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\Transport\InMemoryTransport;
use Zenstruck\Foundry\Factory;

/**
 * Основной класс для тестов, требующих контейнера зависимостей.
 *
 * Наследовать этот класс от WebTestCase не совсем верно, если выстраивать правильную иерархию,
 * то будет сложно обеспечить все основные классы общими методами.
 *
 * Для доступа к контейнеру используйте self::getContainer().
 */
abstract class ContainerBasedTestCase extends WebTestCase
{
    private static array $doctrineCreateSchemaSqlCache;

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    /**
     * @throws \Throwable
     */
    protected function assertQueuedMessagesCount(int $expectedCount, string $transportName): void
    {
        $transport = $this->getContainer()->get('messenger.transport.' . $transportName);
        self::assertInstanceOf(InMemoryTransport::class, $transport);
        self::assertCount($expectedCount, $transport->getSent());
    }

    /**
     * @throws \Throwable
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        assert($entityManager instanceof EntityManagerInterface);

        return $entityManager;
    }

    /**
     * Готовит окружение перед тестом.
     *
     * @throws \Throwable
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->createDatabaseStructure();

    }

    /**
     * Очищает окружение после теста.
     *
     * @throws \Throwable
     */
    protected function tearDown(): void
    {
        $this->getEntityManager()->close();
        $this->getEntityManager()->getConnection()->close();
        Factory::shutdown();

        parent::tearDown();
    }

    /**
     * Создаёт структуру БД для тестов.
     *
     * @throws \Throwable
     */
    private function createDatabaseStructure(): void
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();
        $configuration = $connection->getConfiguration();
        if ($configuration instanceof Configuration) {
            $logger = $configuration->getSQLLogger();
            $configuration->setSQLLogger(null);
        }

        if (!isset(self::$doctrineCreateSchemaSqlCache)) {
            $schemaTool = new SchemaTool($entityManager);
            $schemaData = $entityManager->getMetadataFactory()->getAllMetadata();

            self::$doctrineCreateSchemaSqlCache = $schemaTool->getUpdateSchemaSql($schemaData);
        }

        foreach (self::$doctrineCreateSchemaSqlCache as $query) {
            $connection->executeQuery($query);
        }

        // SQLite по умолчанию не умеет работать с кириллицей. Поэтому замещаем некоторые функции.
        $pdo = $connection->getNativeConnection();
        assert($pdo instanceof \PDO);
        $pdo->sqliteCreateFunction(
            'lower',
            static fn(?string $value): ?string => $value ? mb_strtolower($value, 'utf8') : null,
            1,
        );
        // имитация функции поиска про триграммам
        $pdo->sqliteCreateFunction(
            'strict_word_similarity',
            static fn(?string $searchValue, ?string $dbValue): ?int => $searchValue ? similar_text($searchValue, $dbValue) : null
        );

        if ($configuration instanceof Configuration && $logger instanceof SQLLogger) {
            $configuration->setSQLLogger($logger);
        }

    }
}
