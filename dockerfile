# Use an official PHP runtime as a parent image
FROM php:8.0-apache

# Set working directory
WORKDIR /

# Copy source code into the container
COPY . /var/www/html

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Expose port 80 for Apache
EXPOSE 80

# Start Apache service
CMD ["apache2-foreground"]
