### Hexlet tests and linter status:
![Actions Status](https://github.com/IgBuS/php-project-lvl3/actions/workflows/ci.yml/badge.svg)
[![hexlet-check](https://github.com/IgBuS/php-project-lvl3/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/IgBuS/php-project-lvl3/actions/workflows/hexlet-check.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/b573b1b324e381ce5917/maintainability)](https://codeclimate.com/github/IgBuS/php-project-lvl3/maintainability)

## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)
* [How to start](#start)
* [License](#license)



# Webpage analizer

## General info

This web application is for checking basic page parameters. They are response status, h1, title, and description. All you need is just enter the name of the website in the form on the main page (don't forget to check the format of the input, there is a hint for your convenience). After your URL has been stored, you may enter the URL’s page and initiate a check. You will see the result soon. The number of checks is unlimited, please, feel free to tap the button as many times as you want.
In case there are some problems during the check, the application will show you what is the problem via a flash message. For starting the app you should use Docker. Check that it is active before start.
Public link - https://pacific-temple-99321.herokuapp.com

## Technologies
Project is created with:
* PHP: 8.1.12
* Laravel: 8.83.26
* Bootstrap: 4.0
* Docker

* imangazaliev/didom


## Setup

```sh
$ git clone https://github.com/IgBuS/php-project-lvl3.git

$ make install
```

## Start

```sh
$ make start
```

## License

This project is licensed under the terms of the MIT license.


Creater by @biserg