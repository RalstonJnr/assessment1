# Use official PHP image
FROM php:8.2-cli

# Install SQLite and required extensions
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Set working directory
WORKDIR /var/www/html

# Copy everything into the container
COPY . .

# Expose Render's default port
EXPOSE 10000

# Start the PHP server at that port
CMD php -S 0.0.0.0:${PORT:-10000} -t public
