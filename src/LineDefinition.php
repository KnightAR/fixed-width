<?php

namespace TeamZac\FixedWidth;

use Illuminate\Support\Arr;

class LineDefinition
{
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
	public function parse($rowText)
	{
		$columnPointer = 0;
		$attributes = [];
		foreach ($this->fieldDefinitions() as $field) {
			if ($field->shouldBeIncluded()) {
				Arr::set(
					$attributes, 
					$field->getKey(), 
					$field->getCastedValue(substr($rowText, $columnPointer, $field->getLength()))
				);
			}

			$columnPointer += $field->getLength();
		}

		return new ParsedLine($attributes);
	}
}
