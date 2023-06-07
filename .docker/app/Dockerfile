FROM webdevops/php-nginx:8.2-alpine
    ENV WEB_DOCUMENT_ROOT=/app/public
    ENV PHP_DISMOD=bz2,calendar,exiif,ffi,intl,gettext,ldap,mysqli,imap,pdo_pgsql,pgsql,soap,sockets,sysvmsg,sysvsm,sysvshm,shmop,xsl,zip,gd,apcu,vips,yaml,imagick,amqp
    ENV COMPOSER_ALLOW_SUPERUSER=1

    WORKDIR /app

    COPY . /app

    RUN composer install -o --no-dev

    RUN chown -R application:application .

    RUN chmod +x .docker/app/entrypoint.sh

    COPY .docker/app/entrypoint.sh /opt/docker/provision/entrypoint.d/artisan.sh

    EXPOSE 80
