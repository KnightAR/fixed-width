<?php

namespace TeamZac\FixedWidth;

use TeamZac\FixedWidth\Exceptions\CouldNotParseException;

class FixedWidthParser
{
    /** @var string */
    protected $rowClass;

    /** @var string */
    protected $filepath;

    /**
     * Static constructor
     */
    public static function make()
    {
        return new static();
    }

    /**
     * Set the row parser to use 
     *
     * @param 	string $rowClass
     * @return 	$this
     */
    public function using($rowClass)
    {
    	$this->rowClass = $rowClass;
    	return $this;
    }

    /** 
     * Set the path of the file to parse
     *
     * @var string $filepath
     * @return $this
     */
    public function parse($filepath)
    {
        $this->filepath = $filepath;
        return $this;
    }

    /**
     * Get all records in one swoop. If your file isn't
     * too large, you might choose to use this method
     * instead of iterating one at a time.
     *
     * @return array
    */
    public function all()
    {
        $values = [];

        $this->each(function($line) use (&$values) {
            $values[] = $line;
        });

        return $values;
    }

    /** 
     * Parse the file and return each record one at a time.
     * Definitely use this for larger files instead of all()
     *
     * @param 	Callable $callback
     */
    public function each($callback) 
    {
        if (is_null($this->filepath)) {
            throw CouldNotParseException::noFile();
        }

        if (is_null($this->rowClass)) {
            throw CouldNotParseException::noLineDefinition();
        }

    	$file = fopen($this->filepath, 'r');
        $lineDefinition = new $this->rowClass();
    	while ($line = fgets($file)) {
    		$row = $lineDefinition->parse($line);

    		$callback($row);
    	}
    	fclose($file);
    }
}
