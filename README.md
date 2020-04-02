
# A lightweight package to make parsing fixed-width text files a bit easier

[![Latest Version on Packagist](https://img.shields.io/packagist/v/teamzac/fixed-width.svg?style=flat-square)](https://packagist.org/packages/teamzac/fixed-width)

Parsing fixed with files isn't much fun. It often involves a lot of procedural code that is a pain to write and maintain. This package provides a fluent, object-oriented way to define what your source file looks like. It then uses that definition to parse the file and return the results to you in a format that's convenient to use.

## Features:

- Value casting 
Easily cast the raw value to a string, int, float, or bool value.

- Value mapping
Provide a key-value array that will map your source data to a more helpful destination data. For example, 'T' and 'F' can become ```true``` and ```false```, respectively. Convert coded data to the correct foreign key for some related database table. Whatever you need to do, really.

- Transform callbacks
If you need more fine-grained control over how the data is transformed from source, you can specify a callback function.

- Filler and ignored fields
If your source data has filler fields or fields you don't care about, you can easily account for them without muddying up your parsed results.

- Nested Results
Using dot notation, you can nest your parsed results.

## Installation

You can install the package via composer:

```bash
composer require teamzac/fixed-width
```

There is a facade available for Laravel users. This package uses auto-discovery for Laravel 5.5+.

## Usage
The ```FixedWidthParser``` class handles parsing a given file path once you provide it with a LineDefinition class.

``` php
$lines = FixedWidthParser::make()
	->using(/** LineDefinitionClass */)
	->parse(/** filename */)
	->all();

// $lines will be an array of TeamZac\FixedWidth\ParsedLine objects
```

If you have a larger file and prefer not to keep everything in memory, you can use the ```each()``` method instead:

``` php
use TeamZac\FixedWidth\ParsedLine;

$parsedLines = FixedWidthParser::make()
	->using(/** LineDefinitionClass */)
	->parse(/** filename */)
	->each(function(ParsedLine $line) {
		// you'll get each line one at a time
	});
```

The ```ParsedLine``` object contains the results from parsing a single line of your source file. You can access the values as properties on the object (via magic methods) or via the ```get()``` method, which is helpful if you have nested values. You can also call ```toArray()``` to return the raw values as an associative array.

The ```FullWidthParser``` uses ```LineDefinition``` objects to know how to parse a given file. You can create your own definition objects by extending ```TeamZac\FixedWidth\LineDefinition``` and overriding the ```fieldDefinitions()``` method:

``` php
use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class MyCustomLineDefinition extends LineDefinition
{
	protected function fieldDefinitions()
	{
		return [
			Field::make('id', 5),
			Field::make('name', 20),
			Field::make('email', 50),
		];
	}
}
```

The ```fieldDefinitions()``` method simply returns an array of ```TeamZac\FixedWidth\Field``` objects. These ```Field``` objects are how you define how your source files should be parsed. There are 3 options for creating a new ```Field```:

```php
// The $key is the key you'll use to access this field
// The $length is the number of characters for this field
Field::make($key, $length)
```

The ```$key``` can be a simple string for a flattened array, or you can use dot notation to nest your parsed results:

```php
[
	Field::make('name', 10),
	Field::make('address.street', 20),
	Field::make('address.city', 20),
	Field::make('address.state', 10),
]

// produces
[
	'name' => 'Jane Doe',
	'address' => [
		'street' => '100 Main Street',
		'city' => 'Anytown',
		'state' => 'Florida',
	]
]
```

If you have filler fields in your source data, you can easily account for them:

```php
Field::filler($length);
```

Filler Fields will simply be ignored. If your source data has multiple filler fields consecutively, that's easy, too (unless you want to do the math yourself, which you're welcome to do).
```php
Field::filler(10, 10, 20);
```

Of course, you can use a filler field to ignore any content you don't care about, but if you have a very long file to parse, it may be difficult to keep track of where you are. Sometimes, it's helpful to give names to fields even if you don't care to have them in your final results.

```php
Field::ignored('who cares about this field?', $length);
```

Just like Filler Fields, Ignored fields will not be included in your parsed values.

### Fluent Field Options

You can fluently apply a variety of options to the new Field object. For example, you can choose whether you want the value to be ```trim```med or not (by default, all values get trimmed):

```php
Field::make('user_id', 10)->untrimmed()
```

You can cast the value from a string to something else:

```php
Field::make('user_id', 10)->asInt()
Field::make('latitude', 10)->asFloat()
Field::make('is_active', 1)->asBool()
```

Sometimes your source data may have coded values that you wish to replace with something more appropriate for your domain. 

```php
// source data of Y will become true, N will become false
Field::make('is_confidential', 1)->map([
	'Y' => true,
	'N' => false,
])
```

If you need to do some other transformation on the data before you store it, you can provide a callback function:

```php
// convert the address field to all uppercase, because why not?
Field::make('address', 20)->transformWith(function($value) {
	return strtoupper($value);
})
```

It may not happen often, but we have come across delimited fields within a fixed-width data file. You could use the ```transformWith()``` method to split these, but we also have a convenient ```explode()``` method if you prefer:

```php
// source: green,blue,red
Field::make('favorite_colors', 20)->explode(',')

// returns
[
	'favorite_colors' => [
		'green', 
		'blue',
		'red'
	]
]
```

## Todo

- Allow casting to date with user-specified date format
- Allow anonymous LineDefinitions, rather than requiring a dedicated class
- Allow a callback for the ignore() function so you could dynamically choose whether to ignore certain fields? Not sure if that will be useful.

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email chad@zactax.com instead of using the issue tracker.

## Credits

- [Chad Janicek](https://github.com/teamzac)
- [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
