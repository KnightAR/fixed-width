<?php

namespace TeamZac\FixedWidth\Tests\Fixtures;

use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class IgnoreLine extends LineDefinition
{
    protected function fieldDefinitions()
    {
        return [
            Field::ignored('ignored', 6),
            Field::make('kept', 4),
        ];
    }
}
