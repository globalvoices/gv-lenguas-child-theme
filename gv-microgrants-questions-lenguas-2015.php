<?php
/*
 * Questions for the 2015 Lenguas microgrants competition
 */ 

// TODO: Add functions that check if the post is in approate category before registering fields and inserts
//function gv_is_editing_post_in_term($term, $taxonomy) {
//	
//}

/**
 * Register custom postmeta fields with the Custom Medatata Manager plugin
 *
 * Convert to some other format if this ever stops working
 * Enabling this plugin will cause these to override the new default
 * questions in the microgrants theme because GV_MICROGRANTS_METADATA_DEFINED 
 * will be true 
 */
function gv_microgrants_lenguas_2015_custom_metadata_manager_admin_init() {	
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
	if (!is_object($post) OR empty($post->ID) OR !has_term('lenguas-2015', 'category', $post->ID))
		return;
	
	/**
	 * Register a group for pages and posts
	 */
	x_add_metadata_group('gv_custom_metadata_posts', array('post'), array(
		'label' => 'GV Custom Metadata',
		'priority' => 'high',
	));
	/**
	 * Proposal First Time
	 */
	x_add_metadata_field( 'proposal-new-project', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Esta es un nuevo proyecto o agrega nuevos elementos a un proyecto/trabajo existente?',
		'field_type' => 'text',
	));
	/**
	 * Proposal Contact
	 */
	x_add_metadata_field( 'proposal-contact', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Nombre de Contacto',
		'field_type' => 'text',
	));
	/**
	 * Proposal Community
	 */
	x_add_metadata_field( 'proposal-contact-community', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿A qué comunidad indígena perteneces?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Community
	 */
	x_add_metadata_field( 'proposal-language', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Con qué lengua indígena u originaria propones trabajar?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Community
	 */
	x_add_metadata_field( 'proposal-community', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Descripción de la comunidad específica con la que vas a trabajar.',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Relationship
	 */
	x_add_metadata_field( 'proposal-relationship', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Cuál es tu relación actual con la comunidad con la que deseas trabajar? ¿Por qué consideras que tu equipo es el más adecuada para la ejecución de este proyecto?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Team
	 */
	x_add_metadata_field( 'proposal-team', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Quiénes serán parte del equipo que ayudará a implementar el proyecto?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Participants
	 */
	x_add_metadata_field( 'proposal-participants', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Cuántas personas serán capacitadas durante el proyecto?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Technical
	 */
	x_add_metadata_field( 'proposal-technical', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Como organizador del proyecto, ¿cuáles son las habilidades y las experiencias que tú o tus socios aportan al proyecto? ¿Qué experiencias tiene el líder del proyecto con las herramientas tecnológicas y medios de comunicación digitales en los cuales se enfocará la capacitación a los miembros de la comunidad?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Experience
	 */
	x_add_metadata_field( 'proposal-experience', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Cuál es la experiencia del equipo del proyecto con capacitación y tutoría?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Facilities
	 */
	x_add_metadata_field( 'proposal-facilities', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Describe las instalaciones donde se llevarán a cabo los talleres.',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Challenges
	 */
	x_add_metadata_field( 'proposal-challenges', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'En concreto, ¿cuáles son los desafíos que la comunidad enfrenta para utilizar su lengua indígena en el Internet?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Impact
	 */
	x_add_metadata_field( 'proposal-one-challenge', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Por favor, selecciona uno de estos desafíos que tu proyecto desea abordar y propón actividades concretas o pasos a seguir para empezar a superar este desafío.',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Connections
	 */
	x_add_metadata_field( 'proposal-connections', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Describe las conexiones que tu organización ya haya establecido o que te gustaría que estableciera para implementar una estrategia para abordar el desafío.',
		'field_type' => 'textarea',
	));	
	/**
	 * Proposal Impact
	 */
	x_add_metadata_field( 'proposal-impact', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Por favor, selecciona uno de estos desafíos que tu proyecto desea abordar y propón actividades concretas o pasos a seguir para empezar a superar este desafío.',
		'field_type' => 'textarea',
	));	
	/**
	 * Proposal Policies that must change
	 */
	x_add_metadata_field( 'proposal-policies-change', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Qué políticas públicas deben cambiar para que tu lengua y tu trabajo en activismo digital pueda tener un mayor impacto a mayor escala?',
		'field_type' => 'textarea',
	));	
	/**
	 * Proposal activities
	 */
	x_add_metadata_field( 'proposal-activities', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => '¿Cuáles son algunas de las actividades concretas o pasos iniciales que tu proyecto puede tomar con la finalidad de cambiar estas políticas públicas que harían más fácil que tu lengua se use en internet?',
		'field_type' => 'textarea',
	));	
	/**
	 * Proposal Other Resources
	 */
	x_add_metadata_field( 'proposal-otherresources', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Además de la financiación de microbecas, ¿qué otro tipo de apoyo considera que  Rising Voices pueda brindar a  su proyecto para garantizar su éxito?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Timeline
	 */
	x_add_metadata_field( 'proposal-timeline', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Si tu proyecto es seleccionado por Rising Voices, ¿cuál sería el cronograma general de actividades?',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Budget
	 */
	x_add_metadata_field( 'proposal-budget', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Proporciona un presupuesto detallado de hasta US$3,500.00 (tres mil quinientos dólares americanos) para gastos de funcionamiento.',
		'field_type' => 'textarea',
	));
	/**
	 * Proposal Total money requested
	 */
	x_add_metadata_field( 'proposal-total', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Cantidad total solicitada (en dólares americanos)',
		'field_type' => 'text',
	));
	/**
	 * Proposal City
	 */
	x_add_metadata_field( 'proposal-city', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Ciudad',
		'field_type' => 'text',
	));
	/**
	 * Proposal Mailing address
	 */
	x_add_metadata_field( 'proposal-address', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Dirección Postal',
		'field_type' => 'text',
	));
	/**
	 * Proposal Telephone number
	 */
	x_add_metadata_field( 'proposal-number', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Número de teléfono',
		'field_type' => 'text',
	));
	/**
	 * Proposal Email
	 */
	x_add_metadata_field( 'proposal-email', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Su correo electrónico (e-mail)',
		'field_type' => 'text',
	));
	/**
	 * Proposal Organization
	 */
	x_add_metadata_field( 'proposal-organization', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Organización',
		'field_type' => 'text',
	));
	/**
	 * Proposal URL
	 */
	x_add_metadata_field( 'proposal-url', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Sitio web de la organización (opcional)',
		'field_type' => 'text',
	));
	/**
	 * Proposal Twitter
	 */
	x_add_metadata_field( 'proposal-twitter', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Cuenta en Twitter',
		'field_type' => 'text',
	));
	/**
	 * Proposal Facebook
	 */
	x_add_metadata_field( 'proposal-facebook', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Perfil en Facebook',
		'field_type' => 'text',
	));
	/**
	 * Proposal first time
	 */
	x_add_metadata_field( 'proposal-firsttime', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Esta es la primera vez que postulas para un microfondo de Rising Voices?',
		'field_type' => 'text',
	));
	/**
	 * Proposal Private
	 */
	x_add_metadata_field( 'proposal-private', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'No publicar esta propuesta',
		'field_type' => 'checkbox',
	));
	/**
	 * Proposal Privacy Reason
	 */
	x_add_metadata_field( 'proposal-privacy-reason', array('post'), array(
		'group' => 'gv_custom_metadata_posts',
		'label' => 'Por favor, cuéntanos en un párrafo por qué no quieres que se publique esta propuesta',
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
	define('GV_MICROGRANTS_METADATA_DEFINED', true);
}
add_action( 'current_screen', 'gv_microgrants_lenguas_2015_custom_metadata_manager_admin_init');

/**
 * Register postmeta inserts
 * 
 * These will be auto-inserted into post content
 * 
 * Enabling this plugin will cause these to override the new default
 * questions in the microgrants theme because GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED 
 * will be true
 */
function gv_microgrants_lenguas_2015_register_postmeta_inserts() {

	if (!function_exists('gv_register_postmeta_insert'))
		return;

	/**
	 * ONLY LOAD IF WE ARE ON THE SINGLE PAGE FOR A POST WITH TEH APPRORIATE CATEGORY
	 */
	if (!is_single() or !get_queried_object_id()) 
		return;

	$post_id = get_queried_object_id();
	$post = get_post($post_id);
	if (!is_object($post) OR empty($post->ID) OR !has_term('lenguas-2015', 'category', $post->ID))
		return;

	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-community',
		'label' => 'Descripción de la comunidad específica con la que vas a trabajar.',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-language',
		'label' => 'Con qué lengua indígena u originaria propones trabajar?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-contact',
		'label' => 'Nombre de Contacto',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-contact-community',
		'label' => '¿A qué comunidad indígena perteneces?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-relationship',
		'label' => '¿Cuál es tu relación actual con la comunidad con la que deseas trabajar? ¿Por qué consideras que tu equipo es el más adecuada para la ejecución de este proyecto?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-team',
		'label' => '¿Quiénes serán parte del equipo que ayudará a implementar el proyecto?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-participants',
		'label' => '¿Cuántas personas serán capacitadas durante el proyecto?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_tools',
		'label' => 'Elige la principal herramienta o medio de comunicación digital que tu proyecto va a usar (se recomienda escoger solamente una herramienta principal que será utilizada por los participantes para crear contenido)',
		'position' => 'bottom',
	));		
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-technical',
		'label' => 'Como organizador del proyecto, ¿cuáles son las habilidades y las experiencias que tú o tus socios aportan al proyecto? ¿Qué experiencias tiene el líder del proyecto con las herramientas tecnológicas y medios de comunicación digitales en los cuales se enfocará la capacitación a los miembros de la comunidad?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-experience',
		'label' => '¿Cuál es la experiencia del equipo del proyecto con capacitación y tutoría?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-facilities',
		'label' => 'Describe las instalaciones donde se llevarán a cabo los talleres.',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-challenges',
		'label' => 'En concreto, ¿cuáles son los desafíos que la comunidad enfrenta para utilizar su lengua indígena en el Internet?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-one-challenge',
		'label' => 'Por favor, selecciona uno de estos desafíos que tu proyecto desea abordar y propón actividades concretas o pasos a seguir para empezar a superar este desafío.',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-connections',
		'label' => 'Describe las conexiones que tu organización ya haya establecido o que te gustaría que estableciera para implementar una estrategia para abordar el desafío.',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-impact',
		'label' => 'Por favor, selecciona uno de estos desafíos que tu proyecto desea abordar y propón actividades concretas o pasos a seguir para empezar a superar este desafío.',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-policies-change',
		'label' => '¿Qué políticas públicas deben cambiar para que tu lengua y tu trabajo en activismo digital pueda tener un mayor impacto a mayor escala?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-activities',
		'label' => '¿Cuáles son algunas de las actividades concretas o pasos iniciales que tu proyecto puede tomar con la finalidad de cambiar estas políticas públicas que harían más fácil que tu lengua se use en internet?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-otherresources',
		'label' => 'Además de la financiación de microbecas, ¿qué otro tipo de apoyo considera que  Rising Voices pueda brindar a  su proyecto para garantizar su éxito?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-timeline',
		'label' => 'Si tu proyecto es seleccionado por Rising Voices, ¿cuál sería el cronograma general de actividades?',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-budget',
		'label' => 'Proporciona un presupuesto detallado de hasta US$3,500.00 (tres mil quinientos dólares americanos) para gastos de funcionamiento.',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'taxonomy' => 'gv_geo',
		'label' => 'País',
		'position' => 'bottom',
	));			
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-city',
		'label' => 'Ciudad',
		'position' => 'bottom',
	));		
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-organization',
		'label' => 'Organización',
		'position' => 'bottom',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-url',
		'label' => 'Sitio web de la organización (opcional)',
		'position' => 'bottom',
		'display' => 'url',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-twitter',
		'label' => 'Cuenta en Twitter',
		'position' => 'bottom',
		'display' => 'url',
	));
	gv_register_postmeta_insert(array(
		'postmeta_field_name' => 'proposal-facebook',
		'label' => 'Perfil en Facebook',
		'position' => 'bottom',
		'display' => 'url',
	));

	/**
	 * Set GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED to true to avoid
	 * default new questions being applied
	 */
	define('GV_MICROGRANTS_POSTMETA_INSERTS_DEFINED', true);
}
add_action('wp', 'gv_microgrants_lenguas_2015_register_postmeta_inserts');