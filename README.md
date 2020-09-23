![Build](https://travis-ci.com/azibom/-azibom-whoAreYou.svg?branch=master)
# who-are-you
Laravel api authentication package
# Instalation
### Step one
Install the package, run the migration, initialize the passport  
```
composer require azibom/who-are-you
php artisan migrate
php artisan passport:install
```

### Step two
1. Add the HasApiTokens trait to the user model
```php
<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

```
2. Change the api guard in the config/auth.php
```php
...
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
    ],
...
```
3. Add the WHO_ARE_YOU_BASE_URL env var in the .env file of the project
```
WHO_ARE_YOU_BASE_URL=http://localhost
```
(If you are using docker for example you should change it with your webserver container's name for example)
```
WHO_ARE_YOU_BASE_URL=http://nginx
```
# Todos
#### □ complete the doc (add the document for the routes and how to use it)
#### □ add the push to the vendor for the controller and repositoy directories
#### □ try to handle the above changes automaticly in the package (change the .env or auth.config filr)
#### □ just send the data of the request to the repositoty not the whole of the request
#### □ add the test to the project
#### □ add the phpcs to the project
#### □ add the ci/cd pipline to the project
