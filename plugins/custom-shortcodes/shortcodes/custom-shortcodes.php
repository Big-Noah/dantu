<?php
/**
 * Blog Posts
 * 
 */
function shortcode_blog_posts_container($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'type' => 'grid',
		'items_per_column' => '2',
		'number_of_posts' => '6',
		'category' => '',
		'width' => '600',
		'height' => '369',
		'excerpt_length' => '75',
		'linktext' => '',
	), $atts));
if(!empty($category)):
	$term_id = $category;	
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => $number_of_posts,
		'orderby' => 'date',
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $term_id
			)
		)
	);	
else:
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => $number_of_posts,
		'orderby' => 'date'	
	);	
endif;	

$i = 1;
wp_reset_postdata();

$output = '';
$blog_array = new WP_Query( $args );	
$count = $blog_array->post_count;
$output = '';
if ( $blog_array->have_posts() ):
	$output .= '<div id="blog-posts-products" class="blog-posts-content posts-content">';			
		if($type == "slider") { 
			if($count > $items_per_column)
				$output .= '<div id="'.$items_per_column.'_blog_carousel" class="slider blog-carousel">';
			else
				$output .= '<div id="blog_grid" class="blog-grid grid-cols grid-lg-col-'.$items_per_column.'">';
		} else {
			$output .= '<div id="blog_grid" class="blog-grid grid-cols grid-lg-col-'.$items_per_column.'">';
		}
	while ( $blog_array->have_posts() ) : $blog_array->the_post();

		if($i % $items_per_column == 1 )
			$class = " first";
		elseif($i % $items_per_column == 0 )
			$class = " last";
		else
			$class = "";
		$post_day = get_the_date('d');
		$post_month = get_the_date('F');
		$post_year = get_the_date('Y');
		$post_author = get_the_author();
        $comments = wp_count_comments(get_the_ID());		
		$args = array(
			'status' => 'approved',
			'number' => '5',
			'post_id' => get_the_ID()
		);		
		$comments = wp_count_comments(get_the_ID()); 				   
		if ( has_post_thumbnail() && ! post_password_required() ) :	
			$post_thumbnail_id = get_post_thumbnail_id();
		$image = wp_get_attachment_url( $post_thumbnail_id );
		endif;	
		$output .= '<div class="item container'.$class.' latest-blog">';
		$output .= '<div class="container-inner loop-entry type-post">';
		if ( has_post_thumbnail() && ! post_password_required() ) :	
		$output .= '<a href="'.get_permalink().'" class="post-thumbnail"><div class="post-thumbnail-inner">';
		$output .= '<img src="'.$image.'" title="'.get_the_title().'" alt="'.get_the_title().'" height="'.$height.'" width="'.$width.'"/>';	
		$output .= '</div></a>';
		endif;	
		$output .= '<div class="entry-content-wrap">';
		$output .= '<header class="entry-header">';
		$output .='<div class="entry-meta entry-meta-divider-dot entry-meta-divider-vline entry-meta-divider-dash entry-meta-divider-slash">';
		$output .='<span class="posted-by"><span class="author vcard">'.esc_html__('by ', 'avanam').''.$post_author.'</span></span>';
		$output .= '<span class="posted-on">'.$post_day.' '.$post_month.''.esc_html__(', ').''.$post_year.'</span>';
		$output .= '</div>';
		$output .= '<h4 class="entry-title"><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h4>';
		if ($excerpt_length > 0){ 
			$output .= '<div class="post-description">'.avanam_blog_post_excerpt($excerpt_length).'</div>';
		} 
		$output .= '</header>';
		$output .= '<footer class="entry-footer">';
		if(!empty($linktext)):
			$output .= '<div class="entry-actions"><p class="more-link-wrap"><a class="post-more-link" href="'.get_permalink().'">'.$linktext.'</a></p></div>';
		endif;
		$output .= '</footer>';	
		$output .= '</div>';	
		$output .= '</div></div>';
	$i++;
endwhile;
wp_reset_postdata();
$output .=	'</div></div>';
endif;
return $output;
}
add_shortcode('blog_posts', 'shortcode_blog_posts_container');

