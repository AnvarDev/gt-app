# Install PHP FPM
FROM php:8.3-fpm

# Install extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable pdo_mysql

# Install nvm
ENV NODE_VERSION 16.18.0
ENV NVM_DIR /usr/local/nvm
RUN mkdir $NVM_DIR
RUN curl -sS https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash \
    && . $NVM_DIR/nvm.sh \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default

ENV NODE_PATH $NVM_DIR/v$NODE_VERSION/lib/node_modules
ENV PATH $NVM_DIR/versions/node/v$NODE_VERSION/bin:$PATH

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Add the wait script to the image
ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.9.0/wait /wait
RUN chmod +x /wait

# Copy existing application directory contents from project root into the current container's working directory
COPY . .

# Copy entrypoint
COPY .docker/entrypoint.sh /usr/local/etc/entrypoint.sh

# Permissions for entrypoint
RUN chmod +x /usr/local/etc/entrypoint.sh

# Copy php configuration
COPY .docker/php.ini /usr/local/etc/php/conf.d/php.ini

EXPOSE 9000

ENTRYPOINT ["/usr/local/etc/entrypoint.sh"]
