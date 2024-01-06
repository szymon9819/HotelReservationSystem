# New Microservices-based Project
This project is based on a skeleton application that can be used as a starting point for creating a new microservices-based project. Below are the steps to create a new project:

## Creating a New Project:

### 1. Clone the Example App Folder

To create a new microservice, follow these steps:
- Copy the 'example-app' folder and give it the name that corresponds to the microservice.
- For instance, in the terminal, execute:
    ```bash
    cp -r example-app new-microservice
    ```

### 2. Copy Environment Variables

Next, copy the environment variable files:
- Duplicate the `.env.example` and `.env.testing.example` files as `.env`.
- For example, in the terminal, execute:
    ```bash
    cp .env.example .env
    cp .env.testing.example .env.testing
    ```

Continue with the following steps, as mentioned previously in the README file:

## Files to modify:

### 1. docker-compose.yml
- **Container Names:**
  - Add names for containers in the `container_name` variables.
  - Replace the Docker network for the microservice (replace `example-app-network`) with your desired network name.

- **Environment Variables:**
   - Check and modify environment variables such as ports, container names, paths to configuration files, etc., based on the requirements of the new project.

### 2. Update Makefile

- **Container Names in Makefile:**
  - Modify the variables in the Makefile according to container names in `docker.compose.yml`:
    - `APP_CONTAINER_NAME := your_app_name`
    - `MYSQL_CONTAINER_NAME := your_db_name`
    - `MYSQL_TEST_CONTAINER_NAME := your_test_db_name`
    - `REDIS_CONTAINER_NAME := your_cache_name`
    
### 3. .env and .env.example

- **Port Configurations:**
  - Adjust port configurations for variables used in the docker-compose file.

### 4. docker/nginx/config.conf

- **NGINX Configuration:**
  - Change `fastcgi_pass app_example:9000;` to the container name specified for the PHP container.

    Example:
    ```yaml
    php:
        build:
            context: .
            dockerfile: docker/php/Dockerfile
        container_name: worldchanging_custom_application
        networks:
            - hotel-reservation
            - worldchanging-app-network
        depends_on:
            - db
    ```

    Update the NGINX configuration file:
    ```nginx
    fastcgi_pass worldchanging_custom_application:9000;
    ```

## How to use this template:

- Copy this skeleton project as a starting point for creating a new microservices-based project.
- Review the mentioned files and adjust variables and configurations to fit your new project requirements.
- Make sure to read through the documentation in each file to fully understand which sections need modification.
