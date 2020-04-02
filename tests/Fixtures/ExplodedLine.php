<?php

namespace TeamZac\FixedWidth\Tests\Fixtures;

use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class ExplodedLine extends LineDefinition
{
	protected function fieldDefinitions()
	{
		return [
			Field::make('codes', 20)->explode(','),
		];
	}
}
