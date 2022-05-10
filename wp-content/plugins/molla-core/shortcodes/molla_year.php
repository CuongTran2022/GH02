<?php
add_shortcode(
	'molla_year',
	function() {
		return date( 'Y' );
	}
);
