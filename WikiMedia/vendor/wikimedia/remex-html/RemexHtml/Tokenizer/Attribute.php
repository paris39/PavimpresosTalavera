<?php

namespace RemexHtml\Tokenizer;
use RemexHtml\PropGuard;

/**
 * A namespaced attribute, as returned by Attributes::getObjects()
 */
class Attribute {
	public $qualifiedName;
	public $namespaceURI;
	public $prefix;
	public $localName;
	public $value;

	public function __construct( $qualifiedName, $namespaceURI, $prefix, $localName, $value ) {
		$this->qualifiedName = $qualifiedName;
		$this->namespaceURI = $namespaceURI;
		$this->prefix = $prefix;
		$this->localName = $localName;
		$this->value = $value;
	}

	public function __set( $name, $value ) {
		PropGuard::set( $this, $name, $value );
	}
}
