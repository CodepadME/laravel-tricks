# [Laravel-Tricks](http://www.laravel-tricks.com)

Laravel Tricks is a website created by [Stidges](https://twitter.com/stidges) and [Maksim Surguy](http://twitter.com/msurguy) as an unofficial repository of tips and tricks for web developers using the [Laravel](http://laravel.com) PHP framework.

To see what this is about check out <http://www.laravel-tricks.com>!

## Table of contents

 - [Purpose and Features](#purpose-and-features)
 - [Requirements](#requirements)
 - [Quick Start and Installation](#quick-start-and-installation)
 - [Documentation](#documentation)
 - [Contributing](#contributing)
 - [Authors](#authors)
 - [Copyright and License](#copyright-and-license)

## Purpose and Features

The purpose of this repository is to provide a source of a real website that's using the Laravel PHP Framework and implements good design patterns for its architecture.

The features of [Laravel-Tricks](http://www.laravel-tricks.com) are:

- Multi User platform that enables registered users to post short excerpts of code and descriptions to go along with the code.
- Sorting and search.
- Categories and tags for each user submitted entry.
- OAuth 2 Github Registration and Login using [OAuth 2 client from PHP League](https://github.com/thephpleague/oauth2-client).
- Disqus integration for commenting.
- Customized [Bootstrap](http://getbootstrap.com) theme.
- AJAX favoriting.
- Gravatar integration.
- Using [jQuery FileAPI](http://rubaxa.github.io/jquery.fileapi/) for avatar uploads and cropping.
- Using [Intervention Image](https://github.com/Intervention/image) to handle the server side of the avatar uploads.
- Pinterest-inspired grid implemented with [Masonry](http://masonry.desandro.com/).
- Presenter classes implemented with the [Laravel Auto Presenter](https://github.com/ShawnMcCool/laravel-auto-presenter) package.

## Requirements

The Laravel-Tricks website requires a server with PHP 5.4+ that has the MCrypt extension installed.

The database engine that is used to store data for this application could be any of the engines supported by Laravel: MySQL, Postgres, SQLite and SQL Server.

## Quick Start and Installation

To get started and start making something of your own using this repository as a base: download this repository, create an empty database that this application will use, configure a few settings in the app/config folder and enjoy!

### Configuration

- Open up `app/config/database.php` and configure connection settings for your database.
- Configure hostname in `bootstrap/start.php` file to match your machine's hostname:

    ```
    $env = $app->detectEnvironment(array(

        'local' => array('your-machine-name'), // Edit this line

    ));
    ```
- If you want to use Github OAuth for login and registration, make sure to [create a Github application](https://github.com/settings/applications/new) first and provide its client ID and client secret to the config in `app/config/social.php`. Also make sure you're using `http://<your-site.com>/login/github` for Authorization callback URL

After this simple configuration you can populate the database by running a couple commands shown below.

### Installation

CD into the directory of this project and run the following three commands:

1. `composer install`
2. `php artisan migrate`
3. `php artisan db:seed`

This will install all Composer dependencies, create the database structure and populate the database with some sample data so that you could see this project in action.

## Documentation

While the code of the application is heavily documented it helps to know how the code is structured and what standards it follows.

### Project structure
To start, we have removed the `app/models` directory and created a custom namespace for the site.
This namespace houses all of the application's domain classes.

After that, we have namespaced the `app/Controller` directory, so that whenever new controllers are created `composer dump-autoload` doesn't have to be called every time.

The domain classes can be found in the `app/Tricks` directory. This contains all the application's logic. The controllers merely call these classes to perform the application's tasks.

The `app/Tricks` directory is structured in the following manner:

- **Exceptions**: Contains all the exceptions that are thrown from within the domain classes. All the exceptions (except for the `GithubEmailNotVerifiedException`) extend the `Tricks\AbstractNotFoundException` class. This makes it much easier to handle 404 errors. (The handling can be found in the `app/start/global.php` file).
- **Facades**: Contains all the custom [Facade](http://laravel.com/docs/facades) classes that are used throughout the application.
- **Presenters**: Contains all the Presenter classes which utilizes the Laravel Auto Presenter package. This provides a clean way to keep logic out of your views and encapsulate it all into one place.
- **Providers**: Contains all the application's [Service Provider](http://laravel.com/docs/ioc#service-providers) classes, which register the custom components to the application's IoC container. This, among many other advantages, eases the process of injecting classes/implementations and allows the creation of Facades.
- **Repositories**: Contains all the Repository classes. Repositories are used to abstract away the persistance layer interactions. This causes your classes to be less tightly coupled to an ORM like Eloquent. All the repositories implement an interface found in the root of the Repositories directory, which makes it easier to switch implementations.
- **Services**: This directory is split into multiple sub-directories:
  - **Forms**: Contains the Form classes, which are used to validate the user input upon form submission.
  - **Navigation**: Contains the navigation Builder class, which is used to build the site's navigation from a configuration file. The configuration file can be found under `app/config/navigation.php`.
  - **Social**: Contains the social integration classes for Github and Disqus. The Github class is used for the Github login and registration process. The Disqus class is used to get the comment count for the tricks.
  - **Upload**: Contains the ImageUploadService class. This class handles the uploading and resizing of an avatar.

### Standards
The Laravel-Tricks application is [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) compliant (and PSR-0 and PSR-1, which PSR-2 extends).
PSR-2 is a coding standard by PHP-FIG which aims to unify the way PHP code gets written, so that everyone collaborating on a project will adhere to the same standards. This makes the code easier to read and understand.

## Contributing

Contributions to this repository are more than welcome although not all suggestions will be accepted and merged with the live site.

## Community

Keep track of development and Laravel-Tricks news.

- Follow [@laraveltricks on Twitter](http://twitter.com/laraveltricks).


## Authors

**Stidges**

- <http://twitter.com/stidges>
- <https://github.com/stidges>

**Maksim Surguy**

- <http://twitter.com/msurguy>
- <http://github.com/msurguy>

## Copyright and license

Code released under [the MIT license](LICENSE).
