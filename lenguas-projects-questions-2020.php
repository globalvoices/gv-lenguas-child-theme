<?php
/*
 * Questions for the 2020 Lenguas microgrants competition
 */ 

// TODO: Add functions that check if the post is in approate category before registering fields and inserts
//function gv_is_editing_post_in_term($term, $taxonomy) {
//	
//}

/**
 * Register custom postmeta fields with the Custom Medatata Manager plugin
 *
 * Convert to some other format if this ever stops working
 */
function gv_microgrants_lenguas_2020_custom_metadata_manager_admin_init() {	
	/**
	 * Exit if the plugin isn't present
	 */
	if(!function_exists( 'x_add_metadata_field' ) OR !function_exists( 'x_add_metadata_group' ) )
		return;

	/**
	 * Make sure we are on a post editing screen
	 */
	$current_screen = get_current_screen();
	if ('post' != $current_screen->base)
		return;
	
	/**
	 * Exit unless this post is in the appropriate category
	 */
	$post = '';
	if (isset($_GET['post']) AND get_post($_GET['post']))
		$post = get_post($_GET['post']);
	if (!is_object($post) OR empty($post->ID) OR !has_term('directorio', 'category', $post->ID))
		return;
	
	/**
	 * Register a group for pages and posts
	 */
	x_add_metadata_group('gv_custom_metadata_posts', array('post'), array(
		'label' => 'GV Custom Metadata',
		'priority' => 'high',
	));

	/**
	 * Project Contact Name
	 */
	x_add_metadata_field( 'project-contact-name', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Tu nombre',
		'field_type' => 'text',
	));
	/**
	 * Project Contact Email
	 */
	x_add_metadata_field( 'project-contact-email', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Tu correo electrónico: (e-mail)',
		'field_type' => 'textarea',
	));
	/**
	 * Project Language
	 */
	x_add_metadata_field( 'project-language-other', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Si tu lengua no figura en las opciones disponibles, escríbalo aquí.',
		'field_type' => 'textarea',
	));
	/**
	 * Project year
	 */
	x_add_metadata_field( 'project-year', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿En qué año comenzó tu proyecto?',
		'field_type' => 'textarea',
	));
	/**
	 * Project city
	 */
	x_add_metadata_field( 'project-city', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Desde qué ciudad se implementa su proyecto?',
		'field_type' => 'textarea',
	));
	/**
	 * Project type
	 */
	x_add_metadata_field( 'project-type', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Cómo se identifica tu proyecto/iniciativa?',
		'field_type' => 'textarea',
	));
	/**
	 * Project challenges
	 */
	x_add_metadata_field( 'project-challenges', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Cuáles son algunos de los desafíos que enfrenta? (lingüísticos, técnicos, socio-culturales, gestión)',
		'field_type' => 'textarea',
	));
	/**
	 * Project Strategies
	 */
	x_add_metadata_field( 'project-strategies', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Qué estrategias está empleando para abordar los desafíos identificados?',
		'field_type' => 'textarea',
	));
	/**
	 * Project Audience
	 */
	x_add_metadata_field( 'project-audience', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Para quién está pensado el proyecto? ¿Tienen un tipo de población especial en mente? ¿Quién es su público objetivo?',
		'field_type' => 'textarea',
	));
	/**
	 * Project Assistance
	 */
	x_add_metadata_field( 'project-assistance', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Cuáles crees que serían las herramientas de capacitación y planeación más importantes que requiere tu proyecto para continuar, para consolidarse y para conseguir sus objetivos?',
		'field_type' => 'textarea',
	));

	/**
	 * Project website
	 */
	x_add_metadata_field( 'project-website', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Sitio web',
		'field_type' => 'text',
	));
	/**
	 * Project Facebook
	 */
	x_add_metadata_field( 'project-facebook', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Facebook',
		'field_type' => 'text',
	));
	/**
	 * Project Twitter
	 */
	x_add_metadata_field( 'proposal-twitter', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Twitter',
		'field_type' => 'text',
	));
	/**
	 * Project Instagram
	 */
	x_add_metadata_field( 'project-instagram', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Instagram',
		'field_type' => 'text',
	));
	/**
	 * Project YouTube
	 */
	x_add_metadata_field( 'project-youtube', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'YouTube',
		'field_type' => 'text',
	));
	/**
	 * Project other platforms
	 */
	x_add_metadata_field( 'project-otherplatforms', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Otras plataformas',
		'field_type' => 'textarea',
	));
	/**
	 * Project team
	 */
	x_add_metadata_field( 'project-team', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '(Opcional) Comparta los nombres de las personas clave (y sus roles) en el, o el nombre de la organización al frente del, proyectos',
		'field_type' => 'textarea',
	));
	/**
	 * Project team contact
	 */
	x_add_metadata_field( 'project-team-contact', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Cuál es la mejor manera para que alguien les contacte si tienen preguntas?',
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

	/**
	 * Set GV_MICROGRANTS_METADATA_DEFINED to true to avoid
	 * default new questions being applied
	 */	
	define('GV_LENGUAS_PROJECTS_METADATA_DEFINED', true);
}
add_action( 'current_screen', 'gv_microgrants_lenguas_2020_custom_metadata_manager_admin_init');

