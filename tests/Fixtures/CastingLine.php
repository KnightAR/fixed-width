<?php

namespace TeamZac\FixedWidth\Tests\Fixtures;

use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class CastingLine extends LineDefinition
{
    protected function fieldDefinitions()
    {
        return [
            Field::make('as_string', 3),
            Field::make('as_int', 3)->asInt(),
            Field::make('as_float', 3)->asFloat(),
            Field::make('as_bool', 3)->asBool(),
        ];
    }
}
