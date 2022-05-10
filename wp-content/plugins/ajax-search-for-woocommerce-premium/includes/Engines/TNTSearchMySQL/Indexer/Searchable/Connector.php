<?php

namespace DgoraWcas\Engines\TNTSearchMySQL\Indexer\Searchable;

use DgoraWcas\Engines\TNTSearchMySQL\Indexer\SourceQuery;
use DgoraWcas\Engines\TNTSearchMySQL\Indexer\PostsSourceQuery;

class Connector extends \PDO {

	public function __construct() {
	}

	public function getAttribute( $attribute ) {
		return false;
	}

	// TODO $fetchmode should be: "?int $fetchMode = null", but this require PHP 7.1, but we don't use it anyway
	public function query( string $query, int $fetchMode = null, mixed ...$fetchModeArgs ) {

		$args = array(
			'trigrams' => true
		);

		$itemsSet = get_option( AsyncProcess::CURRENT_ITEMS_SET_OPTION_KEY );

		$postType = ! empty( $itemsSet[0] ) ? get_post_type( $itemsSet[0] ) : 'product';

		if ( ! empty( $itemsSet ) ) {
			$args['package'] = $itemsSet;
		}

		if ( $postType === 'product' ) {
			$source = new SourceQuery( $args );
		} else {
			$args['postTypes'] = array( $postType );
			$source            = new PostsSourceQuery( $args );
		}

		return new ResultObject( $source->getData() );
	}

}
