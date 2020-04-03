<?php

namespace TeamZac\FixedWidth;

class AnonymousLineDefinition extends LineDefinition
{
	/** @var array */
	protected $definitions = [];

	public function __construct($definitions = [])
	{
		$this->definitions = $definitions;
	}

	/** 
	 * @{inheritdoc}
	 */
	protected function fieldDefinitions()
	{
		return $this->definitions;
	}
}
