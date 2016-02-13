
add_shortcode( 'taxonomyterm', 'taxonomyterm_func' );
function taxonomyterm_func( $atts ) {
   extract( shortcode_atts( array(
      'term' => 'something'
   ), $atts ) );

   $termLink = get_term_link($term, "type");

   return '<div class="term-title"><h5><a href="'.$termLink.'">'.$term.'</a></h5></div>';
}

add_action( 'vc_before_init', 'taxonomy_integrateWithVC' );
function taxonomy_integrateWithVC() {
   vc_map( array(
      "name" => __( "Taxonomy", "my-text-domain" ),
      "base" => "taxonomyterm",
      "class" => "",
      "category" => __( "Content", "my-text-domain"),
      'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
      'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
      "params" => array(
         array(
            "type" => "taxonomy",
            "holder" => "div",
            "class" => "",
            "heading" => __( "Select a taxonomy term", "my-text-domain" ),
            "param_name" => "term",
            "value" => __( "Default taxonomy value", "my-text-domain" ),
            "description" => __( "Choose a term for taxonomy 'Types' ", "my-text-domain" )
         )
      )
   ) );
}

vc_add_shortcode_param( 'taxonomy', 'taxonomy_settings_field', get_template_directory_uri().'/vc_extend/tax.js');
function taxonomy_settings_field( $settings, $value ) {

  $sel .= '<select name="' . esc_attr( $settings['param_name'] ) . '" class="term-select wpb_vc_param_value wpb-textinput ' .esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field">';
  $terms = get_terms( 'type' );
  	foreach( $terms as $t ):
  $sel .= '<option value="'.$t->name.'">' . $t->name . '</option>';
	endforeach; 
  $sel .= '</select>';
  return $sel;

   
}
