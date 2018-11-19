<?php
/**
 * MediaWiki Widgets – TitleInputWidget class.
 *
 * @copyright 2011-2015 MediaWiki Widgets Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
namespace MediaWiki\Widget;

/**
 * Title input widget.
 */
class TitleInputWidget extends \OOUI\TextInputWidget {

	protected $namespace = null;
	protected $relative = null;
	protected $suggestions = null;
	protected $highlightFirst = null;
	protected $validateTitle = null;

	/**
	 * @param array $config Configuration options
	 * @param int|null $config['namespace'] Namespace to prepend to queries
	 * @param bool|null $config['relative'] If a namespace is set,
	 *  return a title relative to it (default: true)
	 * @param bool|null $config['suggestions'] Display search suggestions (default: true)
	 * @param bool|null $config['highlightFirst'] Automatically highlight
	 *  the first result (default: true)
	 * @param bool|null $config['validateTitle'] Whether the input must
	 *  be a valid title (default: true)
	 */
	public function __construct( array $config = [] ) {
		// Parent constructor
		parent::__construct(
			array_merge( [ 'maxLength' => 255 ], $config )
		);

		// Properties, which are ignored in PHP and just shipped back to JS
		if ( isset( $config['namespace'] ) ) {
			$this->namespace = $config['namespace'];
		}
		if ( isset( $config['relative'] ) ) {
			$this->relative = $config['relative'];
		}
		if ( isset( $config['suggestions'] ) ) {
			$this->suggestions = $config['suggestions'];
		}
		if ( isset( $config['highlightFirst'] ) ) {
			$this->highlightFirst = $config['highlightFirst'];
		}
		if ( isset( $config['validateTitle'] ) ) {
			$this->validateTitle = $config['validateTitle'];
		}

		// Initialization
		$this->addClasses( [ 'mw-widget-titleInputWidget' ] );
	}

	protected function getJavaScriptClassName() {
		return 'mw.widgets.TitleInputWidget';
	}

	public function getConfig( &$config ) {
		if ( $this->namespace !== null ) {
			$config['namespace'] = $this->namespace;
		}
		if ( $this->relative !== null ) {
			$config['relative'] = $this->relative;
		}
		if ( $this->suggestions !== null ) {
			$config['suggestions'] = $this->suggestions;
		}
		if ( $this->highlightFirst !== null ) {
			$config['highlightFirst'] = $this->highlightFirst;
		}
		if ( $this->validateTitle !== null ) {
			$config['validateTitle'] = $this->validateTitle;
		}
		return parent::getConfig( $config );
	}
}
