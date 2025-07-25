<?php
/**
 * Functions.php file for GV Lenguas Child Theme
 *
 * Assumes parent is gv-project-theme.
 * This code will run before the functions.php in that theme.
 */

/**
 * Insert popular_yesterday headlines at the end of the post footer
 *
 * @see single.php which calls do_action('gv_theme_post_footer_end', $post);
 * @param WP_Post $post_object
 * @return void
 */
function gv_lenguas_theme_post_footer_headlines(WP_Post $post_object) {
	
	if (is_page()) {
		return;
	}

	gv_display_headlines(array(
		'type' => 'popular_yesterday',
		'count' => 3,
		'content_css_classes' => " postfooter-headlines",
	));
}
// add_action('gv_theme_post_footer_end', 'gv_lenguas_theme_post_footer_headlines');


/**
 * Register fonts for GV Project Theme
 * 
 * @global GV_Theme_Fonts $gv_theme_fonts
 */
function gv_lenguas_register_theme_fonts() {
	global $gv_theme_fonts;
	
	if (!is_a($gv_theme_fonts, 'GV_Theme_Fonts')) {
		return;
	}
	
	$heading_stack = "'Seravek', source-sans-pro, BlinkMacSystemFont, -apple-system, 'Roboto', 'Nimbus Sans', system-ui, sans-serif;";

	$gv_theme_fonts->update_group_font_family('default', $heading_stack);
	$gv_theme_fonts->update_group_font_family('article',$heading_stack);
}
add_action('after_setup_theme', 'gv_lenguas_register_theme_fonts');

/**
 * Hide author credits on 'directorio' posts
 *
 * @return void
 */
function gv_lenguas_css_hide_credits_on_directorio_posts() {

	if (!is_single() OR !is_object_in_term(get_queried_object_id(), 'category', 'directorio')) {
		return;
	}

	echo "<!--gv_lenguas_css_hide_credits_on_directorio_posts()-->\n<style>.avatar-credits-container, .postmeta-container .license {display:none;}</style>\n";
}
add_action('wp_head', 'gv_lenguas_css_hide_credits_on_directorio_posts');

if (isset($gv) AND is_object($gv)) :

	/**
	 * Disable automatic plugin activation from parent theme. We need this theme to work in MU
	 * ! Re-enabled/dis-disabled 2021-10-13 on the assumption that all of the default plugins now work on multisite/rv
	 * 
	 */
	// define('GV_NO_DEFAULT_PLUGINS', TRUE);

	/**
	 * Define GV_LINGUA as false to override the TRUE definition in the projects theme 
	 */
	if (!defined('GV_LINGUA'))
		define('GV_LINGUA',  TRUE);
	
	/**
	 * Register Lenguas 2015 microgrants questions
	 * 
	 * Should only apply to posts in lenguas-2015 category, so it should be fine to leave it here indefinitely
	 */
	include_once('gv-microgrants-questions-lenguas-2015.php');
	
	/**
	 * Register Lenguas Projects Listing questions for 2020
	 * 
	 * Goes with a Gravity Forms form that submits post drafts with the 'directorio' category and a bunch of
	 * custom fields that get registered for admin display and frontend display in this file. 
	 * 
	 * ! 2023-07: Duplicated the file for 2023, when we cleaned up and simplified the questions and display
	 */
	// include_once('lenguas-projects-questions-2020.php');
	include_once('lenguas-projects-questions-2023.php');
	
	/**
	 * For geo mashup plugin show excerpts instead of thumbnails
	 */
//	add_filter('gv_geo_mashup_show_thumbnail', '__return_false');
//	add_filter('gv_geo_mashup_show_excerpt', '__return_true');
	
	/**
	 * Define excerpt length
	 */
//	if (!defined('GV_EXCERPT_LENGTH'))
//		define('GV_EXCERPT_LENGTH', 999);
	
	/**
	 * Define an image to show in the header.
	 * Project theme generic has none, so it will use site title
	 */
