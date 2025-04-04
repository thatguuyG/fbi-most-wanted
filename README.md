# FBI Most Wanted

This project is a full-stack application using Laravel as the backend and Vue.js as the frontend. This README provides complete instructions on how to set up and run the application locally using the traditional Laravel setup as well as via Docker.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Running the Application Locally](#running-the-application-locally)
3. [Running with Docker](#running-with-docker)
4. [Environment Variables](#environment-variables)
5. [Testing](#testing)

## 
**1. Prerequisites**  

Before you begin, ensure you have the following installed on your local machine:
- **PHP 8.x** (or higher)
- **Composer** (for managing PHP dependencies)
- **Node.js** (for compiling frontend assets)
- **Docker** (optional, if you wish to run the app via containers)

##
**2. Running the Application Locally** 

Follow these steps to run the Laravel application on your local machine:

#### Install PHP Dependencies: 
Clone the repository and install the PHP dependencies:
```bash
git clone https://github.com/thatguuyG/fbi-most-wanted.git
cd your-laravel-project
composer install
```


#### Generate the Application Key:: 
```bash
php artisan key:generate
```


##
**3. Running with Docker** 

Ensure that Docker is installed. [Download Docker](https://www.docker.com/get-started).
#
Docker Compose: Docker Compose is included with Docker Desktop. Verify by running `docker compose version`.

Run the following command to build the Docker environment:

```bash
docker compose -f docker-compose.yaml up --build
```

Once the application is up and running, you can access the application via the port define in the docker-compose.yaml file


##
**4. Environment variables** 

Clone the .env.example file:
```bash
cp .env.example .env
```

##
**5. Testing** 

To run the Laravel application tests, execute:
```bash
php artisan test
```


If running inside Docker, you can use:
```bash
docker-compose exec php-apache php artisan test

```

