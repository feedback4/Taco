# Taco Manufacturing System
<p>For Factories powered by laravel </p>

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- Simple, fast routing engine

Taco is accessible, powerful, and provides tools required for large, robust applications.

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker).

Clone the repository

    git clone git@github.com:feedback4/Taco.git

Switch to the repo folder

    cd Taco

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env
Create a main Database and configure it at .env file

     CREATE DATABASE feedback ;

Generate a new application key

    php artisan key:generate

Install all the dependencies using npm

    npm install && npm run dev


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan teannts:migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:feedback4/Taco.git
    cd Taco
    composer install
    cp .env.example .env
    php artisan key:generate
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan tenants:migrate

**Make sure you set the connection between storage and public directory (run only once in project lifetime)**

    php artisna storage:link 

### Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Open the DummyDataSeeder and set the property values as per your requirement

    database/seeds/DatabaseSeeder.php

Run the database seeder and you're done

    php artisan tenants:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh --seed

**Accounts**

    feedback@taco.com  
    admin@taco.com  
    accountant@taco.com

You can now access the server at http://localhost:8000

    php artisan serve
***Enjoy*** 
    
    
