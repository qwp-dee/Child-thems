<?php
// Country Custom Post type
if ( ! class_exists( 'Country_Post_Type' ) ) :
	class Country_Post_Type {
		public function __construct()
        {
			// Adds the EPL Job post type
			add_action( 'init', array( &$this, 'CountryInit' ) );
			add_action('after_theme_switch', array( &$this, 'CustomFlushRulesCountry') );
			// Add the data to the custom columns for the Partners post type:
			add_filter( 'manage_edit-job_columns', array( &$this, 'CustomEditCountryColumns'), 10, 1 );
			add_action( 'manage_job_posts_custom_column' , array( &$this, 'CountryColumns'), 10, 1 );
			// Show Partners post counts in the dashboard
			add_action( 'dashboard_glance_items', array( &$this, 'AddCountryCounts' ) );
			add_action('admin_head', array(&$this, 'CountryIcon'));
			// Add The Metabox CSS & JS Code Editor Admin Side.
			add_action('admin_enqueue_scripts', array(&$this, 'add_page_scripts_enqueue_script'));
			add_action('add_meta_boxes', array(&$this,'add_page_scripts'));
			add_action( 'save_post', array(&$this,'page_scripts_save_meta_box'));
			add_action('wp_head', array(&$this,'page_scripts_add_head'));
		}// End Constructor function.

		 // Function : CountryInit Used to register post type
		public function CountryInit() {
			$country_labels = array(
				'name'               	=> __( 'Countries'),
				'singular_name'      	=> __( 'Country'),
				'menu_name'          	=> __( 'Countries'),
				'name_admin_bar'     	=> __( 'Countries'),
				'add_new'            	=> __( 'Add Countries'),
				'add_new_item'       	=> __( 'Add New Countries'),
				'new_item'           	=> __( 'New Countries'),
				'edit_item'          	=> __( 'Edit Countries'),
				'view_item'          	=> __( 'View Countries'),
				'all_items'          	=> __( 'All Countries'),
				'search_items'       	=> __( 'Search Countries'),
				'parent_item_colon'  	=> __( 'Parent Countries:'),
				'not_found'          	=> __( 'No Countries found.'),
				'not_found_in_trash' 	=> __( 'No Countries found in Trash.'),
			);
			$country_args = array(
				'labels'             => $country_labels,
				'public'             => false,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => false,
				'rewrite'            => array( 'slug' => 'countries' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => true,
				'menu_position'		 =>	5,
				'taxonomies'          => array( 'category', 'post_tag' ),
				'menu_icon'			 => 'dashicons-admin-site-alt',
				'supports'           => array('title','page-attributes','editor','thumbnail','map','html'),
			);
			register_post_type( 'country', $country_args );
		}	//End CountryInit

		// Function : CustomFlushRulesCountry post type so the rules can be flushed.
		function CustomFlushRulesCountry(){
			//defines the post type so the rules can be flushed.
			CountryInit();
			//and flush the rules.
			flush_rewrite_rules();
		}

		// Function : CustomEditCountryColumns Add Column in Partner listing.
		function CustomEditCountryColumns($columns) {
			$columns_countries = array();
			foreach($columns as $key => $title){
				if($key == 'date'){
					$columns_countries['content'] = __( 'Content', 'eightpointlaw' );
					$columns_countries['order'] =  __( 'Order', 'eightpointlaw' );
				}
				$columns_countries[$key] = $title;
			}
			
		    return $columns_countries;
		}
		// Function : CountryColumns Add data to columns in Partner listing.
		function CountryColumns( $column) {
			global $post;
		    switch ( $column ) {
		        case 'content' :
					echo $post->post_content;
		            break;
		        case 'order' :
					echo $post->menu_order;
		            break;
		    }
		}

		// Function : AddCountryCounts Add DC Partner count to "Right Now" Dashboard Widget.
		function AddCountryCounts() {
			if ( ! post_type_exists( 'country' ) ) {
				return;
			}
			$num_posts = wp_count_posts( 'country' );
			$num = number_format_i18n( $num_posts->publish );
			$text = _n( '\'country\' Item', '\'country\' Items', intval($num_posts->publish) );
			if ( current_user_can( 'edit_posts' ) ) {
				$output = "<a href='edit.php?post_type=country'>$num $text</a>";
			}
			echo '<li class="post-count country-count">' . $output . '</li>';

			if ($num_posts->pending > 0) {
				$num = number_format_i18n( $num_posts->pending );
				$text = _n( '\'country\' Item Pending', '\'country\' Items Pending', intval($num_posts->pending) );
				if ( current_user_can( 'edit_posts' ) ) {
					$num = "<a href='edit.php?post_status=pending&post_type=country'>$num</a>";
				}
				echo '<li class="post-count country-count">' . $output . '</li>';
			}
		}

		// Function : Adding css,js editor admin side.
			function add_page_scripts_enqueue_script( $hook ) {
			    global $post;
			    if ( ! $post ) { return; }
			    if ( ! 'page' === $post->post_type ) { return; }
			    if( 'post.php' === $hook || 'post-new.php' === $hook ) {
			        wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
			        wp_enqueue_script( 'js-code-editor', CHI_THEME_URI . '/assets/js/code-editor.js', array( 'jquery' ), '', true );
			    }
			}

			// Function : Register the metabox.
			function add_page_scripts() {
    		add_meta_box( 'page-scripts', __( 'Page Scripts & Styles', 'textdomain' ), array(&$this,'add_page_metabox_scripts_html'), 'country', 'advanced' );
			}
			// Function : Meta box display callback.
		public function add_page_metabox_scripts_html( $post ) {
			    $post_id = $post->ID;
			    $page_scripts = get_post_meta( $post_id, 'page_scripts', true );
			    if ( ! $page_scripts ) {
			        $page_scripts = array(
			            'page_head' => '',
			            'js'        => '',
			            'css'       => '',
			        );
			    }
			    ?>
			    <fieldset>
			        <h3>Head Scripts</h3>
			        <p class="description">Enter scripts and style with the tags such as <code>&lt;script&gt;</code></p>
			        <textarea id="code_editor_page_head" rows="5" name="page_scripts[page_head]" class="widefat textarea"><?php echo wp_unslash( $page_scripts['page_head'] ); ?></textarea>   
			    </fieldset>
			    
			    <fieldset>
			        <h3>Only JavaScript</h3>
			        <p class="description">Just write javascript.</p>
			        <textarea id="code_editor_page_js" rows="5" name="page_scripts[js]" class="widefat textarea"><?php echo wp_unslash( $page_scripts['js'] ); ?></textarea>   
			    </fieldset>

			    <fieldset>
			        <h3>Only CSS</h3>
			        <p class="description">Do your CSS magic</p>
			        <textarea id="code_editor_page_css" rows="5" name="page_scripts[css]" class="widefat textarea"><?php echo wp_unslash( $page_scripts['css'] ); ?></textarea>   
			    </fieldset>
			    <?php
			}

			//  Function : Save meta box content.
			function page_scripts_save_meta_box( $post_id ) {
			    if( defined( 'DOING_AJAX' ) ) {
			        return;
			    }
			    if( isset( $_POST['page_scripts'] ) ) {
			        $scripts = $_POST['page_scripts'];
			        update_post_meta( $post_id, 'page_scripts', $scripts );
			    }
			}
			
			// Function : Put scripts in the head.
			function page_scripts_add_head() {
			    $post_id = get_the_id();
			    $page_scripts = get_post_meta( $post_id, 'page_scripts', true );
			    if ( ! $page_scripts ) { return; }
			    if ( isset( $page_scripts['page_head'] ) && '' !== $page_scripts['page_head'] ) {
			        echo wp_unslash( $page_scripts['page_head'] );
			    }
			    if ( isset( $page_scripts['js'] ) && '' !== $page_scripts['js'] ) {
			        echo '<script>' . wp_unslash( $page_scripts['js'] ) . '</script>';
			    }
			    if ( isset( $page_scripts['css'] ) && '' !== $page_scripts['css'] ) {
			        echo '<style>' . wp_unslash( $page_scripts['css'] ) . '</style>';
			    }
			}

		// Function : CountryIcon Displays the custom post type icon in the dashboard.
        function CountryIcon() {
            ?>
            <style type="text/css" media="screen">
                .job-count a:before {
                    content: "\f338" !important;
                }
            </style>
        <?php
        }
	} //End Class.
	new Country_Post_Type;
endif; ?>