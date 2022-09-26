# PHP Router
###### German Documentation
###### Latest Version 1.2

### The project was originally just an exercise. I am making it public anyway

-------------------------------------------------------------------

## Installation
Downloade das Archiv und lade es auf deinen Webserver. Binde es dann mit folgendem Befehl ein.

```php
use Moritz\Route\Route;
require 'path/to/autoload.php';
```

-------------------------------------------------------------------

## .htaccess

```apacheconf
RewriteEngine On

# Redirect Trailing Slashes If Not A Folder
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI} (.+)/$
RewriteRule ^ %1 [L,R]

# Redirect all requests to the index.php
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l

RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
RewriteRule ^\.git – [L,R=404]
```

-------------------------------------------------------------------

## Routen hinzufügen
Die Basis Funktion sieht folgendermaßen aus.

```php
Route::add($uri, $function, $method = 'get');
```

Diese Funktion gibt die jeweilige `RouteElement` Klasse zurück

Praxisbeispiel:
```php
// Klasse einbinden
use Moritz\Route\Route;
require 'router/autoload.php';

// Routen hinzufügen
Route::add('/', 'HomeController');

Route::add('/about', function() {
    echo 'This is the About Page';
}, 'get');

Route::add('/contact', 'HomeController@contact', 'get');

Route::add('/article/create', 'ArticleController@create', 'post');

// Router starten
Route::run();
```

-------------------------------------------------------------------

## Basis Route hinzufügen
Man kann eine Basis Route angeben für den Fall, dass das Projekt nicht im Root liegt.

```php
Route::base('/path/to/project');
```

-------------------------------------------------------------------

## Routen mit Parametern
Parameter werden durch einen Regulären Ausdruck in Klammern erstellt. Die Parameter werden dann automatisch an den Callback übergeben.

```php
Route::add('/user/([0-9]*)/info', function($user_id) {
    echo 'This is User with ID: ' . $user_id;
});

Route::add('/welcome/(.*)', 'WelcomeController@message');

Route::add('/user/create/([a-zA-Z0-9]*)', 'UserCreator', 'post');
```

-------------------------------------------------------------------

## Router starten
Wenn alle Routen registriert wurden, muss der Router gestartet werden.

```php
Route::run();
```

-------------------------------------------------------------------

## Error Routen

```php
Route::error(Route::PATH_NOT_FOUND, function() {
    echo 'Error 404';
});

Route::error(Route::METHOD_NOT_ALLOWED, function() {
    echo 'Error 405';
});

Route::error(Route::FORBIDDEN, function() {
    echo 'Error 403';
});
```
-------------------------------------------------------------------

## Auth Routen
Routen hinter einer gewissen Challenge verstecken

```php
// Auth Klasse einbinden
use Moritz\Route\Auth;

// Auth Challenges erstellen
Auth::make('login', function() {
    if ($_SESSION['logged_id'] === true) {
        return true;
    } else {
        return false;
    }
});

Auth::make('admin', function($user_id) {
    if (Auth::call('login')) {
        if ($user_id === 1) {
            return true;
        } else {
            return false;
        }
    }
});

// Routen mit Auth Challenge registrieren
Route::add('/dashboard', 'UserController@dashboard')->auth('login');

$settings_route = Route::add('/user/settings', 'UserController@settings');
$settings_route->auth('login');

Route::add('/admin', 'AdminController')->auth('admin', [$user_id]);
```
