<?php

namespace TeamZac\FixedWidth\Tests\Fixtures;

use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class TransformedLine extends LineDefinition
{
	protected function fieldDefinitions()
	{
		return [
			Field::make('upper', 5)->transformWith(function($value) {
				return strtoupper($value);
			}),
		];
	}
}
