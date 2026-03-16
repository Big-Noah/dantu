<?php
/**
 * Custom product content template for Muukal-like listing cards.
 *
 * @package goixio
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

if ( ! function_exists( 'goixio_format_compact_count' ) ) {
	/**
	 * Format number to compact string.
	 *
	 * @param int $number Number.
	 * @return string
	 */
	function goixio_format_compact_count( $number ) {
		$number = absint( $number );
		if ( $number >= 1000000 ) {
			return round( $number / 1000000, 1 ) . 'M';
		}
		if ( $number >= 1000 ) {
			return round( $number / 1000, 1 ) . 'K';
		}
		return (string) $number;
	}
}

$product_link  = get_the_permalink();
$image_html    = $product->get_image( 'woocommerce_thumbnail' );
$regular_price = (float) $product->get_regular_price();
$sale_price    = (float) $product->get_sale_price();
$views_raw     = get_post_meta( $product->get_id(), '_goixio_frame_views', true );
$views_count   = absint( $views_raw );

if ( ! $views_count ) {
	$views_count = absint( $product->get_total_sales() );
}

$views_label = goixio_format_compact_count( $views_count );
$is_new      = false;
$created     = $product->get_date_created();

if ( $created ) {
	$is_new = ( time() - $created->getTimestamp() ) <= ( 30 * DAY_IN_SECONDS );
}

$discount = 0;
if ( $regular_price > 0 && $sale_price > 0 && $sale_price < $regular_price ) {
	$discount = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
}
?>
<li <?php wc_product_class( 'goixio-frame-card', $product ); ?>>
	<div class="goixio-frame-card__inner">
		<div class="goixio-frame-card__media">
			<a class="goixio-frame-card__thumb" href="<?php echo esc_url( $product_link ); ?>">
				<?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
			<?php if ( $discount > 0 ) : ?>
				<span class="goixio-frame-badge goixio-frame-badge--sale"><?php echo esc_html( $discount ); ?>% OFF</span>
			<?php elseif ( $is_new ) : ?>
				<span class="goixio-frame-badge goixio-frame-badge--new"><?php esc_html_e( 'New', 'avanam' ); ?></span>
			<?php endif; ?>
		</div>

		<div class="goixio-frame-card__content">
			<div class="goixio-frame-card__head">
				<div class="goixio-frame-like">
					<span class="goixio-frame-like__icon" aria-hidden="true">&#10084;</span>
					<span class="goixio-frame-like__num"><?php echo esc_html( $views_label ); ?></span>
				</div>
				<div class="goixio-frame-lens-tags">
					<span class="goixio-frame-tag"><?php esc_html_e( 'Bifocal', 'avanam' ); ?></span>
					<span class="goixio-frame-tag"><?php esc_html_e( 'Progressive', 'avanam' ); ?></span>
				</div>
			</div>

			<h2 class="goixio-frame-card__title">
				<a href="<?php echo esc_url( $product_link ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
			</h2>

			<div class="goixio-frame-card__price">
				<?php if ( $product->is_on_sale() ) : ?>
					<?php if ( $regular_price > 0 ) : ?>
						<span class="goixio-frame-price goixio-frame-price--old"><?php echo wp_kses_post( wc_price( $regular_price ) ); ?></span>
					<?php endif; ?>
					<?php if ( $sale_price > 0 ) : ?>
						<span class="goixio-frame-price goixio-frame-price--new"><?php echo wp_kses_post( wc_price( $sale_price ) ); ?></span>
					<?php endif; ?>
				<?php else : ?>
					<span class="goixio-frame-price goixio-frame-price--new"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				<?php endif; ?>
			</div>

			<div class="goixio-frame-card__actions">
				<button type="button" class="goixio-frame-btn goixio-frame-btn--ghost"><?php esc_html_e( 'TRY ON', 'avanam' ); ?></button>
				<button type="button" class="goixio-frame-btn goixio-frame-btn--dark"><?php esc_html_e( 'View Similar Frames', 'avanam' ); ?></button>
			</div>
		</div>
	</div>
</li>