/**
 * Products
 * 
 */
function woo_products_container($atts, $content = null, $code) {
	global $logotype;
	extract(shortcode_atts(array(
		'type' => 'slider',
		'items_per_column' => 5,
		'product' => 'shop',
		'classname' => '',
		'no_more'  => 'No more Products to display'	
	), $atts));
	$logotype = $type;	
	$output = '';	
	
	$output .= '<div class="woo-products woo-content products_block '.$product.' '.$classname.'">';
	if($type == "slider") { 
		$output .= '<div id="'.$items_per_column.'_woo_carousel" class="woo-carousel cols-'.$items_per_column.'">';
	}
	elseif($type == "list") { 
		$output .= '<div class="woo_list woo-list cols-'.$items_per_column.'">';
	}
	else {
		$output .= '<div class="woo_grid woo-grid cols-'.$items_per_column.'">';
	}
	$output .= do_shortcode($content).'</div>';
	$output .='</div>';
	return $output;
}
add_shortcode('woo_products', 'woo_products_container');

/**
 * Category wise Products
 * 
 */
function shortcode_woo_category_slider($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'category_ids' => '',
		'items_per_column' => '5',
		'items_per_page' => '10',
		'type' => 'slider',
		'catlist' => '3',			
	), $atts));	
	$logotype = $type;	
	static  $cnt = 1;
	$output = '';	
	$category_ids_array = explode(",",$category_ids);
		$output = '';
	if (class_exists( 'WooCommerce' )) {			
	$output .= '<div id="categorytab">';
		$category_ids = '';
		$term_category_id = '';
		$term_category_name = '';
		$term_categroy_slug = '';
		$term_thumbnai_id = '';
		$term_image = '';
		$class="";
		// $output .= '<div class="resp-tabs-title">';				
		// $output .= '<ul id="'.$catlist.'_catlist_carousel"  class="resp-tabs-list catlist-carousel catlist-'.$catlist.' cols-'.$items_per_column.' '.$class.'">';			
		// foreach($category_ids_array as $key){
		// 		$category_ids = get_term( $key, 'product_cat' );
		// 		if($category_ids){
		// 			$term_category_id = $category_ids->term_id;
		// 			$term_category_name = $category_ids->name;
		// 			$term_category_slug = $category_ids->slug;
		// 			$term_thumbnail_id =  get_term_meta( $term_category_id , 'thumbnail_id', true );
		// 			$output .= '<li><div class="tab-title">'.$term_category_name.'</div></li>';
		// 		}
		// 	}
		// $output .= '</ul>';
		// $output .= '</div>';			
		$output .= '<div class="resp-tabs-container '.$type.'">';
			foreach($category_ids_array as $key){
					$term_array = get_term( $key, 'product_cat' );
					$term_category_id = isset($term_array->term_id) ? $term_array->term_id : '';
					$term_category_slug = isset($term_array->slug) ? $term_array->slug : '';
					$output .= do_shortcode('[woo_products type="'.$type.'" items_per_column="'.$items_per_column.'"][product_category  per_page="'.$items_per_page.'" Columns="'.$items_per_column.'" category="'.$term_category_slug.'"][/woo_products]');
			}			
		$output .= '</div>';
	$output .= '</div>';
	}
	return $output;
}
add_shortcode('woo_category_products', 'shortcode_woo_category_slider');
	
/**
 * Single product Category
 * 
 */
// function woo_single_category($atts, $content = null) {		
// 	extract(shortcode_atts(array(
// 		'height' => '159',
// 		'width' => '143',
// 		'hide_empty' => '1',
// 		'target' => '_self',
// 		'limit' => '2',
// 		'orderby' => 'name',
// 		'order' => 'ASC',
// 		'id' => '',
// 	), $atts));
// $category_ids_array = explode(",",'product_cat');	
// $output = '';

// 	$cat = get_term_by( 'id', $id, 'product_cat' );

