# PHP_Laravel12_World
```php
Laravel 12 based project demonstrating Country & City management
using Blade based Browser UI
```
# STEP 1: Install Laravel 12 – Create Project
Open Terminal / CMD:
```php
composer create-project laravel/laravel:^12.0 PHP_Laravel12_World
```
Move into project folder:
```php
cd PHP_Laravel12_World
```
Generate application key:
```php
php artisan key:generate
```
# STEP 2: Setup Database (.env File)
Open .env file and configure database:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=laravel_world
DB_USERNAME=root
DB_PASSWORD=
```

Create database in MySQL / phpMyAdmin:
```php
CREATE DATABASE laravel_world;
```
Run default migrations:
```php
php artisan migrate
```
# STEP 3: Create Country & City Models
Create Country Model with Migration
```php
php artisan make:model Country -m
```
Create City Model with Migration
```php
php artisan make:model City -m
```
Run migrations:
```php
php artisan migrate
```
# STEP 4: Define Model Relationships
Country Model
```php
Path: app/Models/Country.php
```
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
```
City Model
```php
Path: app/Models/City.php
```
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['country_id', 'name'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
```
# STEP 5: Create Controllers
Create controllers:
 ```php
php artisan make:controller CountryController
php artisan make:controller CityController
```
# STEP 6: Define Web Routes
Path: routes/web.php
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;

Route::get('/', function () {
    return redirect('/countries');
});

Route::resource('countries', CountryController::class)->only(['index','create','store']);
Route::resource('cities', CityController::class)->only(['index','create','store']);
```
# STEP 7: Blade UI Structure
Folder Structure
```php
resources/views/
 ├── layout/
 │   └── app.blade.php
 ├── country/
 │   ├── index.blade.php
 │   └── create.blade.php
 └── city/
     ├── index.blade.php
     └── create.blade.php
```
# STEP 8: Run Laravel Project
Start development server:
```php
php artisan serve
```
Open browser:
```php
http://127.0.0.1:8000
```
<img width="1301" height="551" alt="image" src="https://github.com/user-attachments/assets/138bef7e-a3df-4b95-9af0-6daa6329fb00" />
<img width="1306" height="459" alt="image" src="https://github.com/user-attachments/assets/ee2f82da-04ff-4eed-a642-d80740a7c7d6" />
<img width="1350" height="612" alt="image" src="https://github.com/user-attachments/assets/5af44049-2db8-49ee-93ea-e2442496e11d" />
<img width="1328" height="476" alt="image" src="https://github.com/user-attachments/assets/d0dcaa6a-80ed-495a-bd5b-f4bb2edaa205" />

# Project Folder Structure
```php
PHP_Laravel12_World
├── app
│   ├── Http
│   │   └── Controllers
│   │       ├── CountryController.php
│   │       └── CityController.php
│   └── Models
│       ├── Country.php
│       └── City.php
│
├── database
│   └── migrations
│       ├── create_countries_table.php
│       └── create_cities_table.php
│
├── resources
│   └── views
│       ├── layout
│       │   └── app.blade.php
│       ├── country
│       │   ├── index.blade.php
│       │   └── create.blade.php
│       └── city
│           ├── index.blade.php
│           └── create.blade.php
│
├── routes
│   └── web.php
│
├── .env
├── artisan
└── README.md
```


