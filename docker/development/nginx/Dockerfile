FROM nginx:1.21-alpine

RUN apk add --no-cache curl

RUN rm -rf /etc/nginx/conf.d/default.conf

COPY ./common/nginx/conf.d              /etc/nginx/conf.d
COPY ./development/nginx/nginx.conf     /etc/nginx/
COPY ./development/nginx/conf.d/              /etc/nginx/conf.d/

WORKDIR /app

HEALTHCHECK --interval=5s --timeout=3s --start-period=1s CMD curl --fail http://127.0.0.1/health || exit 1
