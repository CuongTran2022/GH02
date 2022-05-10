<?php

namespace DgoraWcas;

use DgoraWcas\Engines\TNTSearchMySQL\Indexer\Utils;

class Post {
	private $postID = 0;
	public $post;
	private $postType = 'post';
	private $langCode = 'en';

	public function __construct( $post ) {
		if ( ! empty( $post ) && is_object( $post ) && is_a( $post, 'WP_Post' ) ) {
			$this->postID   = absint( $post->ID );
			$this->postType = $post->post_type;
		}

		if ( is_numeric( $post ) ) {
			$this->postID   = absint( $post );
			$this->postType = get_post_type( $post );
		}

		$this->post = get_post( $this->postID );

		$this->setLanguage();
	}

	/**
	 * Set info about product language
	 *
	 * @return void
	 */
	public function setLanguage() {
		$this->langCode = Multilingual::getPostLang( $this->getID(), $this->postType );
	}

	/**
	 * Get product ID (post_id)
	 * @return int
	 */
	public function getID() {
		return $this->postID;
	}

	/**
	 * Get post type
	 * @return string
	 */
	public function getPostType() {
		return $this->postType;
	}

	/**
	 * Get post title
	 *
	 * @return string
	 */
	public function getTitle() {
		return apply_filters( 'dgwt/wcas/post/title', $this->post->post_title, $this->postType );
	}

	/**
	 * Get prepared post description
	 *
	 * @param string $type full|short|details-panel
	 * @param int $forceWordsLimit
	 *
	 * @return string
	 */
	public function getDescription( $type = 'full', $forceWordsLimit = 0 ) {

		$output = '';

		if ( $type === 'full' ) {
			$output = $this->post->post_content;
		}

		if ( $type === 'short' ) {
			$output = $this->post->post_excerpt;
		}

		if ( $type === 'details-panel' ) {

			$desc = $this->post->post_excerpt;

			if ( empty( $desc ) ) {
				$desc = $this->post->post_content;
			}

			// Load WPBakery Page Builder shortcodes
			if ( is_callable( '\WPBMap::addAllMappedShortcodes' ) ) {
				\WPBMap::addAllMappedShortcodes();
			}

			// Resolve shortcodes
			$desc = do_shortcode( $desc );

			if ( ! empty( $desc ) ) {
				$wordsLimit = $forceWordsLimit > 0 ? $forceWordsLimit : 20;
				$output     = Helpers::makeShortDescription( $desc, $wordsLimit, '</br><b><strong>', false );
			}
		}

		return apply_filters( 'dgwt/wcas/post/description', $output, $type, $this->postID, $this );
	}

	/**
	 * Get product permalink
	 *
	 * @return string
	 */
	public function getPermalink() {
		$permalink = get_permalink( $this->getID() );

		if ( Multilingual::isMultilingual() ) {
			$permalink = Multilingual::getPermalink( $this->getID(), $permalink, $this->langCode );
		}

		return apply_filters( 'dgwt/wcas/post/permalink', $permalink, $this->postType );
	}

	/**
	 * Get product language
	 *
	 * @return string
	 */
	public function getLanguage() {
		return $this->langCode;
	}

	/**
	 * Check, if class is initialized correctly
	 *
	 * @return bool
	 */
	public function isValid() {
		$isValid = false;

		if ( is_a( $this->post, 'WP_Post' ) ) {
			$isValid = true;
		}

		return $isValid;
	}

}