// 	$args = array(
// 		'parent'        => 0,
// 		'hide_empty'    => $hide_empty,
// 		'taxonomy'      => 'product_cat',
// 	);

// 	$categories = get_categories( $args );	
// 	$category_ids = get_term( $cat, 'product_cat' );
// 	$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
// 		if( empty ($thumbnail_id)):
// 			$image = get_stylesheet_directory_uri()."/assets/images/placeholder.png";		
// 		else:
// 			$image = wp_get_attachment_url( $thumbnail_id );				
// 		endif;					
// 	$output .= '<div class="single-category-block">';	
// 	$output .= '<div class="cat-img-block"><a class="cat-img" target="'.$target.'" href="'.get_category_link( $category_ids ).'" title="'.$cat->name.'" ><img src="'.$image.'" title="'.$cat->name.'" alt="'.$cat->name.'"  height="'.$height.'" width="'.$width.'"/></a></div>';	
// 	$output .= '<div class="category-list">';
// 	$output .= '<h3><a class="cat_name" target="'.$target.'" href="'.get_category_link( $category_ids ).'"  title="'.$cat->name.'">'.$cat->name.'</a></h3>';
// 	$output .= '<div class="sub_category">';	
// 	$child_args = array(
// 				'taxonomy' => 'product_cat',
// 				'orderby' => $orderby,
// 				'order' => $order,
// 				'hide_empty' => false,
// 				'parent'   => $cat->term_id,
// 				'limit' => $limit,
// 			);
// 		$child_product_cats = get_terms( $child_args);
	
// 		foreach ($child_product_cats as $child_product_cat)
// 		{ 
// 		$output .= '<a href="'.get_term_link($child_product_cat).'">'.$child_product_cat->name.'</a>';
// 		}
// 	$output .= '</div>';
// 	$output .= '<a class="view-more-link" target="'.$target.'" href="'.get_category_link( $category_ids ).'"  title="'.$cat->name.'"><span class="view-more">'.esc_html__('View More').'</span></a>';
// 	$output .= '</div>';
		
// $output .= '</div>';
// return $output;
// }
// add_shortcode("woo_single_category", "woo_single_category");

/**
 * Woo Category Slider or Grid
 * 
 */
function shortcode_woo_product_categories($atts, $content = null) {
	extract(shortcode_atts(array(
			'type' => 'slider',
			'style' => '1',
			'items_per_column' => '3',
			'height' => '261',
			'width' => '277',
			'child_category' => '',
			'hide_empty' => '1',
			'items_per_page' => '10',
			'target' => '_self',
			'link_text' => '',
			'count_display' => 'yes',
		), $atts));
	$category_ids_array = explode(",",'product_cat');	
	$output = '';
		$name='';
		$category_link_text='';		
		if($link_text !== ""){
			$category_link_text= '<span class="cat-all-category"><a class="button cat_name" target="'.$target.'" href="'.$link_text.'">'.esc_html__('View All', 'avanam').'</a></span>';
		}
		$readmore='';
		if($type == "slider"){
			$output .= '<div class="woo_categories_slider woo_categories_block">';
			$output .= '<div id="'.$items_per_column.'_category_carousel" class="category-carousel">';
		}
		else{
			$output .= '<div class="woo_categories_grid woo_categories_block">';
			$output .= '<div id="'.$items_per_column.'_category_grid" class="grid-cols grid-lg-col-'.$items_per_column.'">';
		}
		$args = array(
			'parent'        => $child_category,
			'hide_empty'    => $hide_empty,
			'taxonomy'      => 'product_cat',
			'number'        => $items_per_page,
		);
		$categories = get_categories( $args );
		foreach($categories as $cat){	
			$category_ids = get_term( $cat, 'product_cat' );
			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
				if( empty ($thumbnail_id)):
					$src = get_stylesheet_directory_uri()."/assets/images/placeholder.png";		
				else:
					$src = wp_get_attachment_url( $thumbnail_id );
				endif;
									
			$output .= '<div class="cat-outer-block style-'.$style.'">';
			$output .= '<div class="cat-inner-block">';
			if($style == '1') :
			$output .= '<div class="cat-img-block">';
			$output .= '<a class="cat-img" target="'.$target.'" href="'.get_category_link( $category_ids ).'" title="'.$cat->name.'" >';
			$output .= '<img src="'.$src.'" title="'.$cat->name.'" alt="'.$cat->name.'"  height="'.$height.'" width="'.$width.'"/>';
			$output .= '</a>';
			$output .= '</div>';
			endif;	
			$output .= '<div class="cat_description">';			
			$output .= '<a class="cat_name" target="'.$target.'" href="'.get_category_link( $category_ids ).'"  title="'.$cat->name.'">'.$cat->name.' ';			
			if($count_display == "yes"):
				$output .= '<span class="cat-count">('.$cat->count.')</span>';	
			endif;	
			$output .= '</a>';			
			$output .= '</div>';			
			$output .= '</div>';
			$output .= '</div>';
		}	
	$output .= '</div>';
	// $output .= $category_link_text;
	$output .= '</div>';	
	return $output;
	}
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
	add_shortcode("woo_categories", "shortcode_woo_product_categories");
	endif;	

