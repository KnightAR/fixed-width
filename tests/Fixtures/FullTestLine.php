<?php

namespace TeamZac\FixedWidth\Tests\Fixtures;

use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class FullTestLine extends LineDefinition
{
    protected function fieldDefinitions()
    {
        return [
            Field::make('id', 5)->asInt(),
            Field::make('name', 10),
            Field::make('email', 20),
            Field::make('active', 1)->map([
            	'y' => true,
            	'n' => false
            ]),
            Field::make('favorite_colors', 20)->explode('|'),
            Field::make('salary', 9)->asFloat(),
            Field::make('address.uppercased', 20)->transformWith(function($value) {
            	return strtoupper($value);
            }),
        ];
    }
}
