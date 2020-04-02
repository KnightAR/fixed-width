<?php

namespace TeamZac\FixedWidth\Tests\Fixtures;

use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class FillerLine extends LineDefinition
{
    protected function fieldDefinitions()
    {
        return [
            Field::filler(1, 2, 2),
            Field::make('value', 5),
            Field::filler(5),
        ];
    }
}
