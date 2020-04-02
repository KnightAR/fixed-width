<?php

namespace TeamZac\FixedWidth\Tests\Fixtures;

use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\LineDefinition;

class SimpleLine extends LineDefinition
{
    protected function fieldDefinitions()
    {
        return [
            Field::make('a', 3),
            Field::make('b', 3),
            Field::make('c', 3)->untrimmed(),
        ];
    }
}