/**
 * Instagram
 * 
 */
function shortcode_instagram($atts) {
	extract(shortcode_atts(array(
		'accessToken' => 'https://ig.instant-tokens.com/users/bc2afecf-30b2-4a91-b819-38edd295cd71/instagram/17841402307816714/token?userSecret=jird860sk2dgid0scrvj5',
		'limit' => '5',
		'type' => 'grid',
		'item_per_row' => '2',
		'username' => 'templatemela',
		), $atts));
	$output = '';
	?>
	<script>
	(function () {
	var feedToken = 'https://ig.instant-tokens.com/users/bc2afecf-30b2-4a91-b819-38edd295cd71/instagram/17841402307816714/token?userSecret=jird860sk2dgid0scrvj5';

		fetch(feedToken).then(function(resp) {
		return resp.json();
		}).then(function (data) {
		var feed = new Instafeed({
			accessToken: data.Token, // Access token from json response
			target: 'instafeed',
			limit: $limit,
			template: "<div class='item instafeed-item-wrap'><a href='\{\{link\}\}'><figure style='display: block; background-image: url(\{\{image\}\}');'></figure></a></div>",
			after: function() {
				// disable button if no more results to load
				$('.instafeed-item-wrap figure').lazy();
			},
		});
		feed.run();
		}).catch(function (error) {
		console.log(error);
		});

	})();
	</script>
	<?php
	$output .= '<div class="main-container instagram">';
	$output .= '<div class="instagram-feed limit-'.$limit.'">';
	if($type == "slider"){
	$output .= '<div id="instafeed" class="insta-owl-carousel owl-carousel"></div>';
	} else{
	$output .= '<div id="instafeed" class="insta-grid  grid-lg-col-'.$item_per_row.'"></div>';
	}
	$output .= '</div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('instagram', 'shortcode_instagram');

/**
 * Hot products Grid or Slider
 * 
 */
function coderplace_hot_products($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'height' => '211',
		'width' => '211',
		'product' => 'shop',
		'classname' => '',
		'items_per_column' => '3',
		'type' => 'slider'
	), $atts));
	$output = '';
	global $post;
	$params = array('posts_per_page' => -1, 'post_type' => array('product', 'product_variation'));
	$wc_query = new WP_Query($params);

	if ( in_array( 'woocommerce/woocommerce.php' ,apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
		$output .= '<div id="'.$items_per_column.'_hot_product_carousel" class="woocommerce hot-product">';

		if($type == "slider")	{
			$output .= '<ul class="products woo-slider">';
		} else {
			$output .= '<div id="woo_grid" class="woo-grid">';
		}
		
		if ($wc_query->have_posts()) :
			while ($wc_query->have_posts()) :
				$wc_query->the_post();
				$today = date('Y-m-d');
				$sale_price_dates_from = ( $date = get_post_meta( $post->ID, '_sale_price_dates_from', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
				$sale_price_dates_to    = ( $date = get_post_meta( $post->ID, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
				if ($today >= $sale_price_dates_from  && $today <= $sale_price_dates_to){
					if ($sale_price_dates_to != "")
					{
						global $product;
						$rating = $product->get_average_rating();
						$attachment_ids = $product->get_gallery_image_ids();
						$output .= '<li class="product">';
						$output .= '<div class="container-inner">';
						$output .= '<div class="product-block-inner">';
						$output .= '<div class="product-block-left">';
						$output .= '<div class="image-block">';
						$placeholder_img = get_stylesheet_directory_uri()."/assets/images/placeholder.png";
						$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
						
							if ( has_post_thumbnail() ) {
								$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
								$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
									'title'	=> get_the_title( get_post_thumbnail_id() )
								));
								$output .= '<a href="'.get_permalink().'"><img alt="'.get_the_title().'" src="'.$image_link.'" height="'.$height.'"  width="'.$width.'"/></a>';
								}
							else{
								$output .= '<a href="'.get_permalink().'"><img href="'.get_permalink().'" alt="'.get_the_title().'" src="'.$placeholder_img.'" height="'.$height.'"  width="'.$width.'"/></a>';
							}

							if($product->is_on_sale()) :
								$regular_price = $product->get_regular_price();
								$sale_price = $product->get_sale_price();

								if($regular_price != $sale_price && $regular_price != 0){
									$discount = round(100-(($sale_price / $regular_price)*100));
									$class = floor((($sale_price / $regular_price)*100)/10)*10;
								}
									$output.='<span class="onsale">-'.$discount.'% </span>';
							endif;
							$output .= '</div>'; // close image-block div
							$output .= '</div>'; // product-block-left
							$output .= '<div class="product-block-right">';
							
							

							$output .='<div class="product-detail-wrapper">';
							/*$output .='<div class="product-description">'.tmpmela_excerpt(25).'</div>';*/
							
							$output .='<h2 class="product-name woocommerce-loop-product__title">';
							$output .='<a href="'.get_permalink().'">'.$product->get_title().'</a>';
							$output .='</h2>';
							$output .= wc_get_rating_html($rating);
							$output .='<div class="price">'.$product->get_price_html().'</div>';

							if ( ! $product->is_in_stock() ) :
								$output .= '<a href="'.apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->get_id() ) ).'" class="button">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', 'woocommerce' ) ).'</a>';
							else :
								$link = array(
									'url'   => '',
									'label' => '',
									'class' => ''
								);
								switch ( $product->get_type() ) {
									case "variable" :
										$link['url']    = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->get_id() ) );
										$link['label']  = apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'woocommerce' ) );
									break;
									case "grouped" :
										$link['url']    = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->get_id() ) );
										$link['label']  = apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'woocommerce' ) );
									break;
									case "external" :
										$link['url']    = apply_filters( 'external_add_to_cart_url', get_permalink( $product->get_id() ) );
										$link['label']  = apply_filters( 'external_add_to_cart_text', __( 'Read More', 'woocommerce' ) );
									break;
									default :
										if ( $product->is_purchasable() ) {
											$link['url']    = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
											$link['label']  = apply_filters( 'add_to_cart_text', __( 'Add to cart', 'woocommerce' ) );
											$link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button' );
										} else {
											$link['url']    = apply_filters( 'not_purchasable_url', get_permalink( $product->get_id() ) );
											$link['label']  = apply_filters( 'not_purchasable_text', __( 'Read More', 'woocommerce' ) );
										}
									break;
								}
							endif;

							$output .='<div class="count-down product-count-down">';
							$output .='<div class="countbox hastime" data-time="'.$sale_price_dates_to.'"></div>';							
							$output .= '</div>'; 

							$output .= '<div class="product-button">';
							// If there is a simple product.							
							if ( $product->get_type() == 'simple' ) {
								$output .= sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="button add_to_cart_button ajax_add_to_cart product_type_simple">%s</a>',
								esc_url( $product->add_to_cart_url() ),
								esc_attr( isset( $quantity ) ? $quantity : 1 ),
								esc_attr( $product->get_id() ),
								esc_attr( $product->get_sku() ),
								esc_html( $product->add_to_cart_text() ));
							}
							else {
								$output .= sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="button product_type_external">%s</a>',
								esc_url( $product->add_to_cart_url() ),
								esc_attr( isset( $quantity ) ? $quantity : 1 ),
								esc_attr( $product->get_id() ),
								esc_attr( $product->get_sku() ),
								esc_html( $product->add_to_cart_text() ));
							}

							if ( in_array( 'yith-woocommerce-quick-view/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):
								$output .= do_shortcode( "[yith_quick_view]" );
							endif;
							if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):
								$output .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
							endif;						
							if ( in_array( 'yith-woocommerce-compare/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):
								$output .= do_shortcode( "[yith_compare_button]" );						
							endif;
							$output .= '</div>';

							$output .= '</div>';					
							

							$output .= '</div>'; // Close product-block-right
							$output .='</div>';
							$output .= '</li>';
					}	
				}
			endwhile;
			wp_reset_postdata();

		endif;
		$output .='</ul>';
		$output .= '</div>';
	}
	return $output;
}
add_shortcode('hot_products', 'coderplace_hot_products');


