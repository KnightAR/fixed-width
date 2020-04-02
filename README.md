# A lightweight package to make parsing fixed-width text files a bit easier

[![Latest Version on Packagist](https://img.shields.io/packagist/v/teamzac/fixed-width.svg?style=flat-square)](https://packagist.org/packages/teamzac/fixed-width)
[![Build Status](https://img.shields.io/travis/teamzac/fixed-width/master.svg?style=flat-square)](https://travis-ci.org/teamzac/fixed-width)
[![Quality Score](https://img.shields.io/scrutinizer/g/teamzac/fixed-width.svg?style=flat-square)](https://scrutinizer-ci.com/g/teamzac/fixed-width)
[![Total Downloads](https://img.shields.io/packagist/dt/teamzac/fixed-width.svg?style=flat-square)](https://packagist.org/packages/teamzac/fixed-width)

Parsing fixed with files isn't much fun. This package provides a fluent, object-oriented way to define what your source file looks like. It then uses that definition to parse the file and return the results to you in a format that's convenient to use.

## Features:

### Value casting 
Easily cast the raw value to a string, int, float, or bool value.

### Value mapping
Provide a key-value array that will map your source data to a more helpful destination data. For example, 'T' and 'F' can become ```true``` and ```false```, respectively. Convert coded data to the correct foreign key for some related database table. Whatever you need to do, really.

### Transform callbacks
If you need more fine-grained control over how the data is transformed from source, you can specify a callback function.

### Filler and ignored fields
If your source data has filler fields or fields you don't care about, you can easily account for them without muddying up your parsed results.

### Nested Results
Using dot notation, you can nest your parsed results.

## Installation

You can install the package via composer:

```bash
composer require teamzac/fixed-width
```

## Usage
The ```FixedWidthParser``` handles parsing a given file path once you provide it with a LineDefinition class.

``` php
$parsedLines = FixedWidthParser::make()
	->using(/** LineDefinitionClass */)
	->parse(/** filename */)
	->all();
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email chad@zactax.com instead of using the issue tracker.

## Credits

- [Chad Janicek](https://github.com/teamzac)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).