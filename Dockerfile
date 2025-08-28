# Use PHP CLI image
FROM php:8.2-cli

# Set working directory inside container
WORKDIR /var/www/html

# Install PDO MySQL extension
RUN docker-php-ext-install pdo_mysql

# Keep container alive
CMD ["tail", "-f", "/dev/null"]
