<?php

namespace DgoraWcas\Engines\TNTSearchMySQL\SearchQuery;

use DgoraWcas\Engines\TNTSearchMySQL\Config;
use DgoraWcas\Helpers;

class TaxQuery {

	private $taxonomies = array();
	private $settings = array();
	private $results = array();
	private $taxTable = '';
	private $lang = '';

	public function __construct() {
		$this->setTable();
		$this->setSettings();
		$this->setTaxonomies();
	}

	/**
	 * Check if can search matching taxonomies
	 *
	 * @return bool
	 */
	public function isEnabled() {
		return ! empty( $this->taxonomies );
	}


	/**
	 * Set taxonomy table name
	 *
	 * @return void
	 */
	private function setTable() {
		global $wpdb;

		$this->taxTable = $wpdb->prefix . Config::READABLE_TAX_INDEX;
	}


	/**
	 * Load settings
	 *
	 * @return void
	 */
	protected function setSettings() {
		$this->settings = Settings::getSettings();
	}

	/**
	 * Get option
	 *
	 * @param $option
	 *
	 * @return string
	 */
	private function getOption( $option ) {
		$value = '';
		if ( array_key_exists( $option, $this->settings ) ) {
			$value = $this->settings[ $option ];
		}

		return $value;
	}

	/**
	 * Set allowed product taxonomies
	 *
	 * @return void
	 */
	private function setTaxonomies() {
		global $wpdb;

		if ( $this->getOption( 'show_matching_categories' ) === 'on' ) {
			$this->taxonomies[] = 'product_cat';
		}

		if ( $this->getOption( 'show_matching_tags' ) === 'on' ) {
			$this->taxonomies[] = 'product_tag';
		}

		if ( $this->getOption( 'show_matching_brands' ) === 'on' ) {
			$taxonomy = $this->getBrandTaxonomy();
			if ( ! empty( $taxonomy ) && is_string( $taxonomy ) ) {
				$this->taxonomies[] = $taxonomy;
			}

		}

		$this->taxonomies = apply_filters('dgwt/wcas/tnt/search_taxonomies', $this->taxonomies);
	}

	/**
	 * Set language
	 *
	 * @param $lang
	 *
	 * @return void
	 */
	public function setLang( $lang ) {
		$this->lang = $lang;
	}

	/**
	 * Check if can show matching terms in specific taxonomy
	 *
	 * @param $taxonomy
	 *
	 * @return bool
	 */
	public function allowedTaxonomy( $taxonomy ) {
		$success = false;
		if ( in_array( $taxonomy, $this->taxonomies ) ) {
			$success = true;
		}

		return $success;
	}


	public function search( $phrase ) {
		global $wpdb;

		$results = array();

		$term = $wpdb->esc_like( $phrase );


		$where = ' AND (';
		$i     = 0;
		foreach ( $this->taxonomies as $taxonomy ) {
			if ( $i === 0 ) {
				$where .= $wpdb->prepare( '  taxonomy = %s', $taxonomy );
			} else {
				$where .= $wpdb->prepare( ' OR taxonomy = %s', $taxonomy );
			}
			$i ++;
		}
		$where .= ')';

		if ( ! empty( $this->lang ) ) {
			$where .= $wpdb->prepare( ' AND lang = %s ', $this->lang );
		}

		$sql = $wpdb->prepare( "SELECT *
                                      FROM " . $this->taxTable . "
                                      WHERE 1 = 1
                                      $where
                                      AND term_name LIKE %s
                                      ORDER BY taxonomy, total_products DESC",
			'%' . $term . '%'
		);


		$r = $wpdb->get_results( $sql );

		$groups = array();

		$showCategoryImages = $this->getOption( 'show_categories_images' ) === 'on';
		$showBrandImages    = $this->getOption( 'show_brands_images' ) === 'on';
		$brandTaxonomy      = $this->getBrandTaxonomy();

		if ( ! empty( $r ) && is_array( $r ) ) {
			foreach ( $r as $item ) {

				$score = Helpers::calcScore( $phrase, $item->term_name );

				$showImage = $showCategoryImages && $item->taxonomy === 'product_cat' || $showBrandImages && $item->taxonomy === $brandTaxonomy;

				$groups[ $item->taxonomy ][] = array(
					'term_id'     => $item->term_id,
					'taxonomy'    => $item->taxonomy,
					'value'       => html_entity_decode( $item->term_name ),
					'url'         => $item->term_link,
					'image_src'   => $showImage && ! empty( $item->image ) ? $item->image : '',
					'breadcrumbs' => $item->breadcrumbs,
					'count'       => $item->total_products,
					'type'        => 'taxonomy',
					'score'       => $score
				);
			}
		}

		if ( ! empty( $groups ) ) {
			foreach ( $groups as $key => $group ) {
				usort( $groups[ $key ], array( 'DgoraWcas\Helpers', 'cmpSimilarity' ) );
				$results = array_merge( $results, $groups[ $key ] );
			}
		}

		return $results;
	}

	private function getBrandTaxonomy() {
		global $wpdb;

		return $wpdb->get_var( "SELECT taxonomy FROM $this->taxTable WHERE taxonomy LIKE '%brand%' LIMIT 1" );
	}
}
