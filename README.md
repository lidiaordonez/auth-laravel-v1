# auth-laravel-v1

Laravel AuthN+AuthZ (for Faith FM projects):
 * AuthN (Authentication) implemented using Auth0
 * AuthZ (Authorization)  implemented using local user-permissions table (with Laravel/Vue-JS helpers)

This repo is a composer package created to improve consistency across our existing Faith FM Laravel+Vue projects.  (Previously we had been trying to maintain multiple copies of these files across multiple projects).

At present, Laravel Artisan's vendor-publishing functionality is simply being used to clone a set of consistent files across our projects.


## Installation

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

...then install using the following commands:

```bash
composer update faithfm/auth-laravel-v1
php artisan vendor:publish  ??? specify package??
php artisan migrate ?????
```

## Updating the package

```bash
composer update faithfm/auth-laravel-v1
php artisan vendor:publish --tag=auth-force-updates --force
```

## Usage

* Define permissions the app will use in `Repositories/AuthPermissionsRepository.php`.

* Add relevant permissions for each user in the "user_permissions" table.
  * Note: the restrictions column is a JSON field that can be used to define specific restrictions/qualifications to a privilege.  Ie: our Media project uses 'filter' and 'fields' to restrict users to editing specific files/fields.

* In the backend check for permissions in the same way you would any other gate - ie:

Simple permission checks:
```php
Gate::allows('use-app');            // simple test  (???untested)
Gate::authorize('use-app');         // route definitions
$this->middleware('can:use-app');   // controller constructors
@can('use-app')                     // blade templates
```

More complex restrictions check/filtering:  (no actual examples but will be something like - TOTALLY UNTESTED - probably should create helper class like we have in front-end)
```php
if (Gate::allows('use-app'))
  if (auth()->user()->permissions->restrictions['file'] == 'restrictedfile')
    // ALLOW/DENY STUFF FROM HAPPENING
```

* If user permissions are passed from back-end to front-end using our "global javascript `LaravelAppGlobals` variable passed from Blade file" design pattern, a provided `LaravelUserPermissions.js` helper library provides two functions to check permissions - by assuming the existence of the global `LaravelAppGlobals.user.permissions` property:

Simple permission checks:
```javascript
import { laravelUserCan } from "../LaravelUserPermissions";
if (laravelUserCan("use-app"))
  // ALLOW STUFF TO HAPPEN
```

More complex restrictions check/filtering
```javascript
import { laravelUserRestrictions } from "../LaravelUserPermissions";
const restrictions = laravelUserRestrictions("use-app");
if (restrictions.status == "NOT PERMITTED")
  // PREVENT STUFF FROM HAPPENING
if (restrictions.status == "ALL PERMITTED")
  // UNFILTERED ACCESS
if (restrictions.status == "SOME PERMITTED") {
  // PARTIAL/FILTERED ACCESS BASED ON RESTRICTIONS JSON DATA - IE: ASSUMING 'filter' field
  if (currentItem.startsWith(restrictions.filter)
    // DO STUFF IF FILTER ALLOWS
```


## Architecture

* Files to be cloned/force-published are found in the "clone" folder - with a structure matching target folders of the target project.

* Assumes that Laravel Auditing on all models.

* In the future, it is anticipated that some variations may be required between projects.  At this time the simplistic cloned/force-publish deploy method will need to be replaced by a more sophisticated approach - ie: using Laravel Traits / parent Classes, etc.  At this time, the number of files in the "clone" folder will reduce and be replaced by new files in the "src" folder.


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

### File: `config/auth.php`:
Replace the default 'eloquent' users provider with our 'auth0 provider:
```php
    'providers' => [
        'users' => [
            'driver' => 'auth0',
            'model' => App\Models\User::class,
        ],
        // 'users' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\User::class,
        // ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
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

### Passing LaravelAppGlobals to front-end:

MISSING DOCUMENTATION !!!!!!!!!
Document the process of passing this to the front-end in either a blade file, controller, or web.php.


### Existing projects - need to remove on installation:

* routes/web.php - Auth0 stuff
* config/app.php - Auth0\Login\LoginServiceProvider::class,
* app/Providers/AuthServiceProvider.php - all defined-permission stuff
* app/Providers/AppServiceProvider.php - Auth0 + CustomUserRepository bindings

### NOTES:

* We're manually adding (double-up) lots of packages' ServicesProviders in config/app.php - that are automatically registered by their own composer.json / extras section.  (Ie: AuditingServiceProvider).  Need to audit/cleanup.