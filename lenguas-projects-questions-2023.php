<?php
/**
 * Field and postmeta insert registrations for the Lenguas Project Directory category
 * 
 * Copied from lenguas-projects-questions-2020.php which became a damn mess. This is no longer about a microgrants
 * competition, this goes with a form where people submit their projects to be listed. 
 * 
 * It applies to any post with the right category ('directorio') and adds automatic handling of postmeta
 * fields that get created by the matching Gravity form.
 */ 

/**
 * Register custom postmeta fields with the Custom Medatata Manager plugin
 * 
 * If a post has the `directorio` term then it will automatically have these fields registered
 * in the "Post Settings (Global Voices)" metabox so that they can be edited. 
 * 
 * See the *_register_postmeta_inserts()  function below for registrations that control
 * the frontend display of these posts.
 *
 * Convert to some other format if this ever stops working
 */
function gv_microgrants_lenguas_2023_custom_metadata_manager_admin_init() {	
	/**
	 * Exit if the plugin isn't present
	 */
	if(!function_exists( 'x_add_metadata_field' ) OR !function_exists( 'x_add_metadata_group' ) ) {
		return;
	}

	// TODO Extract as gv_is_editing_post_in_term(string $term_name, string $taxonomy_name)

	/**
	 * Make sure we are on a post editing screen
	 */
	$current_screen = get_current_screen();
	if ('post' != $current_screen->base) {
		return;
	}
	
	/**
	 * Get the object of the post being edited
	 */
	$post = '';
	// Editor stores it in _GET
	if (isset($_GET['post']) AND get_post($_GET['post'])) {
		$post = get_post($_GET['post']);
	// During post saving it's in _POST
	} elseif (isset($_POST['post_ID']) AND get_post($_POST['post_ID'])) {
		$post = get_post($_POST['post_ID']);
	}
	
	/**
	 * Exit unless this post is in the appropriate category
	 */
	if (!is_object($post) OR empty($post->ID) OR !has_term('directorio', 'category', $post->ID)) {

		return;
	}
	
	// TODO End extract 

	/**
	 * Register a group for pages and posts
	 */
	x_add_metadata_group('lenguas_project_questions_2023', array('post'), array(
		'label' => 'Lenguas Project Questions 2023',
		'priority' => 'high',
	));

	/**
	 * Project Contact Name - Backend only
	 */
	x_add_metadata_field( 'project-contact-name', array('post'), array(
		'group' => 'lenguas_project_questions_2023',
		'label' => 'Nombre del contacto',
		'field_type' => 'text',
	));
	/**
	 * Project Contact Email - Backend only
	 */
	x_add_metadata_field( 'project-contact-email', array('post'), array(
		'group' => 'lenguas_project_questions_2023',
		'label' => 'Tu correo electrónico (e-mail)',
		'field_type' => 'textarea',
	));
	/**
	 * Project Language that wasn't in list - Backend only
	 */
	x_add_metadata_field( 'project-language-other', array('post'), array(
		'group' => 'lenguas_project_questions_2023',
		'label' => 'Si tu lengua no figura en las opciones disponibles, escríbalo aquí.',
		'field_type' => 'textarea',
	));
	/**
	 * Project year - Backend only
	 */
	x_add_metadata_field( 'project-year', array('post'), array(
		'group' => 'lenguas_project_questions_2023',
		'label' => '¿En qué año comenzó tu proyecto?',
		'field_type' => 'textarea',
	));
	/**
	 * Project city - Backend only
	 */
	x_add_metadata_field( 'project-city', array('post'), array(
		'group' => 'lenguas_project_questions_2023',
		'label' => '¿Desde qué ciudad se implementa su proyecto?',
		'field_type' => 'textarea',
	));
	/**
	 * Project country that wasn't in list - Backend only
	 */
	x_add_metadata_field( 'project-country-other', array('post'), array(
		'group' => 'lenguas_project_questions_2023',
		'label' => 'Si tu país no figura en las opciones, anótalo aquí.',
		'field_type' => 'textarea',
	));
	/**
	 * Project online presence - Backend only
	 */
	x_add_metadata_field( 'project-online-presence', array('post'), array(
		'group' => 'lenguas_project_questions_2023',
		'label' => 'Introduce la dirección de tus cuentas de redes sociales y/o sitio web (eg Instagram, TikTok, Twitter, Facebook, YouTube, etc. http://www.instagram.com/cuenta_instagram).',
		'field_type' => 'textarea',
	));
	/**
	 * Project public contact - Backend only
	 */
	x_add_metadata_field( 'project-public-contact', array('post'), array(
		'group' => 'lenguas_project_questions_2023',
		'label' => 'Si alguien de otro proyecto tiene preguntas, ¿qué opción prefieren para ser contactados?',
		'field_type' => 'textarea',
	));

	// ! Fields below apply to the old 2020 and older forms, but are kept so the data can be accessed

	x_add_metadata_group('lenguas_project_questions_2020', array('post'), array(
		'label' => 'OLD/LEGACY Lenguas Project Questions 2020',
		'priority' => 'high',
	));

	/**
	 * Project type
	 */
	x_add_metadata_field( 'project-type', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => '¿Cómo se identifica tu proyecto/iniciativa?',
		'field_type' => 'textarea',
	));
	/**
	 * Project challenges
	 */
	x_add_metadata_field( 'project-challenges', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => '¿Cuáles son algunos de los desafíos que enfrenta? (lingüísticos, técnicos, socio-culturales, gestión)',
		'field_type' => 'textarea',
	));
	/**
	 * Project Strategies
	 */
	x_add_metadata_field( 'project-strategies', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => '¿Qué estrategias está empleando para abordar los desafíos identificados?',
		'field_type' => 'textarea',
	));
	/**
	 * Project Audience
	 */
	x_add_metadata_field( 'project-audience', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => '¿Para quién está pensado el proyecto? ¿Tienen un tipo de población especial en mente? ¿Quién es su público objetivo?',
		'field_type' => 'textarea',
	));
	/**
	 * Project Assistance
	 */
	x_add_metadata_field( 'project-assistance', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => '¿Cuáles crees que serían las herramientas de capacitación y planeación más importantes que requiere tu proyecto para continuar, para consolidarse y para conseguir sus objetivos?',
		'field_type' => 'textarea',
	));

	/**
	 * Project website
	 */
	x_add_metadata_field( 'project-website', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => 'Sitio web',
		'field_type' => 'text',
	));
	/**
	 * Project Facebook
	 */
	x_add_metadata_field( 'project-facebook', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => 'Facebook',
		'field_type' => 'text',
	));
	/**
	 * Project Twitter
	 */
	x_add_metadata_field( 'proposal-twitter', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => 'Twitter',
		'field_type' => 'text',
	));
	/**
	 * Project Instagram
	 */
	x_add_metadata_field( 'project-instagram', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => 'Instagram',
		'field_type' => 'text',
	));
	/**
	 * Project YouTube
	 */
	x_add_metadata_field( 'project-youtube', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => 'YouTube',
		'field_type' => 'text',
	));
	/**
	 * Project other platforms
	 */
	x_add_metadata_field( 'project-otherplatforms', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => 'Otras plataformas',
		'field_type' => 'textarea',
	));
	/**
	 * Project team
	 */
	x_add_metadata_field( 'project-team', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => '(Opcional) Comparta los nombres de las personas clave (y sus roles) en el, o el nombre de la organización al frente del, proyectos',
		'field_type' => 'textarea',
	));
	/**
	 * Project team contact
	 */
	x_add_metadata_field( 'project-team-contact', array('post'), array(
		'group' => 'lenguas_project_questions_2020',
		'label' => '¿Cuál es la mejor manera para que alguien les contacte si tienen preguntas?',
		'field_type' => 'textarea',
	));

	/**
	 * Set GV_MICROGRANTS_METADATA_DEFINED to true to avoid
	 * default new questions being applied
	 */	
	define('GV_LENGUAS_PROJECTS_METADATA_DEFINED', true);
}
add_action( 'current_screen', 'gv_microgrants_lenguas_2023_custom_metadata_manager_admin_init');

