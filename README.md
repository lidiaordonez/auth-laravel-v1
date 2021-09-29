# auth-laravel-v1

Laravel Authentication using Auth0 (developed for Faith FM projects)

This repo is a composer package created from pre-existing source files to improve authentication file consistency across our Faith FM Laravel+Vue projects.


# Installation

Add the following to your project's `composer.json` file:

```json
{
    ...
    "require": {
        ...
        "faithfm/auth-laravel-v1": "^1.0"
    }
    ...
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/faithfm/auth-laravel-v1"
        }
    ]
    ...
}
```

...then install using:

```bash
$ composer update auth-laravel-v1
$ composer install --prefer-dist
$ php artisan vendor:publish --tag=auth-force-updates --force
```

## Manual changes

### File: `.env`:
Add (replacing credentials with your actual Auth0 details):
```env
AUTH0_DOMAIN=XXXX.au.auth0.com
AUTH0_CLIENT_ID=XXXXXXXXXXXXXXXX
AUTH0_CLIENT_SECRET=XXXXXXXXXXXX
```

### File: `.env.example`:
Add (generic Auth0 example details):
```env
AUTH0_DOMAIN=XXXX.au.auth0.com
AUTH0_CLIENT_ID=XXXXXXXXXXXXXXXX
AUTH0_CLIENT_SECRET=XXXXXXXXXXXX
```

### File: `routes/web.php`:
Add Auth0-related routes:
```php
// Auth0-related routes.   (Replaces Laravel's default auth routes - normally added with a "Auth::routes();" statement.)
Route::get('/auth0/callback', 'Auth\MyAuth0Controller@callback')->name('auth0-callback');
Route::get('/login', 'Auth\Auth0IndexController@login')->name('login');
Route::match(['get', 'post'], '/logout', 'Auth\Auth0IndexController@logout')->name('logout')->middleware('auth');
Route::get('/profile', 'Auth\Auth0IndexController@profile')->name('profile')->middleware('auth');
```

