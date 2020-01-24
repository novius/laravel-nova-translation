# Nova translations manager
[![Travis](https://img.shields.io/travis/novius/laravel-nova-translation.svg?maxAge=1800&style=flat-square)](https://travis-ci.org/novius/laravel-nova-translation)
[![Packagist Release](https://img.shields.io/packagist/v/novius/laravel-nova-translation.svg?maxAge=1800&style=flat-square)](https://packagist.org/packages/novius/laravel-nova-translation)
[![Licence](https://img.shields.io/packagist/l/novius/laravel-nova-translation.svg?maxAge=1800&style=flat-square)](https://github.com/novius/laravel-nova-translation#licence)

A Nova tool to manage application's translations. This package uses [novius/laravel-translation-loader](https://github.com/novius/laravel-translation-loader/).

## Requirements

* PHP >= 7.2
* Laravel Nova >= 2.0
* Laravel Framework >= 5.8

## Installation

**Step 1 :**

```sh
composer require novius/laravel-nova-translation:dev-master
```

**Step 2 :**
 
Follow instructions of [novius/laravel-translation-loader](https://github.com/novius/laravel-translation-loader/#installation)

**Step 3 :**

Publish languages files:

```bash
php artisan vendor:publish --provider="Novius\LaravelNovaTranslation\LaravelNovaTranslationServiceProvider" --tag="lang"
```

### Configuration

Some options that you can override are available.

```sh
php artisan vendor:publish --provider="Novius\LaravelNovaTranslation\LaravelNovaTranslationServiceProvider" --tag="config"
```

## Lint

Run php-cs with:

```sh
composer run-script lint
```

## Contributing

Contributions are welcome!
Leave an issue on Github, or create a Pull Request.


## Licence

This package is under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) or (at your option) any later version.