/**
 * Vertical Product Categories Menu
 * 
 */
function vertical_product_categories() {	
	$taxonomy     = 'product_cat';
	$orderby      = 'name';
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no
	$title        = '';
	$empty        = 0;

	$args = array(
		'taxonomy'     => $taxonomy,
		'orderby'      => $orderby,
		'show_count'   => $show_count,
		'pad_counts'   => $pad_counts,
		'hierarchical' => $hierarchical,
		'title_li'     => $title,
		'hide_empty'   => $empty
	);

	$all_categories = get_categories( $args );

	echo '<div class="dropdown-toggle-nav">';
	echo '<div class="widget woocommerce widget_product_categories"><h2 class="widgettitle">'.esc_html__('Shop by Category', 'avanam').'</h2>';	
	echo '<ul class="product-categories">';
	foreach ( $all_categories as $cat ) {
		if ( $cat->category_parent == 0 ) {
			$category_id = $cat->term_id;			
			$args2 = array(
				'taxonomy'     => $taxonomy,
				'child_of'     => 0,
				'parent'       => $category_id,
				'orderby'      => $orderby,
				'show_count'   => $show_count,
				'pad_counts'   => $pad_counts,
				'hierarchical' => $hierarchical,
				'title_li'     => $title,
				'hide_empty'   => $empty
			);
			$sub_cats = get_categories( $args2 );
			// level - 1
			if ( $sub_cats ) {
				echo '<li class="cat-item cat-parent"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';
				if ( $sub_cats ) {
					echo '<ul class="children">';
					foreach( $sub_cats as $sub_category ) {
						$sub_category_id = $sub_category->term_id;			
						$args3 = array(
							'taxonomy'     => $taxonomy,
							'child_of'     => 0,
							'parent'       => $sub_category_id,
							'orderby'      => $orderby,
							'show_count'   => $show_count,
							'pad_counts'   => $pad_counts,
							'hierarchical' => $hierarchical,
							'title_li'     => $title,
							'hide_empty'   => $empty
						);
						$sub_sub_cats = get_categories( $args3 );

						// level - 2
						if ( $sub_sub_cats ) {
							echo  '<li class="cat-item cat-parent"><a href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a>';							
							echo '<ul class="children">';
							foreach( $sub_sub_cats as $sub_sub_category ) {
								// level - 3
								echo  '<li class="cat-item"><a href="'. get_term_link($sub_sub_category->slug, 'product_cat') .'">'. $sub_sub_category->name .'</a></li>';
							}
							echo '</ul></li>';
						}else{
							echo  '<li class="cat-item"><a href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a></li>';
						}
					}
					echo '</ul></li>';
				}
			}
			else{
				echo '<li class="cat-item"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></li>';
			}
		}
	}
	echo '</ul>';
	echo '</div>';
	echo '</div>';	
}
add_shortcode( 'cp-product-categories', 'vertical_product_categories' );