/**
 * Register postmeta inserts
 * 
 * These will be auto-inserted into post content
 * 
 * Enabling this plugin will cause these to override the new default
 * questions in the microgrants theme because GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED 
 * will be true
 */
function gv_microgrants_lenguas_2020_register_postmeta_inserts() {

	if (!function_exists('gv_register_postmeta_insert'))
		return;

	/**
	 * ONLY LOAD IF WE ARE ON THE SINGLE PAGE FOR A POST WITH TEH APPRORIATE CATEGORY
	 */
	if (!is_single() or !get_queried_object_id()) 
		return;

	$post_id = get_queried_object_id();
	$post = get_post($post_id);
	if (!is_object($post) OR empty($post->ID) OR !has_term('directorio', 'category', $post->ID))
		return;

	//Hidden
//	gv_register_postmeta_insert(array(
//		'postmeta_field_name' => 'project-contact-name',
//		'label' => 'Tu nombre',
//		'position' => 'bottom',
//	));
	// Hidden
//	gv_register_postmeta_insert(array(
//		'postmeta_field_name' => 'project-contact-email',
//		'label' => 'Tu correo electrónico: (e-mail)',
//		'position' => 'bottom',
//	));

	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_languages',
		'label' => 'Con qué lengua(s) indígenar(s) u originaria(s) trabaja tu proyecto?',
		'position' => 'bottom',
	));
	// hidden
//	gv_register_postmeta_insert(array(
//		'postmeta_field_name' => 'project-language-other',
//		'label' => '',
//		'position' => 'bottom',
//	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-year',
		'label' => '¿En qué año comenzó tu proyecto?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-city',
		'label' => '¿Desde qué ciudad se implementa su proyecto?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_geo',
		'label' => 'País',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_tools',
		'label' => '¿Qué herramientas emplea principalmente con su proyecto?',
		'position' => 'bottom',
	));		
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-type',
		'label' => '¿Cómo se identifica tu proyecto/iniciativa?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-challenges',
		'label' => '¿Cuáles son algunos de los desafíos que enfrenta? (lingüísticos, técnicos, socio-culturales, gestión)',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-strategies',
		'label' => '¿Qué estrategias está empleando para abordar los desafíos identificados?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-audience',
		'label' => '¿Para quién está pensado el proyecto? ¿Tienen un tipo de población especial en mente? ¿Quién es su público objetivo?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-assistance',
		'label' => '¿Cuáles crees que serían las herramientas de capacitación y planeación más importantes que requiere tu proyecto para continuar, para consolidarse y para conseguir sus objetivos?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-website',
		'label' => 'Sitio web',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-facebook',
		'label' => 'Facebook',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-twitter',
		'label' => 'Twitter',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-instagram',
		'label' => 'Instagram',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-youtube',
		'label' => 'YouTube',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'project-otherplatforms',
		'label' => 'Otras plataformas',
		'position' => 'bottom',
	));
	// hidden
//	gv_register_postmeta_insert(array(
//		'postmeta_field_name' => 'project-team',
//		'label' => '(Opcional) Comparta los nombres de las personas clave (y sus roles) en el, o el nombre de la organización al frente del, proyectos',
//		'position' => 'bottom',
//	));
	// hidden
//	gv_register_postmeta_insert(array(
//		'postmeta_field_name' => 'project-team-contact',
//		'label' => '¿Cuál es la mejor manera para que alguien les contacte si tienen preguntas?',
//		'position' => 'bottom',
//	));

	/**
	 * Set GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED to true to avoid
	 * default new questions being applied
	 */
	define('GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED', true);
}
add_action('wp', 'gv_microgrants_lenguas_2020_register_postmeta_inserts');