//	$gv->settings['header_img'] = get_stylesheet_directory_uri() . '/RisingVoices-microgrants-amazonia-600.png';	
	
	/**
	 * Register custom postmeta fields with the Custom Medatata Manager plugin
	 *
	 * Convert to some other format if this ever stops working
	 */
	function gv_microgrants_custom_metadata_manager_admin_init() {
		
		/**
		 * Exit if GV_MICROGRANTS_METADATA_DEFINED constant is true, it means the questions
		 * were already defined in a plugin.
		 * 
		 * Expected for old sites using this theme so they can keep their questions
		 */
		if (defined('GV_MICROGRANTS_METADATA_DEFINED'))
			return;
		
		/**
		 * Exit if the plugin isn't present
		 */
		if(!function_exists( 'x_add_metadata_field' ) OR !function_exists( 'x_add_metadata_group' ) )
			return;
		
		/**
		 * Register a group for pages and posts
		 */
		x_add_metadata_group('gv_custom_metadata_posts', array('post'), array(
			'label' => 'GV Custom Metadata',
			'priority' => 'high',
		));
		/**
		 * Proposal Community
		 */
		x_add_metadata_field( 'proposal-community', array('post'), array(
			'group' => 'gv_custom_metadata_posts',
			'label' => 'Describe the specific population with whom you will be working',
			'field_type' => 'textarea',
		));

		/**
		 * Proposal Privacy Reason
		 */
		x_add_metadata_field( 'proposal-privacy-reason', array('post'), array(
			'group' => 'gv_custom_metadata_posts',
			'label' => 'Why don\'t you want us to publish your proposal?',
			'field_type' => 'textarea',
		));

	//	/**
	//	 * Hide creation/update dates, pages only
	//	 */
	//	x_add_metadata_field('gv-hide-dates', array( 'page'), array(
	//		'group' => 'gv_custom_metadata_posts',
	//		'label' => 'Hide dates on post (creation and last updated)',
	//		'field_type' => 'checkbox',
	//	));	
	}
//	add_action( 'admin_init', 'gv_microgrants_custom_metadata_manager_admin_init', 15);

	/**
	 * Register postmeta inserts
	 * 
	 * These will be auto-inserted into post content
	 */
	function gv_microgrants_register_postmeta_inserts() {

		if (!function_exists('gv_register_postmeta_insert'))
			return;

		/**
		 * Exit if GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED constant is true, it means the questions
		 * were already defined in a plugin.
		 * 
		 * Expected for old sites using this theme so they can keep their questions
		 */
		if (defined('GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED'))
			return;
		
		gv_register_postmeta_insert(array(
			'taxonomy' => 'gv_topics',
			'label' => 'Topical focus:',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'taxonomy' => 'gv_geo',
			'label' => 'Country:',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-city',
			'label' => 'What locality or neighborhood will your project focus on?',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-community',
			'label' => 'Describe the specific population with whom you will be working.',
			'position' => 'bottom',
		));

		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-team',
			'label' => 'Who else will be on your team to help implement the project?',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-content-vision',
			'label' => 'What kinds of news, stories and other content will be created?',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'taxonomy' => 'gv_tools',
			'label' => 'What technologies and digital tools do you plan to use in the trainings?',
			'position' => 'bottom',
		));		
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-tools',
			'label' => 'Other tools',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-connections',
			'label' => 'Describe the connections that you or your organization have already established or plan to establish that will contribute to the success of the project.',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-participants',
			'label' => 'How many participants do you think will be trained in your project?',
			'position' => 'bottom',
		));

		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-technical',
			'label' => 'Describe which technologies, tools, and media you will focus on when training participants.',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-facilities',
			'label' => 'Describe the facilities where you will hold the workshops.',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-relationship',
			'label' => 'What is your current relationship with the community with whom you plan to work? What makes you the most appropriate individual or organization to implement this project?',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-challenges',
			'label' => 'What specific challenges do you expect to face when planning and implementing your project?',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-impact',
			'label' => 'How will you measure and evaluate the project’s impact, specifically: your primary participants, the wider regional community, or the global digital community?',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-timeline',
			'label' => ' If your project were to be selected as a Rising Voices grantee, what would be the general timeline of project activities in 2014?',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-budget',
			'label' => 'Detail a specific budget of up to $2,500 USD for operating costs.',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-otherresources',
			'label' => 'Besides the microgrant funding, what other support can Rising Voices provide for your project to ensure its success?',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-contact',
			'label' => 'Contact name',
			'position' => 'bottom',
		));
		
