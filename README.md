![visitors](https://visitor-badge.laobi.icu/badge?page_id=Md-shefat-masum.laravel_pharmacy_management_api.readme)
# Pharmacy management api

####  Installation
**requirements**

 1. PHP: 7.3 | ^8.0
 2. Laravel : ^8.75

First clone this repository, install the dependencies, and setup your .env file.

**run the commands**

clone project
```
git clone https://github.com/Md-shefat-masum/laravel_pharmacy_management_api.git
```

or [Click here to download .zip](https://github.com/Md-shefat-masum/laravel_pharmacy_management_api/archive/refs/heads/main.zip)


install dependencies
```
composer install
```

swith directory to project
```
cd hiring-portal
```

setup passport
```
php artisan passport:install
```

generate app key
```
php artisan paassport:key
```

copy .env.example and paste as .env
```
cp .env.example .env
or copy .env.example .env
```

open in vs code editor
```
code .
```

open .env file and change db name. 
**database setup**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=
```

migrate database, and seed
```
php artisan migrate:fresh --seed 
```

Finally time to launch project, run
```
php artisan serve
```
the project will open at http://127.0.0.1:8000

or
```
php artisan serve --port=8001 | any supported port number
```

####  login credentials


|   role         |     Email             |   password |                                           
|----------------|-----------------------|------------|
|super_admin     |super_admin@gmail.com  |`12345678`  |
|admin           |admin@gmail.com        |`12345678`  |
|doctor          |doctor@gmail.com       |`12345678`  |
|pharmacy        |pharmacy@gmail.com     |`12345678`  |
|consumer        |consumer@gmail.com     |`12345678`  |
|delivery_man    |delivery_man@gmail.com |`12345678`  | 
