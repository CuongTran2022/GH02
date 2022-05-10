<?php

namespace DgoraWcas\Engines\TNTSearchMySQL\Indexer\Searchable;

use DgoraWcas\Engines\TNTSearchMySQL\Indexer\Builder;
use DgoraWcas\Engines\TNTSearchMySQL\Config;
use DgoraWcas\Multilingual;
use DgoraWcas\Post;
use DgoraWcas\Engines\TNTSearchMySQL\Libs\TNTSearch\TNTSearch;
use DgoraWcas\Product;
use DgoraWcas\Helpers;


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Indexer {

	public $tnt;

	public function __construct() {

		$this->tnt = new TNTSearch;

		$this->setTntConfig();

	}

	private function setTntConfig() {

		$this->tnt->loadConfig( [
			'scope' => array(
				//@TODO rest of scope for future use
				'attributes' => DGWT_WCAS()->settings->getOption( 'search_in_product_attributes' ) === 'on' ? true : false,
			),
		] );
	}

	public function indexByPDO() {
		$this->tnt->setDatabaseHandle( new Connector );
		$indexer = $this->tnt->createIndex( '', true );
		$indexer->setPrimaryKey( 'ID' );
		$indexer->steps = 100;

		// Set the stemmer language if set
		// if ($this->options['stemmer'] != 'default') {
		//   $indexer->setLanguage($this->options['stemmer']);
		// }

		$indexer->setTokenizer( new Tokenizer );

		$indexer->setLanguage( 'no' );
		$indexer->run();

	}

	/**
	 * Insert item to the index
	 *
	 * @param int postID
	 *
	 * @return bool true on success
	 */
	public function insert( $postID ) {

		$success  = false;
		$postType = get_post_type( $postID );

		if ( $postType === 'product' ) {
			$document = $this->prepareProduct( $postID );
		} else {
			$document = $this->preparePost( $postID );
		}

		if ( ! empty( $document ) ) {

			$lang = Multilingual::isMultilingual() ? Multilingual::getPostLang( $postID, $postType ) : '';

			$this->tnt->selectIndex();
			$indexer = $this->tnt->getIndex();

			$indexer->delete( $postID, $lang, $postType );

			$indexer->setTokenizer( new Tokenizer );

			// Insert document
			$indexer->insert( $document, $lang, $postType );
			$success = true;

		}

		return $success;

	}

	/**
	 * Update item
	 *
	 * @param int postID
	 *
	 * @return void
	 */
	public function update( $postID ) {
		$this->delete( $postID );
		$this->insert( $postID );

	}

	/**
	 * Remove item from the index
	 *
	 * @param int postID
	 *
	 * @return void
	 */
	public function delete( $postID ) {

		$postType = get_post_type( $postID );
		$lang     = Multilingual::isMultilingual() ? Multilingual::getPostLang( $postID, $postType ) : '';

		if ( $postType === 'product' ) {
			$postType = '';
		}

		$this->tnt->selectIndex();
		$indexer = $this->tnt->getIndex();

		// We need set separate TNT for cache mechanism
		$this->tnt->setLang( $lang );
		$this->tnt->setPostType( $postType );
		$indexer->setTnt( $this->tnt );

		$indexer->delete( $postID, $lang, $postType );

	}

	/**
	 * Prepare product to insert
	 *
	 * @param $productID
	 *
	 * @return array
	 */
	private function prepareProduct( $productID ) {

		$document = array();

		$product = new Product( $productID );

		if ( $product->isValid() ) {

			$fields             = new \stdClass();
			$fields->id         = $product->getID();
			$fields->post_title = $product->getName();

			// Add product description
			if ( DGWT_WCAS()->settings->getOption( 'search_in_product_content' ) === 'on' ) {
				$fields->post_content = $product->getDescription( 'full' );
			}

			if ( Helpers::canSearchInVariableProducts() ) {
				$fields->variations_description = implode( ' ', $product->getVariationsDescriptions() );
			}

			// Add product short description (excerpt)
			if ( DGWT_WCAS()->settings->getOption( 'search_in_product_excerpt' ) === 'on' ) {
				$fields->post_excerpt = $product->getDescription( 'short' );
			}

			// Add product SKU
			if ( DGWT_WCAS()->settings->getOption( 'search_in_product_sku' ) === 'on' ) {
				$fields->sku            = $product->getSKU();
				$fields->sku_variations = implode( ' ', $product->getVariationsSKUs() );
			}

			// Add attributes
			if ( DGWT_WCAS()->settings->getOption( 'search_in_product_attributes' ) === 'on' ) {
				$attributes = $product->getAttributes( true );
				if ( ! empty( $attributes ) ) {
					$fields->attributes = implode( ' ', $attributes );
				}
			}

			// Add custom fields
			$metaKeys = DGWT_WCAS()->settings->getOption( 'search_in_custom_fields' );
			if ( ! empty( $metaKeys ) ) {

				$keys = explode( ',', DGWT_WCAS()->settings->getOption( 'search_in_custom_fields' ) );

				$i = 1;
				foreach ( $keys as $key ) {

					$colName   = 'custom_field_' . $i;
					$metaValue = $product->getCustomField( $key );

					if ( ! empty( $metaValue ) ) {
						$fields->$colName = $metaValue;
					}

					$i ++;
				}

			}

			// Search in brands
			if ( DGWT_WCAS()->brands->hasBrands() && DGWT_WCAS()->settings->getOption( 'search_in_brands' ) === 'on' ) {
				$brand = $product->getBrand();
				if ( ! empty( $brand ) ) {
					$fields->brand = $brand;
				}
			}

			// Search in categories
			if ( DGWT_WCAS()->settings->getOption( 'search_in_product_categories' ) === 'on' ) {
				$categories = $product->getTerms( 'product_cat', 'string' );
				if ( ! empty( $categories ) ) {
					$fields->tax_product_cat = $categories;
				}
			}

			// Search in tags
			if ( DGWT_WCAS()->settings->getOption( 'search_in_product_tags' ) === 'on' ) {
				$tags = $product->getTerms( 'product_tag', 'string' );
				if ( ! empty( $tags ) ) {
					$fields->tax_product_tag = $tags;
				}
			}

			$document = (array) $fields;
		}

		return apply_filters( 'dgwt/wcas/tnt/indexer/searchable/product_data', $document, $productID, $product );
	}

	/**
	 * Prepare post to insert
	 *
	 * @param $postID
	 *
	 * @return array
	 */
	private function preparePost( $postID ) {

		$document = array();

		$post = new Post( $postID );

		if ( $post->isValid() ) {

			$fields             = new \stdClass();
			$fields->id         = $post->getID();
			$fields->post_title = $post->getTitle();

			// Add post description
			if ( apply_filters( 'dgwt/wcas/tnt/post_source_query/description', false ) ) {
				$fields->post_content = $post->getDescription();
			}

			$document = (array) $fields;
		}

		return $document;
	}

	/**
	 * Wipe index
	 *
	 * @return bool
	 */
	public function wipe() {
		Database::remove();
		Builder::log( '[Searchable index] Cleared' );

		return true;

	}

}
