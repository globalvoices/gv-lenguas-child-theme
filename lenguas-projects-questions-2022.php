<?php

/**
 * Register custom postmeta fields with the Custom Medatata Manager plugin
 *
 * Convert to some other format if this ever stops working
 */
function gv_lenguas_2022_project_custom_metadata_manager_admin_init()
{
	/**
	 * Exit if the plugin isn't present
	 */
	if (!function_exists('x_add_metadata_field') or !function_exists('x_add_metadata_group'))
		return;

	/**
	 * Make sure we are on a post editing screen
	 */
	$current_screen = get_current_screen();
	if ('post' != $current_screen->base)
		return;

	/**
	 * Get the object of hte post being edited
	 */
	$post = '';
	// Editor stores it in _GET
	if (isset($_GET['post']) and get_post($_GET['post'])) {
		$post = get_post($_GET['post']);
		// During post saving it's in _POST
	} elseif (isset($_POST['post_ID']) and get_post($_POST['post_ID'])) {
		$post = get_post($_POST['post_ID']);
	}

	/**
	 * Exit unless this post is in the appropriate category
	 */
	if (!is_object($post) or empty($post->ID) or !has_term('directorio', 'category', $post->ID)) {

		return;
	}

	/**
	 * Register a group for pages and posts
	 */
	x_add_metadata_group('gv_custom_metadata_posts', array('post'), array(
		'label' => 'GV Custom Metadata',
		'priority' => 'high',
	));
	/**
	 * Project Language
	 */
	x_add_metadata_field('project-language-other', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Si tu lengua no figura en las opciones disponibles, escríbalo aquí.',
		'field_type' => 'textarea',
	));
	/**
	 * Project Summary
	 */
	x_add_metadata_field('project-summary', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Project Summary',
		'field_type' => 'textarea',
	));

	/**
	 * Project website
	 */
	x_add_metadata_field('project-website', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Sitio web',
		'field_type' => 'text',
	));
	/**
	 * Project Facebook
	 */
	x_add_metadata_field('project-facebook', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Facebook',
		'field_type' => 'text',
	));
	/**
	 * Project Twitter
	 */
	x_add_metadata_field('project-twitter', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Twitter',
		'field_type' => 'text',
	));
	/**
	 * Project Instagram
	 */
	x_add_metadata_field('project-instagram', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Instagram',
		'field_type' => 'text',
	));
	/**
	 * Project YouTube
	 */
	x_add_metadata_field('project-youtube', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'YouTube',
		'field_type' => 'text',
	));
	/**
	 * Project other platforms
	 */
	x_add_metadata_field('project-otherplatforms', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Otras plataformas',
		'field_type' => 'textarea',
	));

	/**
	 * Set GV_MICROGRANTS_METADATA_DEFINED to true to avoid
	 * default new questions being applied
	 */
	define('GV_LENGUAS_PROJECTS_METADATA_DEFINED', true);
}
add_action('current_screen', 'gv_lenguas_2022_project_custom_metadata_manager_admin_init');

/**
 * Register postmeta inserts
 * 
 * These will be auto-inserted into post content
 * 
 * Enabling this plugin will cause these to override the new default
 * questions in the microgrants theme because GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED 
 * will be true
 */
function gv_lenguas_2022_project_register_postmeta_inserts()
{

	if (!function_exists('gv_register_postmeta_insert'))
		return;

	/**
	 * ONLY LOAD IF WE ARE ON THE SINGLE PAGE FOR A POST WITH TEH APPRORIATE CATEGORY
	 */
	if (!is_single() or !get_queried_object_id())
		return;

	$post_id = get_queried_object_id();
	$post = get_post($post_id);
	if (!is_object($post) or empty($post->ID) or !has_term('directorio', 'category', $post->ID))
		return;

	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_languages',
		'label' => 'Language',
		'position' => 'top',
	));
	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_tools',
		'label' => 'Tools',
		'position' => 'top',
	));
	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_geo',
		'label' => 'País',
		'position' => 'top',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-website',
		'label' => 'Sitio web',
		'position' => 'bottom',
		'display' => 'url'
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-facebook',
		'label' => 'Facebook',
		'position' => 'bottom',
		'display' => 'url'
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-twitter',
		'label' => 'Twitter',
		'position' => 'bottom',
		'display' => 'url'
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-instagram',
		'label' => 'Instagram',
		'position' => 'bottom',
		'display' => 'url'
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-youtube',
		'label' => 'YouTube',
		'position' => 'bottom',
		'display' => 'url'
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-otherplatforms',
		'label' => 'Otras plataformas',
		'position' => 'bottom',
		'display' => 'url'
	));

	/**
	 * Set GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED to true to avoid
	 * default new questions being applied
	 */
	define('GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED', true);
}
add_action('wp', 'gv_lenguas_2022_project_register_postmeta_inserts');
