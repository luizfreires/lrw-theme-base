<?php
/**
 * The template for displaying Search Form.
 *
 * @package Odin
 * @since 2.2.0
 */
?>

<form method="get" id="searchform" class="form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<div class="input-group">
		<input type="search" class="form-control" name="s" id="s" />
		<span class="input-group-btn">
			<input type="submit" class="btn btn-default" value="<?php esc_attr_e( 'Search', 'odin' ); ?>" />
		</span>
	</div>
</form>
