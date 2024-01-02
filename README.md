# GTIN / EAN / UPC Validation for Laravel

![PHP version][ico-php-version]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Tests][ico-tests]][link-tests]
[![Code style][ico-code-style]][link-code-style]
[![Total Downloads][ico-downloads]][link-downloads]

Extension for the Laravel validation class.

## Installation

You can install the package via composer:

```bash
$ composer require mvdnbrk/gtin
```

## Usage

Now you can use the `gtin` validation to validate a GTIN-8, GTIN-12, GTIN-13 or GTIN-14:

```php
$this->validate($request, [
    'somefield' => 'gtin',
]);
```

### Specifying a custom error message

You may publish the language files with the following `artisan` command:

```bash
php artisan vendor:publish --tag=gtin-lang
```

Now you can customize the error message in `resources/lang/vendor/gtin/{loale}/validation.php`.

Another option is to define the error message by adding your message to the `custom` array in the `resources/lang/{locale}/validation.php` language file.

```php
'custom' => [
    'somefield' => [
        'gtin' => 'Please enter a valid GTIN!',
    ],
],
```

 Or with a JSON file stored in `resources/lang/{locale}.json`

```javascript
{
    "validation.custom.somefield.gtin": "Please enter a valid GTIN!"
}
```

Or you may pass custom messages as the third argument to the `Validator::make` method as described in the [Laravel documentation](https://laravel.com/docs/validation#custom-error-messages).

### Helper function

This package exposes a `is_gtin()` helper function to quickly validate a GTIN.  
It will return a `boolean` whether the given value is a valid GTIN or not:

```php
is_gtin('1300000000000')    // returns true
is_gtin('1234567891234')    // returns false
```

### Migrations

This package contains a helper method to create a GTIN column in your database table:

```php
Schema::table('products', function (Blueprint $table) {
    $table->gtin();
});
```

If you would like to customize the column name and/or length you may pass these as parameters:

```php
$table->gtin('ean13', 13);
```

To drop the column you may use the `dropGtin` method:

```php
Schema::table('products', function (Blueprint $table) {
    $table->dropGtin();
    
    // $table->dropGtin('ean13');
});
```

## Testing

```bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

Package forked from [mvdnbrk/gtin](https://github.com/mvdnbrk/gtin). Package updated for Laravel 10 / PHP 8.x as per [roerlemans/gtin](https://github.com/roerlemans/gtin).

- [Mark van den Broek][link-author]
- [Ron Oerlemans][link-roerlemans]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-php-version]: https://img.shields.io/packagist/php-v/mvdnbrk/gtin?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/mvdnbrk/gtin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-tests]: https://img.shields.io/github/workflow/status/mvdnbrk/gtin/tests/main?label=tests&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mvdnbrk/gtin.svg?style=flat-square
[ico-code-style]: https://github.styleci.io/repos/91986121/shield?style=flat-square&branch=main 

[link-packagist]: https://packagist.org/packages/mvdnbrk/gtin
[link-tests]: https://github.com/mvdnbrk/gtin/actions?query=workflow%3Atests
[link-downloads]: https://packagist.org/packages/mvdnbrk/gtin
[link-code-style]: https://github.styleci.io/repos/91986121
[link-author]: https://github.com/mvdnbrk
[link-roerlemans]: https://github.com/roerlemans
[link-contributors]: ../../contributors
