# Birdboard
Birdboard is a project management system built to complete tasks in Mamicamp 2020.

## How to install locally

Clone this repo
```
git clone https://github.com/wikankun/birdboard-mamicamp-2020.git
```
Install dependencies
```
composer install
npm install
```
Setup environment variable
```
cp .env.example .env
```
Generate new key in .env
```
php artisan key:generate
```
Migrate to create the database table
```
php artisan migrate
```
Run local dev server
```
php artisan serve
```

## Tests are passing
![tests are passing](public/images/test.gif)