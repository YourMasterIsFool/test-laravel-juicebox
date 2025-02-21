# Test Laravel App

## Short Description

JuiceBox test laravel backend 

## Feature

1. Weather App 
2. Post
3. User
4. Integration test


## Instalation & Setup

how to install project locally

#### 1. Prerequisites
* PHP 8.2
* Mariadb / MySql
* Postman
  

### 2. Instalation
1. ``` git clone https://github.com/YourMasterIsFool test-laravel-juicebox.git ```
2. ``` cd test-laravel-juicebox ```

if use docker 
``` docker compose up --build -d ```

if don't just setup datababse mysql normally

1. install laravel package
   ``` composer install ```
2. setup database laravel edit file .env
DB_PORT={your mysql port}
DB_DATABASE={your mysql database}
DB_USERNAME={your mysql username}
DB_PASSWORD={your mysql password} 

1. migrate database
   ``` php artisan migrate ```
2. generate new  key
    ``` php artisan key:generate ```
3. running laravel server
   ``` php artisan server --port 8899 ```


## 3. running test
``` php artisan test ```


## 4. api documentation
open ``` https://app.getpostman.com/join-team?invite_code=fcd4a708cd5936534046afdb4c6d557095106390e055b47b707b966c69e3aa9b&target_code=f9916622baf730213959d73ceaec098d ```