//		gv_register_postmeta_insert(array(
//			'postmeta_field_name' => 'proposal-email',
//			'label' => 'Your email address',
//			'position' => 'bottom',
//		));

		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-organization',
			'label' => 'Organization',
			'position' => 'bottom',
		));
		
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-url',
			'label' => 'Link to Existing Project',
			'position' => 'bottom',
			'display' => 'url',
		));
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-twitter',
			'label' => 'Twitter URL',
			'position' => 'bottom',
			'display' => 'url',
		));
		gv_register_postmeta_insert(array(
			'postmeta_field_name' => 'proposal-facebook',
			'label' => 'Facebook URL',
			'position' => 'bottom',
			'display' => 'url',
		));

	}
//	add_action('init', 'gv_microgrants_register_postmeta_inserts', 15);

	/**
	 * Insert "Long Description" h3 above post content
	 * 
	 * Used to make post body match style of fields inserted above it 
	 * by gv_register_postmeta_field
	 * 
	 * @global object $post Post object who's content is being filtered
	 * @param string $content Post content to filter
	 * @return string Filtered content
	 */
	function gv_microgrants_add_long_description_top_of_content($content) {
		global $post;
		if (is_admin() OR ('post' != $post->post_type))
			return $content;
		
		$content = "<h3>Long Description</h3>" . $content;
		
		return $content;
	}
