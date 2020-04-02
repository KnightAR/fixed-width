<?php

namespace TeamZac\FixedWidth;

use Illuminate\Support\Arr;

class LineDefinition
{
	/** @var array */
	protected $attributes = [];

	public function __construct(string $rowText)
	{
		$this->parseRowText($rowText);
	}

	/**
	 * Return the attributes
	 */
	public function toArray()
	{
		return $this->attributes;
	}

	/**
	 * Provide a convenient way to access the attributes
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * If you need to access a nested property, you can use
	 * this method instead of the magic method above
	 */
	public function get($key)
	{
		return Arr::get($this->attributes, $key);
	}

	/** 
	 * Return an array of Field objects that defines how the string should be parsed
	 *
	 * @return Field[]
	 */
	protected function fieldDefinitions()
	{
		return [];
	}

	/** 
	 * Parse the row based on the field definitions
	 *
	 * @param 	string $rowText
	 */
	protected function parseRowText($rowText)
	{
		$columnPointer = 0;
		foreach ($this->fieldDefinitions() as $field) {
			if ($field->shouldBeIncluded()) {
				Arr::set(
					$this->attributes, 
					$field->getKey(), 
					$field->getCastedValue(substr($rowText, $columnPointer, $field->getLength()))
				);
			}

			$columnPointer += $field->getLength();
		}
	}
}
