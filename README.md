## Car Dealership in Symfony 6 (with PHP 8)

#### Instruction on how to install this app

1. Clone this repository on your local machine
```bash
$ git clone https://github.com/iradukundablaise/car-dealership-symfony
```
2. Make sure you have docker and docker compose installed on your machine, Check with the following commands
```bash
docker -v
```
```bash
docker-compose -v
```
3. Start all docker containers with docker compose with the following terminal command
```bash
docker-compose up -d
```
4. Open the web browser and navigate to http://localhost:9000

5. If the app doesn't work, don't hesitate to log the containers
6. How to run migrations and fixtures and other symfony commands inside the container
```bash
php bin/console make:migration
```
```bash
php bin/console doctrine:migrations:migrate
```
```bash
php bin/console doctrine:fixtures:load
```