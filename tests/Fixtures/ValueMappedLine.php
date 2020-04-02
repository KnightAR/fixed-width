<?php

namespace TeamZac\FixedWidth\Tests\Fixtures;

use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class ValueMappedLine extends LineDefinition
{
	protected function fieldDefinitions()
	{
		return [
			Field::make('mapped_value', 1)->map([
				'Y' => true,
				'N' => false,
			]),
		];
	}
}