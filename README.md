# Laravel Redirector

A Laravel package for managing URL redirects easily and efficiently.

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
    - [Middleware](#middleware)
    - [Artisan Commands](#artisan-commands)
    - [Controller and Views](#controller-and-views)
    - [Custom Implementation](#custom-implementation)
- [Caching](#caching)
- [Testing](#testing)
- [License](#license)

## Installation

You can install the package via Composer:

```bash
composer require 1970mr/laravel-redirector
```

Next, you need to publish the migration and the config file:

```bash
php artisan vendor:publish --provider="Mr1970\LaravelRedirector\RedirectorServiceProvider"
```

Run the migrations to create the necessary database table:

```bash
php artisan migrate
```

## Configuration

The package provides a configuration file where you can manage various settings, including caching methods and TTL (Time-To-Live). These settings allow you to optimize the performance and scalability of your redirects. Refer to the `config/redirector.php` file for more details.

## Usage

### Middleware

To use the redirect middleware, you can apply it to specific routes, groups of routes, or add it globally to the HTTP kernel middleware stack.

#### Specific Routes

```php
use Mr1970\LaravelRedirector\Middlewares\HandleRedirects;

Route::middleware([HandleRedirects::class])->group(function () {
    // Your routes here
});
```

#### Global Middleware

In Laravel 11, you can add middleware globally in your `bootstrap/app.php` file:

```php
->withMiddleware(function (Middleware $middleware) {
     $middleware->append(\Mr1970\LaravelRedirector\Middlewares\HandleRedirects::class);
})
```

#### Alias Middleware

You can use the middleware by its alias or by the class name in your routes:

```php
// Using alias
Route::middleware(['redirector'])->group(function () {
    // Your routes here
});

// Using class name
Route::middleware([\Mr1970\LaravelRedirector\Middlewares\HandleRedirects::class])->group(function () {
    // Your routes here
});
```

### Artisan Commands

The package provides several Artisan commands to manage redirects:

#### Create Redirect

To create a redirect, you can use the `redirect:create` Artisan command. This command allows you to specify the source URL, destination URL, status code, and whether the redirect is active.

```bash
php artisan redirect:create {source_url} {destination_url} {status_code=301} {is_active=1}
```

##### Examples

1. Redirect from `/old-page` to `/new-page` with a 301 status code and set it as active:

    ```bash
    php artisan redirect:create /old-page /new-page 301 1
    ```

2. Redirect from `/specific-page` to `https://google.com` with a 301 status code and set it as active:

    ```bash
    php artisan redirect:create /specific-page https://google.com 301 1
    ```

#### Update Redirect

To update an existing redirect, you can use the `redirect:update` Artisan command:

```bash
php artisan redirect:update {source_url} {destination_url} {status_code=301} {is_active=1}
```

##### Example

Update the redirect from `/old-page` to `/new-destination` with a 302 status code and set it as active:

```bash
php artisan redirect:update /old-page /new-destination 302 1
```

#### Delete Redirect

To delete a redirect, use the `redirect:delete` Artisan command:

```bash
php artisan redirect:delete {source_url}
```

##### Example

Delete the redirect from `/old-page`:

```bash
php artisan redirect:delete /old-page
```

#### List Redirects

To list all configured redirects, use the `redirect:list` Artisan command:

```bash
php artisan redirect:list
```

### Controller and Views

You can also set up a more customizable CRUD interface for redirects using controllers, requests, routes, and views. The package provides a command to scaffold these components:

```bash
php artisan redirector:install
```

This command will install the necessary controllers, requests, routes, and views for managing redirects through a web interface.

### Custom Implementation

Additionally, you can use the Redirect model directly to create, update, or delete redirects within your application code as needed. This approach allows for complete customization of how and where redirects are managed.

## Caching

The package supports two caching methods:

- **Full List**: All active redirects are cached as a single collection. This method is efficient for a small number of redirects but may become inefficient as the number of redirects grows. Any create, update, or delete operation will reset the entire list cache.
- **Single**: Each redirect is cached individually. This method scales better with a large number of redirects but may result in more cache operations. Only the specific cached item is reset during create, update, or delete operations.

You can configure the caching method and TTL in the `config/redirector.php` file to suit your application's needs.

## Testing

To run the tests for the package, use the following command:

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
