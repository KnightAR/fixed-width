<?php

namespace TeamZac\FixedWidth\Tests;

use Orchestra\Testbench\TestCase;
use TeamZac\FixedWidth\Exceptions\CouldNotParseException;
use TeamZac\FixedWidth\Field;
use TeamZac\FixedWidth\FixedWidthParser;
use TeamZac\FixedWidth\FixedWidthServiceProvider;
use TeamZac\FixedWidth\LineDefinition;
use TeamZac\FixedWidth\Tests\Fixtures\CastingLine;
use TeamZac\FixedWidth\Tests\Fixtures\ExplodedLine;
use TeamZac\FixedWidth\Tests\Fixtures\FillerLine;
use TeamZac\FixedWidth\Tests\Fixtures\FullTestLine;
use TeamZac\FixedWidth\Tests\Fixtures\IgnoreLine;
use TeamZac\FixedWidth\Tests\Fixtures\SimpleLine;
use TeamZac\FixedWidth\Tests\Fixtures\TransformedLine;
use TeamZac\FixedWidth\Tests\Fixtures\ValueMappedLine;

class ParsingTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [FixedWidthServiceProvider::class];
    }
    
    /** @test */
    public function it_splits_fixed_width_files_based_on_the_definition()
    {
        $rowText = '  A  B  C';

        $line = (new SimpleLine)->parse($rowText);

        $this->assertSame('A', $line->get('a'));
        $this->assertSame('B', $line->get('b'));
        $this->assertSame('  C', $line->get('c'));
    }
    
    /** @test */
    public function it_casts_the_raw_values()
    {
        $rowText = '  1  23.0  1';

        $line = (new CastingLine)->parse($rowText);

        $this->assertSame('1', $line->get('as_string'));
        $this->assertSame(2, $line->get('as_int'));
        $this->assertSame(3.0, $line->get('as_float'));
        $this->assertSame(true, $line->get('as_bool'));
    }
    
    /** @test */
    public function it_uses_a_value_map()
    {
        $rowText = 'Y';
        $line = (new ValueMappedLine)->parse($rowText);
        $this->assertSame(true, $line->get('mapped_value'));

        $rowText = 'N';
        $line = (new ValueMappedLine)->parse($rowText);
        $this->assertSame(false, $line->get('mapped_value'));
    }

    /** @test */
    public function it_can_explode_a_value()
    {
        $rowText = 'C12,C13,C20           ';
        $line = (new ExplodedLine)->parse($rowText);
        $this->assertSame([
            'C12', 'C13', 'C20',
        ], $line->get('codes'));
    }

    /** @test */
    public function it_can_transform_a_value()
    {
        $rowText = 'lower';
        $line = (new TransformedLine)->parse($rowText);
        $this->assertSame('LOWER', $line->get('upper'));
    }
    
    /** @test */
    public function it_allows_filler_fields()
    {
        $rowText = '     12345     ';

        $line = (new FillerLine)->parse($rowText);
        $this->assertCount(1, $line->toArray());
    }
    
    /** @test */
    public function it_allows_ignored_fields()
    {
        $rowText = 'IGNOREKEEP';

        $line = (new IgnoreLine)->parse($rowText);
        $this->assertCount(1, $line->toArray());
        $this->assertSame([
            'kept' => 'KEEP',
        ], $line->toArray());
    }

    /** @test */
    public function it_allows_anonymous_field_definitions()
    {
        $values = FixedWidthParser::make()
            ->parse(__DIR__.'/Fixtures/test-file.txt')
            ->using([
                Field::int('id', 5),
                Field::make('name', 10),
                Field::make('email', 20),
                Field::make('active', 1)->map([
                    'y' => true,
                    'n' => false
                ]),
                Field::make('favorite_colors', 20)->explode('|'),
                Field::float('salary', 9),
                Field::make('address.uppercased', 20)->transformWith(function($value) {
                    return strtoupper($value);
                }),
            ])
            ->all();

        $this->assertCount(2, $values);
        tap($values[0], function($first) {
            $this->assertSame(1, $first->id);
            $this->assertSame('DOE, JOHN', $first->name);
            $this->assertSame('JOHN@DOE.COM', $first->email);
            $this->assertTrue($first->active);
            $this->assertSame([
                'blue', 'red'
            ], $first->favorite_colors);
            $this->assertSame(100000.0, $first->salary);
            $this->assertSame('100 MAIN STREET', $first->get('address.uppercased'));
        });
    }

    /** @test */
    public function it_parses_from_a_file()
    {
        $values = FixedWidthParser::make()
            ->using(FullTestLine::class)
            ->parse(__DIR__.'/Fixtures/test-file.txt')
            ->all();

        $this->assertCount(2, $values);
        tap($values[0], function($first) {
            $this->assertSame(1, $first->id);
            $this->assertSame('DOE, JOHN', $first->name);
            $this->assertSame('JOHN@DOE.COM', $first->email);
            $this->assertTrue($first->active);
            $this->assertSame([
                'blue', 'red'
            ], $first->favorite_colors);
            $this->assertSame(100000.0, $first->salary);
            $this->assertSame('100 MAIN STREET', $first->get('address.uppercased'));
        });
    }

    /** @test */
    public function it_throws_an_exception_if_no_file_is_provided()
    {
        try {
            $values = FixedWidthParser::make()
                ->using(FullTestLine::class)
                // ->parse(__DIR__.'/Fixtures/test-file.txt')
                ->all();
        } catch (CouldNotParseException $e) {
            $this->assertSame('You must set a filename before parsing can occur. Be sure to call the parse() method.', $e->getMessage());
            return;
        }

        $this->fail('Expected an exception because no file was provided');
    }

    /** @test */
    public function it_throws_an_exception_if_no_line_definition_is_provided()
    {
        try {
            $values = FixedWidthParser::make()
                // ->using(FullTestLine::class)
                ->parse(__DIR__.'/Fixtures/test-file.txt')
                ->all();
        } catch (CouldNotParseException $e) {
            $this->assertSame('You must provide a line definition with the using() method before parsing can occur.', $e->getMessage());
            return;
        }

        $this->fail('Expected an exception because no file was provided');
    }
}
