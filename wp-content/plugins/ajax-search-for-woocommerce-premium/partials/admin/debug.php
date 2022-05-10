<?php


use DgoraWcas\Engines\TNTSearchMySQL\SearchQuery\AjaxQuery;
use DgoraWcas\Engines\TNTSearchMySQL\Debug\Debugger;
use DgoraWcas\Engines\TNTSearchMySQL\Indexer\Searchable\Tokenizer;
use DgoraWcas\Engines\TNTSearchMySQL\Indexer\Builder;

// Exit if accessed directly
if ( ! defined( 'DGWT_WCAS_FILE' ) ) {
	exit;
}


Debugger::wipeLogs( 'product-search-flow' );
Debugger::wipeLogs( 'search-resutls' );


$searchPhrase = ! empty( $_GET['s'] ) ? $_GET['s'] : '';
$lang         = ! empty( $_GET['lang'] ) ? $_GET['lang'] : '';

$toTokenize   = ! empty( $_GET['dgwt-wcas-to-tokenize'] ) ? $_GET['dgwt-wcas-to-tokenize'] : '';
$tokenizerCtx = ! empty( $_GET['dgwt-wcas-debug-tokenizer-ctx'] ) ? $_GET['dgwt-wcas-debug-tokenizer-ctx'] : 'indexer';

