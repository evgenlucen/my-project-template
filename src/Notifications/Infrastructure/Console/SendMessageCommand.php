<?php

namespace App\Notifications\Infrastructure\Console;

use App\Notifications\Application\Send\SendNotificationCommand;
use App\Shared\Application\Command\CommandSyncBusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMessageCommand extends Command
{
    protected static $defaultName = 'app:send-notification';
    protected static $defaultDescription = 'Отправить уведомление';

    public function __construct(private readonly CommandSyncBusInterface $commandBus)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'id уведомления'
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->execute(new SendNotificationCommand($input->getArgument('id')));

        return Command::SUCCESS;
    }
}
