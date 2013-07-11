<?php
/*
	Author: Nick Haskins
	Author URI: http://nickhaskins.com
	Plugin Name: Nicks Base Plugin
	Plugin URI: http://nickhaskins.com
	Version: 1.2
	Description: Build interactive presentations, and responsive single-page micro-sites.
	Class Name: baShowOff
	Demo: http://showoff.nichola.us
	Pagelines:true
*/

add_action('pagelines_setup', 'nbplugin_init' );
function nbplugin_init() {

	if( !function_exists('ploption') )
		return;

	$landing = new nbBasePlugin;
}
class nbBasePlugin {

	var $ptID = 'showoff';
	const version = '1.0';

	function __construct() {

		$this->id   = 'nb-plugin';
		$this->name = 'Nicks Base Plugin';
        $this->dir  = plugin_dir_path( __FILE__ );
        $this->url  = plugins_url( '', __FILE__ );
        $this->icon = plugins_url( '/icon.png', __FILE__ );

		add_action( 'template_redirect',  array(&$this,'showoff_less' ));
		add_action( 'init', array( &$this, 'init' ) );

	}

	function showoff_less() {

        $file = sprintf( '%sstyle.less', plugin_dir_path( __FILE__ ) );
        if(function_exists('pagelines_insert_core_less()')) {
            pagelines_insert_core_less( $file );
        }

    }

	function init(){

		add_action( 'wp_enqueue_scripts', array(&$this,'scripts' ));
		add_filter('pl_settings_array', array(&$this, 'options'));
	}


	function scripts(){

		wp_register_script('nbplugin-script',$this->url.'/script.js', array('jquery'), self::version, true );

		wp_enqueue_script('nbplugin-script');
	}

	function draw_layout(){

		// Get the Nav
		$this->nav();

		// Get the panels
		$this->panels();

	}


    function options( $settings ){

        $settings[ $this->id ] = array(
                'name'  => 'Nicks Base Plugin',
                'icon'  => 'icon-list-alt',
                'pos'   => 5,
                'opts'  => $this->global_opts()
        );

        return $settings;
    }

    function global_opts(){

        $global_opts = array(
            array(
                'key' => 'pocket_slug_setup',
                'type' => 'multi',
                'title' => __('Naming Setup', 'pockets'),
                'shortexp' => __('Setup slugs for your Pocket', 'pockets'),
                'opts' => array(
                    array(
                        'key' => 'pocket_slug_singular',
                        'type' => 'text',
                        'label' => __('Singular Slug (ex: dog)', 'pockets'),
                    ),
                    array(
                        'key' => 'pocket_slug_plural',
                        'type' => 'text',
                        'label' => __('Plural Slug (ex: dogs)', 'pockets'),
                    ),
                ),
                'exp' => __('Provide your own slugs. By default, the Singular Slug is <code>pocket</code> and the Plural Slug is <code>pockets</code>. You can change them to whatever you please and the section will automaticlaly rewrite the URL\'s to accomodate.  Enter in all lower case letters.', 'pockets'),
            ),

        );

        return array_merge($global_opts);
    }

}


