<?php
/*
	Author: Nick Haskins
	Author URI: http://nickhaskins.com
	Plugin Name: Nicks Base Plugin
	Plugin URI: http://nickhaskins.com
	Version: 1.0
	Description: A base plugin for PageLines DMS.
	Demo:
	Pagelines:true
*/

// Check to make sure we're in DMS
add_action('pagelines_setup', 'nbplugin_init' );
function nbplugin_init() {

	if( !function_exists('pl_has_editor') )
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

    // Add a less file
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

		//wp_enqueue_script('nbplugin-script');
	}


    function options( $settings ){

        $settings[ $this->id ] = array(
                'name'  => 'Nicks Base Plugin',
                'icon'  => 'icon-rocket',
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
                'title' => __('Sample Option', 'nb-plugin'),
                'opts' => array(
                    array(
                        'key' => 'pocket_slug_singular',
                        'type' => 'text',
                        'label' => __('Some Option', 'nb-plugin'),
                    ),
                    array(
                        'key' => 'pocket_slug_plural',
                        'type' => 'text',
                        'label' => __('Some Option', 'nb-plugin'),
                    ),
                ),
            ),

        );

        return array_merge($global_opts);
    }

}