?>
	<div class="wrap dgwt-wcas-settings dgwt-wcas-debug">

		<h2>FiboSearch Debug</h2>

		<h3>Search flow</h3>
		<form action="<?php echo admin_url( 'admin.php' ); ?>" method="get">
			<input type="hidden" name="page" value="dgwt_wcas_debug">
			<label for="dgwt-wcas-debug-search"></label>
			<input type="text" class="regular-text" id="dgwt-wcas-debug-search" name="s"
				   value="<?php echo esc_html( $searchPhrase ); ?>" placeholder="search phrase">
			<input type="text" class="small-text" id="dgwt-wcas-debug-search-lang" name="lang"
				   value="<?php echo esc_html( $lang ); ?>" placeholder="lang">
			<button class="button" type="submit">Search</button>
		</form>

		<hr/>
		<h3>Tokenizer</h3>
		<form action="<?php echo admin_url( 'admin.php' ); ?>" method="get">
			<input type="hidden" name="page" value="dgwt_wcas_debug">
			<label for="dgwt-wcas-debug-tokenizer"></label>
			<input type="text" class="regular-text" id="dgwt-wcas-debug-tokenizer" name="dgwt-wcas-to-tokenize"
				   value="<?php echo esc_html( $toTokenize ); ?>" placeholder="To tokenize"">
			<select name="dgwt-wcas-debug-tokenizer-ctx">
				<option <?php echo $tokenizerCtx === 'search' ? 'selected="selected"' : ''; ?>>search</option>
				<option <?php echo $tokenizerCtx === 'indexer' ? 'selected="selected"' : ''; ?>>indexer</option>
			</select>
			<button class="button" type="submit">Tokenize</button>
		</form>

		<?php if ( ! empty( $searchPhrase ) ) {

			define( 'DGWT_SEARCH_START', microtime( true ) );
			$query = new AjaxQuery( true );
			$query->setPhrase( $searchPhrase );

			if ( ! empty( $_GET['lang'] ) ) {
				$query->setLang( $_GET['lang'] );
			}

			$query->searchProducts();
			$query->searchPosts();
			$query->searchTaxonomy();
			Debugger::logSearchResults( $query );


			Debugger::printLogs( 'Search flow', 'product-search-flow' );
			Debugger::printLogs( 'Search resutls', 'search-resutls' );

		}
		?>

		<?php if ( ! empty( $toTokenize ) ) {

			$tokenizer = new Tokenizer();
			$tokenizer->setContext( $tokenizerCtx );

			Debugger::log( '<b>Phrase:</b> <pre>' . var_export( $toTokenize, true ) . '</pre>', 'tokenizer' );
			Debugger::log( '<b>Context:</b> <pre>' . var_export( $tokenizerCtx, true ) . '</pre>', 'tokenizer' );
			Debugger::log( '<b>Split by:</b> <pre>' . var_export( $tokenizer->getSpecialChars(), true ) . '</pre>', 'tokenizer' );
			Debugger::log( '<b>Tokens:</b> <pre>' . var_export( $tokenizer->tokenize( $toTokenize ), true ) . '</pre>', 'tokenizer' );

			Debugger::printLogs( 'Tokenizer', 'tokenizer' );

		}
		?>

		<h2>Maintenance</h2>
		<form action="<?php echo admin_url( 'admin.php' ); ?>" method="get">
			<input type="hidden" name="page" value="dgwt_wcas_debug">
			<input type="submit" name="dgwt-wcas-debug-delete-db-tables" class="button" value="Delete DB tables">
			<input type="submit" name="dgwt-wcas-debug-delete-indexer-options" class="button"
				   value="Delete Indexer options">

			<?php if ( is_multisite() ): ?>
				<br/><br/>
				<input type="submit" name="dgwt-wcas-debug-delete-db-tables-ms" class="button"
					   value="Delete DB tables (Network)"></button>
				<input type="submit" name="dgwt-wcas-debug-delete-indexer-options-ms" class="button"
					   value="Delete Indexer options (Network)"></button>
			<?php endif; ?>
		</form>
		<?php

		if ( ! empty( $_GET['dgwt-wcas-debug-delete-db-tables'] ) ) {
			Builder::deleteDatabaseTables();
			echo 'tables deleted';
		}

		if ( ! empty( $_GET['dgwt-wcas-debug-delete-indexer-options'] ) ) {
			Builder::deleteIndexOptions();
			echo 'settings deleted';
		}

		if ( ! empty( $_GET['dgwt-wcas-debug-delete-db-tables-ms'] ) ) {
			Builder::deleteDatabaseTables( true );
			echo 'tables deleted (ms)';
		}

		if ( ! empty( $_GET['dgwt-wcas-debug-delete-indexer-options-ms'] ) ) {
			Builder::deleteIndexOptions( true );
			echo 'settings deleted (ms)';
		}

		?>

		<h2>Extended indexer debug logs</h2>
		<?php
		if ( ! empty( $_GET['dgwt-wcas-debug-enable-indexer-debug'] ) ) {
			set_transient( Builder::INDEXER_DEBUG_TRANSIENT_KEY, true, 12 * HOUR_IN_SECONDS );
			set_transient( Builder::INDEXER_DEBUG_SCOPE_TRANSIENT_KEY, array( 'all' ), 12 * HOUR_IN_SECONDS );
			?>
			<div class="dgwt-wcas-notice notice notice-success">
				<p>Indexer debug is now enabled with scope: all</p>
			</div>
			<?php
		}
		if ( ! empty( $_GET['dgwt-wcas-debug-disable-indexer-debug'] ) ) {
			delete_transient( Builder::INDEXER_DEBUG_TRANSIENT_KEY );
			?>
			<div class="dgwt-wcas-notice notice notice-success">
				<p>Indexer debug is now disabled</p>
			</div>
			<?php
		}
		if ( ! empty( $_GET['dgwt-wcas-debug-save-indexer-debug-scope'] ) && ! empty( $_GET['dgwt-wcas-debug-indexer-debug-scope'] ) ) {
			set_transient( Builder::INDEXER_DEBUG_TRANSIENT_KEY, true, 12 * HOUR_IN_SECONDS );
			set_transient( Builder::INDEXER_DEBUG_SCOPE_TRANSIENT_KEY, $_GET['dgwt-wcas-debug-indexer-debug-scope'], 12 * HOUR_IN_SECONDS );
			?>
			<div class="dgwt-wcas-notice notice notice-success">
				<p>Indexer debug scope saved</p>
			</div>
			<?php
		}
		?>
		<form action="<?php echo admin_url( 'admin.php' ); ?>" method="get">
			<input type="hidden" name="page" value="dgwt_wcas_debug">

			<strong>
				Debug state: <?php echo Builder::isDebug() ? 'enabled' : 'disabled'; ?>
				<?php echo defined( 'DGWT_WCAS_INDEXER_DEBUG' ) ? ( '(via DGWT_WCAS_INDEXER_DEBUG)' ) : ''; ?>
			</strong>
			<br/>
			<br/>
			<strong>
				Scope
				<?php echo defined( 'DGWT_WCAS_INDEXER_DEBUG_SCOPE' ) ? ( '(via DGWT_WCAS_INDEXER_DEBUG_SCOPE)' ) : ''; ?>
			</strong>
			<br/>
			<?php foreach ( Builder::$indexerDebugScopes as $scope ) {
				if ( $scope === 'all' ) {
					continue;
				}
				?>
				<label for="indexer-debug-scope-<?php echo $scope ?>">
					<input id="indexer-debug-scope-<?php echo $scope ?>" type="checkbox"
						   name="dgwt-wcas-debug-indexer-debug-scope[]"
						   value="<?php echo $scope ?>" <?php checked( Builder::isDebugScopeActive( $scope ) ) ?>
						<?php disabled( defined( 'DGWT_WCAS_INDEXER_DEBUG_SCOPE' ) ) ?>>
					<?php echo $scope; ?>
				</label>
				<br/>
			<?php } ?>
			<br/>
			<input type="submit" name="dgwt-wcas-debug-enable-indexer-debug" class="button"
				   value="Enable debug with scope: all" <?php disabled( defined( 'DGWT_WCAS_INDEXER_DEBUG' ) ) ?>>
			<input type="submit" name="dgwt-wcas-debug-save-indexer-debug-scope" class="button"
				   value="Enable debug with selected scope" <?php disabled( defined( 'DGWT_WCAS_INDEXER_DEBUG_SCOPE' ) ) ?>>
			<input type="submit" name="dgwt-wcas-debug-disable-indexer-debug" class="button"
				   value="Disable debug" <?php disabled( defined( 'DGWT_WCAS_INDEXER_DEBUG' ) ) ?>>
		</form>
	</div>

<?php
Debugger::wipeLogs( 'product-search-flow' );
Debugger::wipeLogs( 'search-resutls' );
Debugger::wipeLogs( 'tokenizer' );
