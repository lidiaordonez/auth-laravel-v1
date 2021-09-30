# auth-laravel-v1

Laravel AuthN+AuthZ methodology (for Faith FM projects):
 * Authentication using Auth0
 * Authorization using local user-permissions table (with Laravel/Vue-JS helpers)

This repo is a composer package created to improve authentication file consistency across existing Faith FM Laravel+Vue projects.  (Previously we had been trying to maintain multiple copies of these files across multiple projects).

At present, Laravel artisan's "publish" functionality is simply being used to clone a set of consistent files across our projects.  

Note: In the future, it is anticipated that variations (for some of these files) may be required between projects, and at this time this simplistic "force-publish" deploy method will need to be replaced by more sophisticated approach using Laravel Traits / parent Classes, etc.


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

...then install/update using the following commands:

```bash
composer update faithfm/auth-laravel-v1
php artisan vendor:publish --tag=auth-force-updates --force
```

## Architecture

* Files to be cloned/force-published are found in the Clone folder - with a structure matching target folders of the target project


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

