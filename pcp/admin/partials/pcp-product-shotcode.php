<?php
/**
 * Provide the html and the functionality of filter under shortcode. 
 *
 */
?>

<div class="filter-product-div-wrap">
  <div class="filter-div-wrap">
    <?php 
      $taxonomy_size = display_taxonomy_terms_and_subcategories_accordion('size');
      $taxonomy_color = display_taxonomy_terms_and_subcategories_accordion('color');
      if( ( isset( $taxonomy_size ) && !empty( $taxonomy_size ) )  || ( isset( $taxonomy_color ) && !empty( $taxonomy_color ) ) ){
        echo '<input type="button" class="apply-filter-btn" id="apply-filter-btn" value="Apply Filer">';
      }
    ?>
  </div>
  <?php
    $args = array(
      'post_type'      => 'product',
      'posts_per_page' => -1,
      'orderby'        => 'date',
      'order'          => 'DESC'
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
    echo '<div class="flex-container">';

    while ($query->have_posts()) {
        echo '<div class="flex-item">';
        $query->the_post();
        echo "<div class='image-container'>";
        if (has_post_thumbnail()) {
            echo the_post_thumbnail( 'full' );
        }
        echo "</div>";
        echo '<h2>'.get_the_title().'</h2>';
        echo '<div>'.get_the_excerpt().'</div>';
        echo '</div>';
    }
    echo '</div>';
    } else {
      echo 'No Product Found!';
    }
  ?>
</div>

<?php 
	/**
	 * In this functions we are getting the taxonomy (size,color) and print that in frontend.
	 */
  function display_taxonomy_terms_and_subcategories_accordion( $taxonomy = "" ) {
    if( empty( $taxonomy ) ){ return false; }
      $parent_terms = get_terms(array(
          'taxonomy' => $taxonomy,
          'parent' => 0, 
          'hide_empty' => false,
      ));
      if ( !empty( $parent_terms ) && !is_wp_error( $parent_terms )) {
        echo '<h2>'.ucfirst($taxonomy).'</h2>';
        echo '<div class="taxonomy-wrap">';
        foreach ($parent_terms as $parent_term) {
        echo  '<div class="checkbox-container">
                  <label class="checkbox-label">
                      <input type="checkbox" class="checkbox-input '.esc_html($taxonomy).'-filter" data-'.esc_html($taxonomy).'="'.esc_html($parent_term->slug).'">
                      <span class="checkbox-text">'.esc_html($parent_term->name).'</span>
                  </label>
              </div>';
          }
          echo '</div>';
      return true;
      }
    }
