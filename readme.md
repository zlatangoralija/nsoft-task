<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## NSoft - Seven Essential Services Recruiting Task
Welcome. This is my solution for the given task above. This project contains two services: Service A and Service B, which use a messaging system that connects them to single business process. All project parts, installation, how to set-up and how to run specific services and tasks will be separately documented down below.


## Table of contents
Insert table of contents here:

## Instalation
After cloning or downloading project files, first thing is to install composer, which is a tool for dependency management in PHP, by running this command in terminal:
```php
composer install
```

After composer is installed, the application key has to be generated by running this command in terminal:
```php
php artisan key:generate
```

Now, project is set-up for further configuration. This project is using MySQL database, so before we continue, create an empty database. After that, rename the .env-example file to just .env and enter your database configuration, like below:
```php
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password
```
> Note: MySQL user should have all privileges.

##Setting up Docker containers
This project is "Dockerable", so you have to set up Docker first, in order to run services. This project uses [Laradock](https://laradock.io/), which is a full PHP development environment for Docker. In order to run this project with docker containers, first navigate to laradock folder, which includes all pre-configured and pre-packaged Docker Images. 
```
cd laradock
```

Sinc all Docker Images all pre-configured, you just have to specify which containers you need to run, in this case: 
- MySQL, 
- RabbitMQ,
- apache2,
- phpmyadmin

One more thing you have to do before running containers, is to rename the laradock/env-example to .env, and enter your same database configuration again: 
```
MYSQL_VERSION=5.7
MYSQL_DATABASE=your_database_name
MYSQL_USER=your_mysql_user
MYSQL_PASSWORD=your_mysql_password
MYSQL_PORT=3306
MYSQL_ROOT_PASSWORD=root
MYSQL_ENTRYPOINT_INITDB=./mysql/docker-entrypoint-initdb.d
```

Afther that, Docker containers are ready to run. Make sure you are in laradock/ directory and that Docker is running on your machine:
```
docker-compose up -d mysql apache2 rabbitmq phpmyadmin
```
After everything is pulled, you can check if it is installed properly and ready to go, with the command below. Everyhting should have the `state` of `up`. 
```
docker-compose ps
```

After that, we navigate to working directory of docker image, which is workspace:
```
docker-compose exec workspace bash
```
> Note: If you for some reason get an "*php_network_getaddresses: getaddrinfo failed*" error, just rebuild mysql container with following command: *docker-compose build --no-cache mysql*"

If everything is set-up correctly, we can now migrate the tables, which will create *account* entity in given database, with two properties, **balance** and **updatedAt**. Initial**balance**is set at**0**and initial**updatedAt**is set at**NULL**by default. Now you have everything set, and you can proceed to Services documentation, which will contain all necessary information about purposes, set-up and running.


## Service A
Service A is the first part of this project. This service is used to generate message for the Service B. Continue documentation here......

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