//	add_filter('the_content', 'gv_microgrants_add_long_description_top_of_content');
	
	/**
	 * Register taxonomies for this site
	 */
	function gv_microgrants_register_taxonomies() {
		/**
		 * Register geo taxonomy for posts
		 */
		register_taxonomy('gv_geo', 'gv_geo', array(
			'labels' => array(
			    'name' => _lingua('region_categories'),
			    'singular_name' => _lingua('region_category'),
			    'search_items' => _lingua('search_region_categories'),
			    'all_items' => _lingua('all_region_categories'),
			    'parent_item' => _lingua('parent_region_category'),
			    'parent_item_colon' => _lingua('parent_region_category') . ":",
			    'edit_item' => _lingua('edit_region_category'),
			    'update_item' => _lingua('edit_region_category'),
			    'add_new_item' => _lingua('add_region_category'),
			    'new_item_name' => _lingua('new_region_category_name'),
			    'menu_name' => _lingua('region_categories'),
			  ),			
			'public' => true,
			'show_ui' => true,
			// fixes http://core.trac.wordpress.org/ticket/14084
			'update_count_callback' => '_update_post_term_count',
			'show_admin_column' => true,
			'hierarchical' => true,
			'query_var' => 'geo',
			'rewrite' => array(
				'slug' => 'geo'
			),		));
		register_taxonomy_for_object_type('gv_geo', 'post');
		
		/**
		 * Register Topics taxonomy
		 */
//		register_taxonomy('gv_topics', 'gv_topics', array(
//			'labels' => array(
//			    'name' => _lingua('topic_categories'),
//			    'singular_name' => _lingua('topic_category'),
//			    'search_items' => _lingua('search_topic_categories'),
//			    'all_items' => _lingua('all_topic_categories'),
//			    'parent_item' => _lingua('parent_topic_category'),
//			    'parent_item_colon' => _lingua('parent_topic_category') . ":",
//			    'edit_item' => _lingua('edit_topic_category'),
//			    'update_item' => _lingua('edit_topic_category'),
//			    'add_new_item' => _lingua('add_topic_category'),
//			    'new_item_name' => _lingua('new_topic_category_name'),
//			    'menu_name' => _lingua('topic_categories'),
//			),			
//			'public' => true,
//			'show_ui' => true,
//			// fixes http://core.trac.wordpress.org/ticket/14084
//			'update_count_callback' => '_update_post_term_count',
//			'show_admin_column' => true,
//			'hierarchical' => true,			
//			'query_var' => 'topic',
//			'rewrite' => array(
//				'slug' => 'topic'
//			),
//		));
//		register_taxonomy_for_object_type('gv_topics', 'post');

		/**
		 * Register languages taxonomy
		 */
		register_taxonomy('gv_languages', 'gv_languages', array(
			'labels' => array(
			    'name' => _lingua('language_categories'),
			    'singular_name' => _lingua('language_category'),
			    'search_items' => _lingua('search_language_categories'),
			    'all_items' => _lingua('all_language_categories'),
			    'parent_item' => _lingua('parent_language_category'),
			    'parent_item_colon' => _lingua('parent_language_category') . ":",
			    'edit_item' => _lingua('edit_language_category'),
			    'update_item' => _lingua('edit_language_category'),
			    'add_new_item' => _lingua('add_language_category'),
			    'new_item_name' => _lingua('new_language_category_name'),
			    'menu_name' => _lingua('language_categories'),
			),			
			'public' => true,
			'show_ui' => true,
			// fixes http://core.trac.wordpress.org/ticket/14084
			'update_count_callback' => '_update_post_term_count',
			'show_admin_column' => true,
			'hierarchical' => true,			
			'query_var' => 'topic',
			'rewrite' => array(
				'slug' => 'topic'
			),
		));
		register_taxonomy_for_object_type('gv_languages', 'post');

		/**
		 * Register tool categories
		 */
		register_taxonomy('gv_tools', 'gv_tools', array(
			'labels' => array(
			    'name' => _lingua('tool_categories'),
			    'singular_name' => _lingua('tool_category'),
			    'search_items' => _lingua('search_tool_categories'),
			    'all_items' => _lingua('all_tool_categories'),
			    'parent_item' => _lingua('parent_tool_category'),
			    'parent_item_colon' => _lingua('parent_tool_category') . ":",
			    'edit_item' => _lingua('edit_tool_category'),
			    'update_item' => _lingua('edit_tool_category'),
			    'add_new_item' => _lingua('add_tool_category'),
			    'new_item_name' => _lingua('new_tool_category_name'),
			    'menu_name' => _lingua('tool_categories'),
			  ),
			'public' => true,
			'show_ui' => true,
			// fixes http://core.trac.wordpress.org/ticket/14084
			'update_count_callback' => '_update_post_term_count',
			'show_admin_column' => true,			
			'hierarchical' => true,
			'query_var' => 'tools',
			'rewrite' => array(
				'slug' => 'tools'
			),		
		));
		register_taxonomy_for_object_type('gv_tools', 'post');

		/**
		 * Register "public taxonomies" for gv_taxonomies system to display automatically on posts
		 */
		// Unregister defaults as they aren't useful for this site
		gv_unregister_public_taxonomy('post_tag');
		
		// Remove category then add it back later so it's after the lang/geo/tools taxonomies
		gv_unregister_public_taxonomy('category');

		gv_register_public_taxonomy('gv_languages');
		gv_register_public_taxonomy('gv_geo');
		gv_register_public_taxonomy('gv_tools');
		gv_register_public_taxonomy('category');

		/**
		 * Register gv_special custom taxonomy as public
		 * 
		 * Matches gv-news-theme
		 */
		gv_register_public_taxonomy('gv_special');

	
		/**
		 * Filter gv_display_post_terms $before arg to remove middot 
		 * 
		 * Needed because we hide the author with CSS so there's nothing before it
		 * 
		 * @see gv_taxonomies::display_post_terms() where this filter is called
		 * @param string $before HTML string passed to display_post_terms for us to filter
		 * @param aray $args Args passed to display_post_terms for context checking
		 * @return string Filtered before text
		 */
		function gv_news_filter_display_post_terms_before($before, $args) {
			
			// Only set limit if we're on inline format
			if ('inline' == $args['format'])
				$before = str_replace ('&middot;', 'Categories: ', $before);
			
			return $before;
		}
		add_filter('gv_display_post_terms_before', 'gv_news_filter_display_post_terms_before', 10, 2);
		
		/**
		 * Filter tag cloud widget arguments to remove limit on number to show
		 * 
		 * 
		 * @see WP_Widget_Tag_Cloud Widget class for the tag cloud widget
		 * @param array $args All default arguments
		 * @return array Modified arguments
		 */
		function gv_microgrants_filter_widget_tag_cloud_args($args) {
			$args['number'] = 0;
			
			return $args;
		}
		add_filter('widget_tag_cloud_args', 'gv_microgrants_filter_widget_tag_cloud_args');
		
	}
	add_filter('init', 'gv_microgrants_register_taxonomies');
	
	/**
	 * Register strings specific to this site for Theme Translator
	 */
	function gv_lenguas_register_theme_strings() {	
		
		/**
		 * Region categories
		 */
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'country', 
			'default_text' => 'Country',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'region_categories', 
			'default_text' => 'Region Categories',
			'note' => 'Labels for the custom taxonomies used by the Lenguas child theme. These are separate from the usual "topics" and "regions" of the main GV site.',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'region_category', 
			'default_text' => 'Region Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'search_region_categories', 
			'default_text' => 'Search Region Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'all_region_categories', 
			'default_text' => 'All Region Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'parent_region_category', 
			'default_text' => 'Parent Region Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'edit_region_category', 
			'default_text' => 'Edit Region Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'add_region_category', 
			'default_text' => 'Add New Region Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'new_region_category_name', 
			'default_text' => 'New Region Category Name',
			'note' => '',
			)
		);
		/**
		 * Topic categories
		 */
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'topic_categories', 
			'default_text' => 'Topic Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'topic_category', 
			'default_text' => 'Topic Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'search_topic_categories', 
			'default_text' => 'Search Topic Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'all_topic_categories', 
			'default_text' => 'All Topic Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'parent_topic_category', 
			'default_text' => 'Parent Topic Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'edit_topic_category', 
			'default_text' => 'Edit Topic Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'add_topic_category', 
			'default_text' => 'Add New Topic Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'new_topic_category_name', 
			'default_text' => 'New Topic Category Name',
			'note' => '',
			)
		);
		/**
		 * Language categories
		 */
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'language_categories', 
			'default_text' => 'Language Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'language_category', 
			'default_text' => 'Language Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'search_language_categories', 
			'default_text' => 'Search Language Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'all_language_categories', 
			'default_text' => 'All Language Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'parent_language_category', 
			'default_text' => 'Parent Language Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'edit_language_category', 
			'default_text' => 'Edit Language Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'add_language_category', 
			'default_text' => 'Add New Language Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'new_language_category_name', 
			'default_text' => 'New Language Category Name',
			'note' => '',
			)
		);
		/**
		 * Tool categories
		 */
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'digital_tools', 
			'default_text' => 'Digital Tools',
			'note' => '',
			)
		);
		 gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'tool_categories', 
			'default_text' => 'Tool Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'tool_category', 
			'default_text' => 'Tool Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'search_tool_categories', 
			'default_text' => 'Search Tool Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'all_tool_categories', 
			'default_text' => 'All Tool Categories',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'parent_tool_category', 
			'default_text' => 'Parent Tool Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'edit_tool_category', 
			'default_text' => 'Edit Tool Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Lenguas Taxonomy Labels', 
			'string_slug' => 'add_tool_category', 
			'default_text' => 'Add New Tool Category',
			'note' => '',
			)
		);
		gv_register_theme_string(array(
			'section' => 'Microgrants Taxonomy Labels', 
			'string_slug' => 'new_tool_category_name', 
			'default_text' => 'New Tool Category Name',
			'note' => '',
			)
		);
	}
	add_filter('after_setup_theme', 'gv_lenguas_register_theme_strings');

	/**
	 * Filter the og:image (facebook/g+) default icon to be an RV logo
	 * 
	 * @param string $icon Default icon
	 * @return string desired icon
	 */
	function gvadvocacy_theme_gv_og_image_default($icon) {
		return gv_get_dir('theme_images') ."lenguas-fb-logo-1200x631.png";
	}
	add_filter('gv_og_image_default', 'gvadvocacy_theme_gv_og_image_default');
	
	/**
	 * Filter ALL CASES OF og:image (facebook/g+) icon to be an RV logo
	 * 
	 * @param string $icon Default icon
	 * @return string desired icon
	 */
	function gvadvocacy_theme_gv_og_image($icon) {
		return gv_get_dir('theme_images') ."rv-logo-square-600.png";
	}
