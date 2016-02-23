Hotel project
=============

## Getting Started (OSX)
1. [Install homebrew](http://brew.sh/)
2. [Install php 5.6](https://github.com/Homebrew/homebrew-php#installation)
3. Install MySql - `brew install mysql`
4. [Install Symfony](http://symfony.com/doc/current/book/installation.html#linux-and-mac-os-x-systems)
5. Install Composer - `brew install composer`
6. Install Dependancies - `composer install`

## Setup and start the DBs
1. Setup MySql to run on launch:
   - ln -sfv /usr/local/opt/mysql/*plist ~/Library/LaunchAgents
   - launchctl load ~/Library/LaunchAgents/homebrew.mxcl.mysql.plist
2. Create databases - `php app/console doctrine:database:create`
3. Update db schema - `php app/console doctrine:schema:update --force`
4. Run the server - `php app/console server:run`
5. Api methods:
   - Get all offers (GET)localhost:8000/api/v1/offers
   - Show a offer (GET)localhost:8000/api/v1/offers/{id}
   - Create a offer (POST - data:{'date': '27/02/2016'})localhost:8000/api/v1/offers
   - Remove a offer (DELETE)localhost:8000/api/v1/offers/{id}

## Testing
1. Run unit tests - `bin/phpunit`

## Architecture Overview

1. Resource Layer

   - We created an abstraction on top of Doctrine, in order to have a consistent and flexible way to manage all the resources. By “resource” we understand every model in the application. Simplest examples of resources are “offer”, “room” and so on...

   - Resource management system lives in the AcmeResourceBundle and can be used in any Symfony2 bundles.

   - Let us take the “offer” resource as an example. By default, It is represented by Acme\Component\Hotel\Model\Offer class and implement proper OfferInterface.

2. Services

   For every resource we have three very important services available:

   - Operator (manager, builder...): services handle business logic. 
   - Repository: Repository is defined as a service for every resource and shares the API with standard Doctrine ObjectRepository.
   - Controller: This service is the most important for every resource and provides a format agnostic CRUD controller with the following actions:
     + [GET] showAction() for getting a single resource
     + [GET] indexAction() for retrieving a collection of resources
     + [POST] createAction() for creating new resource
     + [PUT] updateAction() for updating an existing resource
     + [DELETE] removeAction() for removing an existing resource

   As you can see, these actions match the common operations in any REST API and yes, they are format agnostic. That means, all controllers can serve HTML, JSON or XML, depending on what do you request.

3. Core Interface

   - AcmeCoreBundle, which is the glue for all other bundles. It is the integration layer of Core component.
