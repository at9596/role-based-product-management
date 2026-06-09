# Role-Based Product Management System

A Laravel 13 application implementing Role-Based Access Control (RBAC) using the Spatie Laravel Permission package.

## Overview

This project demonstrates a complete role-based product management system with authentication, authorization, product management, category management, and customer-facing product browsing.

## Features

### Authentication

* User Registration
* User Login
* Secure Password Hashing
* Form Validation
* Role Assignment

### Roles & Permissions

#### Admin

* Full system access
* Manage products
* Delete products
* Manage categories
* View users
* Edit users
* Assign roles

#### Manager

* Create products
* Edit products
* View product list
* Create categories
* Manage category assignments
* Upload and crop product images

#### Customer

* Register and login
* View product listings
* View product details

### Product Management

* Create products
* Update products
* Product listing
* Category assignment
* Image upload
* Image cropping with Cropper.js
* Laravel Storage integration

### Category Management

* Create categories
* Assign products to categories
* Eloquent relationships

## Tech Stack

* Laravel 13
* PHP 8.3+
* MySQL
* Laravel Breeze
* Spatie Laravel Permission

## Database Relationships

### User

* Has Roles
* Has Permissions

### Product

* Belongs To Category

### Category

* Has Many Products


### Install Dependencies

```
composer install
npm install
```


### Run Application

```
php artisan serve
npm run dev
```

## Roles

| Role     | Permissions                   |
| -------- | ----------------------------- |
| Admin    | Full Access                   |
| Manager  | Product & Category Management |
| Customer | View Products                 |


## Packages

### Authentication

```bash
composer require laravel/breeze --dev
php artisan breeze:install
```

### RBAC

```
composer require spatie/laravel-permission
```