//	add_filter('gv_og_image', 'gvadvocacy_theme_gv_og_image');
	

		/**
	 * Geo Mashup maps options partial_overrides
	 */
	if (!isset($gv->option_overrides['partial_overrides'])) :
		$gv->option_overrides['partial_overrides'] = array();
	endif;
	if (!isset($gv->option_overrides['partial_overrides']['geo_mashup_options'])) :
		$gv->option_overrides['partial_overrides']['geo_mashup_options'] = array(
			'overall' => array(
				'copy_geodata' => true,
				'theme_stylesheet_with_maps' => false,
			),
			'global_map' => array(
				'width' => '100%',
				'height' => '480',
				'auto_info_open' => false, 
				'enable_scroll_wheel_zoom' => false,
				'zoom' => 2,
				'max_posts' => 50,
			),
			'single_map' => array(
				'width' => '100%',
				'height' => '480',
				'zoom' => 7,
				'enable_scroll_wheel_zoom' => false,
			),
			'context_map' => array(
				'width' => '100%',
				'height' => '480',
				'zoom' => 7,
				'enable_scroll_wheel_zoom' => false,
			),
		);
	endif;
	
	/**
	 * Sponsors definition to be used by gv_get_sponsors()
	 */
	$gv->sponsors = array(
		'risingvoices' => array(
			"name" => "Rising Voices",
			"slug" => "risingvoices",
			'description' => 'Rising Voices, un proyecto de Global Voices que ayuda a difundir los medios ciudadanos en lugares que normalmente no tienen acceso a ellos',
			"url" => "https://rising.globalvoices.org/",
			'status' => 'featured',
			),
//		'globalvoices' => array(
//			"name" => "Global Voices",
//			"slug" => "globalvoices",
//			'description' => 'Global Voices - Citizen media stories from around the world',
//			"url" => "https://globalvoices.org/",
//			'status' => 'featured',
//			),
	);
	
