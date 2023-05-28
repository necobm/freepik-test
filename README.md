# API RESTFull with Symfony 6, without using API Platform

This is a coding lab project to test how easy and fast could be an API RESTFull implementation using Symfony 6, without API Platform

## Technical requirements

- [Docker](https://www.docker.com/)

## Build

```bash
make build
```

This command executes the Docker image building process and performs the [Composer](https://getcomposer.org) dependencies installation.

---

Type `make help` for more tasks present in `Makefile`.

## Features

- Authentication
- Authorization
- Resources CRUD operations

---

A light infrastructure is provided with a populated MySQL database with example data and a web server using PHP built-in development server.

---

## Setting up local environment

After the Build step, you can run the containers with Docker Compose (V2)

```bash
docker compose up -d
```

In order to populate test data into the database, you must run the fallowing command:

```bash
docker exec -i freepik_php sh -c 'php bin/console hautelook:fixtures:load -n --env=dev --no-bundles'
```

## Run tests

```bash
docker exec -i freepik_php sh -c 'vendor/bin/phpunit'
```

## API Documentation

https://documenter.getpostman.com/view/11366921/2s93eVXDeG#introduction 