/**
 * Register postmeta inserts for display on the frontend if they have the `directorio` category
 * 
 * These will be auto-inserted into post content
 * 
 * Enabling this plugin will cause these to override the new default
 * questions in the microgrants theme because GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED 
 * will be true
 */
function gv_microgrants_lenguas_2023_register_postmeta_inserts() {

	if (!function_exists('gv_register_postmeta_insert')) {
		return;
	}

	/**
	 * ONLY LOAD IF WE ARE ON THE SINGLE PAGE FOR A POST WITH THE APPROPRIATE CATEGORY
	 */
	if (!is_single() or !get_queried_object_id()) {
		return;
	}

	$post_id = get_queried_object_id();
	$post = get_post($post_id);
	if (!is_object($post) OR empty($post->ID) OR !has_term('directorio', 'category', $post->ID)) {
		return;
	}

	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_languages',
		'label' => 'Lenguas',
		'position' => 'bottom',
	));

	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_geo',
		'label' => 'País',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_tools',
		'label' => 'Herramientas digitales',
		'position' => 'bottom',
	));

	/**
	 * Set GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED to true to avoid
	 * default new questions being applied
	 */
	define('GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED', true);
}
add_action('wp', 'gv_microgrants_lenguas_2023_register_postmeta_inserts');