endif; // is_object($gv)

/**
 * Register any full custom taxonomies
 * 
 * Runs on after_setup_theme:10 because of gv->get_theme_translation() timing
 * 
 * @see gv_custom_taxonomy->__construct() for details on the translation timing
 * @return void
 */
function gv_lenguas_register_custom_taxonomies() {
	/**
	 * Register Special Categories taxonomy
	 */
	$special_topics_taxonomy = new gv_custom_taxonomy('gv_special', array('post'), array(
		'labels' => array(
			'name' => 'Special Categories',
			'singular_name' => 'Special Category',
			'search_items' => 'Search Special Categories',
			'all_items' => 'All Special Categories',
			'parent_item' => 'Parent Special Category',
			'parent_item_colon' => "Parent Special Category:",
			'edit_item' => "Edit Special Category",
			'update_item' => "Update Special Category",
			'add_new_item' => "Add New Special Category",
			'new_item_name' => "New Special Category",
			'menu_name' => "Special Categories",
		),			
		'public' => true,
		'show_ui' => true,
		// fixes http://core.trac.wordpress.org/ticket/14084
		'update_count_callback' => '_update_post_term_count',
		'show_admin_column' => false,
		'hierarchical' => true,
		'query_var' => 'special',
		'rewrite' => array(
			'slug' => 'special'
		),
		'capabilities' => array(
			// Allow "editors" to see admin sidebar menu and edit terms
			'manage_terms' => 'edit_users',
			'edit_terms' => 'edit_users',
			'delete_terms' => 'manage_options',
			'assign_terms' => 'edit_posts',
		),	
	));
	/**
	 * Whitelist this taxonomy so that it gets sent in GV_REST_Extension
	 * 
	 * Reference:
	 * 	return apply_filters('gv_taxonomy_whitelist', array('category', 'post_tag'));
	 */
	function gv_filter_gv_taxonomy_whitelist_to_add_gv_special($taxonomies) {
		$taxonomies[] = 'gv_special';
		return $taxonomies;
	}
	add_filter('gv_taxonomy_whitelist', 'gv_filter_gv_taxonomy_whitelist_to_add_gv_special');

	/**
	 * Always disable featured posts for gv_special taxonomy archives
	 * 
	 * Filters `gv_load_featured_posts` which controls display of the featured posts 
	 * 
	 * @param bool $bool Whether featured posts display on the current page
	 * @return void
	 */
	function gv_theme_special_categories_disable_featured_posts($bool) {

		if (gv_is_taxonomy_archive('gv_special')) {
			return false;
		}
		return $bool;
	}
	// add_filter('gv_load_featured_posts', 'gv_theme_special_categories_disable_featured_posts');
	 
}
add_action('after_setup_theme', 'gv_lenguas_register_custom_taxonomies');

/**
 * Filter gv_post_archive_hide_dates to hide them on homepage
 * 
 * @param bool $hide_dates
 * @return bool
 */
function lenguas_gv_post_archive_hide_dates($hide_dates) {
	
	if (is_home() AND !is_paged()) {

		return true;
	}
	
	return $hide_dates;
}
add_filter('gv_post_archive_hide_dates', 'lenguas_gv_post_archive_hide_dates', 10);

