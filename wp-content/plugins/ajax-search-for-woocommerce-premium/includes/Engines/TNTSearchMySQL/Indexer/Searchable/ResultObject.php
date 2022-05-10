<?php

namespace DgoraWcas\Engines\TNTSearchMySQL\Indexer\Searchable;

use DgoraWcas\Engines\TNTSearchMySQL\Indexer\Builder;

class ResultObject {

	protected $items;
	protected $counter;

	public function __construct( $items ) {
		$this->counter = 0;
		$this->items   = $items;
	}

	public function fetch( $options ) {
		$index = $this->counter ++;
		if ( isset( $this->items[ $index ] ) ) {
			return $this->items[ $index ];
		}

	}

}
