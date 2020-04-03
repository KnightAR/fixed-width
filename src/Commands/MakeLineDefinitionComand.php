<?php

namespace TeamZac\Workflow\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeLineDefinitionCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fixed-width:make-line';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new fixed width line definition class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'LineDefinition';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/line-definition.stub';
    }
}