/**
 * Filter post archive loop args to force the grid-3 format for certain taxonomy archives
 *
 * Use with gv_post_archive_loop_args filter from GV_Post_Archive->determine_post_loop_args()
 * e.g.:
 * 	add_filter('gv_post_archive_loop_args', 'lenguas_filter_gv_post_archive_loop_args', 10, 2);
 * 
 * @param array $post_loop_args 
 * @param GV_Post_Archive $gv_post_archive_object For reference
 * @return void
 */
function lenguas_filter_gv_post_archive_loop_args(array $post_loop_args, $gv_post_archive_object) {

	// Only apply to this/these categories, run the check multiple times with AND ! if necessary
	if (!gv_is_taxonomy_archive('category', 'directorio')) {
		return $post_loop_args;
	}

	$post_loop_args['format_class'] = 'GV_Card_Loop_Format_Grid_3';

	return $post_loop_args;
}
add_filter('gv_post_archive_loop_args', 'lenguas_filter_gv_post_archive_loop_args', 10, 2);

/**
 * Filter post promo card args in card loops to hide credits and show terms instead
 *
 * @param array $card_args
 * @param GV_Card_Loop_Format $format_object
 * @return void
 */
function lenguas_theme_filter_card_loop_format_card_args_to_show_terms_not_credits(array $card_args, GV_Card_Loop_Format $format_object) {

	$card_args['show_credits'] = false;
	$card_args['show_terms'] = true;

	return $card_args;
}
add_filter('gv_filter_card_loop_format_card_args', 'lenguas_theme_filter_card_loop_format_card_args_to_show_terms_not_credits', 10, 2);

/**
 * Filter display post terms limit to make it unlimited for certain taxonomy archives
 *
 * Use with gv_display_post_terms_limit filter from gv_taxonomies->display_post_terms()
 * e.g.:
 * 	add_filter('gv_display_post_terms_limit', 'lenguas_filter_gv_post_archive_loop_args', 10, 2);
 * 
 * @param array $post_loop_args
 * @param GV_Post_Archive $gv_post_archive_object For reference
 * @return void
 */
function lenguas_filter_gv_display_post_terms_limit($limit, $args) {
	
	// Only insert this for posts in the main loop, excluding widgets/headlines/etc.
	if (!gv_backtrace_contains_function('gv_display_post_promo_card')) {
		return $limit;
	}

	// We return two, hoping for one language and one country, but ultimately it will return them all based on public taxonomy order
	return 2;
}
add_filter('gv_display_post_terms_limit', 'lenguas_filter_gv_display_post_terms_limit', 10, 2);

/**
 * Filter public taxonomies on output to hide the ones directorio posts insert in the content
 *
 * Makes sure we don't show lang/geo/tools twice on directorio posts
 * 
 * Filter ref: apply_filters('gv_get_post_public_taxonomy_terms_public_taxonomies', $public_taxonomy_definitions, $args);
 * 
 * @param array $public_taxonomy_definitions
 * @param array $args 
 * @return array
 */
function lenguas_filter_gv_get_post_public_taxonomy_terms_public_taxonomies_to_hide_on_directorio($public_taxonomy_definitions, $args) {

	/**
	 * Make sure we're on a single page and that we're showing the queried object
	 */
	if (!is_single()) {
		return $public_taxonomy_definitions;
	}
	
	if (!isset($args['post_object']) OR !is_a($args['post_object'], 'WP_Post')) {
		return $public_taxonomy_definitions;
	}
	
	if ($args['post_object']->ID != get_queried_object_id()) {
		return $public_taxonomy_definitions;
	}
	
	/**
	 * Make sure the single post is in the 'directorio' category
	 */
	if (!has_term('directorio', 'category', get_queried_object())) {
		return $public_taxonomy_definitions;
	}

	/**
	 * Remove these taxonomies because they are automatically inserted in the post with a large display
	 */
	$taxonomies_to_remove = array(
		'gv_languages',
		'gv_geo', 
		'gv_tools',
	);

	foreach ($public_taxonomy_definitions AS $slug => $details) {
		if (in_array($slug, $taxonomies_to_remove)) {
			unset($public_taxonomy_definitions[$slug]);
		}
	}

	return $public_taxonomy_definitions;
}
add_filter('gv_get_post_public_taxonomy_terms_public_taxonomies', 'lenguas_filter_gv_get_post_public_taxonomy_terms_public_taxonomies_to_hide_on_directorio', 10, 2);