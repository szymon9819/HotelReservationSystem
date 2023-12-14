# Microservices-Based Application Setup Guide

This README.md file provides instructions for setting up a new microservices-based application. The following steps
cover necessary changes and initial setup tasks.

## Docker Compose Configuration

1. Open the `docker-compose.yml` file.
2. Change the container names for each service to match your project's naming conventions.

## Makefile Configuration

1. Open the `Makefile` in your project.
2. Update the variables corresponding to container names to match the changes made in the `docker-compose.yml` file.

    - `APP_CONTAINER_NAME` should be updated to your app container name (e.g., `app_example`).
    - `MYSQL_CONTAINER_NAME` should be updated to your MySQL container name (e.g., `db_example`).
    - `MYSQL_TEST_CONTAINER_NAME` should be updated to your MySQL test container name (e.g., `db_test_example`).
    - `REDIS_CONTAINER_NAME` should be updated to your Redis container name (e.g., `cache_example`).

## Nginx Configuration

1. Open the Nginx configuration file [`./docker/nginx/custom.conf`](./docker/nginx/custom.conf).
2. Find the `fastcgi_pass` directive, and change it to point to your PHP container defined in the `docker-compose.yml`
   file.

## Environment Configuration

1. Update the following environment variables in your environment files:

    - `FORWARD_APP_PORT` in the `.env.example` and `.env.example.testing` file.
    - `FORWARD_SSL_APP_PORT` in the `.env.example` file.
    - `FORWARD_DB_PORT` in the `.env.example` file.
    - `FORWARD_DATABASE_TEST_PORT` in the `.env.example.testing` file.
    - `FORWARD_REDIS_PORT` in the `.env.example` file.
    - `DB_HOST` in the `.env.example` and `.env.example.testing` file.
    - `MYSQL_DATABASE` in the `.env.example` and `.env.example.testing` file.

## Initial Setup Steps

To install and set up the application, follow these steps:

1. Build the Docker containers by running the following command:
    - Run the following command to build the Docker containers:
        ```shell script
          make build
        ```
    - Run docker containers, use:
        ```shell script
          make start
        ```
    - To enter the Docker container's shell for further configuration, use:
        ```shell script
          make enter
        ```
    - Install Composer dependencies within the container with:
        ```shell script
          composer install
        ```
    - Generate the Laravel application key using the following command:
        ```shell script
          php artisan key:generate
        ```
    - If you want to initialize the database and seed it with data, run the following command within the container:
        ```shell script
          php artisan migrate --seed
        ```
