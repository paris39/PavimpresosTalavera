<?php

/**
 * @author Addshore
 *
 * @since 1.27
 */
class SpecialPageExecutor {

	/**
	 * @param SpecialPage $page The special page to execute
	 * @param string $subPage The subpage parameter to call the page with
	 * @param WebRequest|null $request Web request that may contain URL parameters, etc
	 * @param Language|string|null $language The language which should be used in the context
	 * @param User|null $user The user which should be used in the context of this special page
	 *
	 * @throws Exception
	 * @return array [ string, WebResponse ] A two-elements array containing the HTML output
	 * generated by the special page as well as the response object.
	 */
	public function executeSpecialPage(
		SpecialPage $page,
		$subPage = '',
		WebRequest $request = null,
		$language = null,
		User $user = null
	) {
		$context = $this->newContext( $request, $language, $user );

		$output = new OutputPage( $context );
		$context->setOutput( $output );

		$page->setContext( $context );
		$output->setTitle( $page->getPageTitle() );

		$html = $this->getHTMLFromSpecialPage( $page, $subPage );
		$response = $context->getRequest()->response();

		if ( $response instanceof FauxResponse ) {
			$code = $response->getStatusCode();

			if ( $code > 0 ) {
				$response->header( 'Status: ' . $code . ' ' . HttpStatus::getMessage( $code ) );
			}
		}

		return [ $html, $response ];
	}

	/**
	 * @param WebRequest|null $request
	 * @param Language|string|null $language
	 * @param User|null $user
	 *
	 * @return DerivativeContext
	 */
	private function newContext(
		WebRequest $request = null,
		$language = null,
		User $user = null
	) {
		$context = new DerivativeContext( RequestContext::getMain() );

		$context->setRequest( $request ?: new FauxRequest() );

		if ( $language !== null ) {
			$context->setLanguage( $language );
		}

		if ( $user !== null ) {
			$context->setUser( $user );
		}

		$this->setEditTokenFromUser( $context );

		return $context;
	}

	/**
	 * If we are trying to edit and no token is set, supply one.
	 *
	 * @param DerivativeContext $context
	 */
	private function setEditTokenFromUser( DerivativeContext $context ) {
		$request = $context->getRequest();

		// Edits via GET are a security issue and should not succeed. On the other hand, not all
		// POST requests are edits, but should ignore unused parameters.
		if ( !$request->getCheck( 'wpEditToken' ) && $request->wasPosted() ) {
			$request->setVal( 'wpEditToken', $context->getUser()->getEditToken() );
		}
	}

	/**
	 * @param SpecialPage $page
	 * @param string $subPage
	 *
	 * @throws Exception
	 * @return string HTML
	 */
	private function getHTMLFromSpecialPage( SpecialPage $page, $subPage ) {
		ob_start();

		try {
			$page->execute( $subPage );

			$output = $page->getOutput();

			if ( $output->getRedirect() !== '' ) {
				$output->output();
				$html = ob_get_contents();
			} elseif ( $output->isDisabled() ) {
				$html = ob_get_contents();
			} else {
				$html = $output->getHTML();
			}
		} catch ( Exception $ex ) {
			ob_end_clean();

			// Re-throw exception after "finally" handling because PHP 5.3 doesn't have "finally".
			throw $ex;
		}

		ob_end_clean();

		return $html;
	}

}
