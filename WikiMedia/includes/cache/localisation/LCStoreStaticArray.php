<?php
/**
 *  Localisation cache storage based on PHP files and static arrays.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

/**
 * @since 1.26
 */
class LCStoreStaticArray implements LCStore {
	/** @var string|null Current language code. */
	private $currentLang = null;

	/** @var array Localisation data. */
	private $data = [];

	/** @var string File name. */
	private $fname = null;

	/** @var string Directory for cache files. */
	private $directory;

	public function __construct( $conf = [] ) {
		global $wgCacheDirectory;

		if ( isset( $conf['directory'] ) ) {
			$this->directory = $conf['directory'];
		} else {
			$this->directory = $wgCacheDirectory;
		}
	}

	public function startWrite( $code ) {
		$this->currentLang = $code;
		$this->fname = $this->directory . '/' . $code . '.l10n.php';
		$this->data[$code] = [];
		if ( file_exists( $this->fname ) ) {
			$this->data[$code] = require $this->fname;
		}
	}

	public function set( $key, $value ) {
		$this->data[$this->currentLang][$key] = self::encode( $value );
	}

	/**
	 * Encodes a value into an array format
	 *
	 * @param mixed $value
	 * @return array
	 * @throws RuntimeException
	 */
	public static function encode( $value ) {
		if ( is_scalar( $value ) || $value === null ) {
			// [V]alue
			return [ 'v', $value ];
		}
		if ( is_object( $value ) ) {
			// [S]erialized
			return [ 's', serialize( $value ) ];
		}
		if ( is_array( $value ) ) {
			// [A]rray
			return [ 'a', array_map( function ( $v ) {
				return LCStoreStaticArray::encode( $v );
			}, $value ) ];
		}

		throw new RuntimeException( 'Cannot encode ' . var_export( $value, true ) );
	}

	/**
	 * Decode something that was encoded with encode
	 *
	 * @param array $encoded
	 * @return array|mixed
	 * @throws RuntimeException
	 */
	public static function decode( array $encoded ) {
		$type = $encoded[0];
		$data = $encoded[1];

		switch ( $type ) {
		case 'v':
			return $data;
		case 's':
			return unserialize( $data );
		case 'a':
			return array_map( function ( $v ) {
				return LCStoreStaticArray::decode( $v );
			}, $data );
		default:
			throw new RuntimeException(
				'Unable to decode ' . var_export( $encoded, true ) );
		}
	}

	public function finishWrite() {
		file_put_contents(
			$this->fname,
			"<?php\n" .
			"// Generated by LCStoreStaticArray.php -- do not edit!\n" .
			"return " .
			var_export( $this->data[$this->currentLang], true ) . ';'
		);
		$this->currentLang = null;
		$this->fname = null;
	}

	public function get( $code, $key ) {
		if ( !array_key_exists( $code, $this->data ) ) {
			$fname = $this->directory . '/' . $code . '.l10n.php';
			if ( !file_exists( $fname ) ) {
				return null;
			}
			$this->data[$code] = require $fname;
		}
		$data = $this->data[$code];
		if ( array_key_exists( $key, $data ) ) {
			return self::decode( $data[$key] );
		}
		return null;
	}
}
