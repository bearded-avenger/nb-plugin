<?php
/*
	Author: Nick Haskins
	Author URI: http://nickhaskins.com
	Plugin Name: Nicks Base Plugin
	Plugin URI: http://nickhaskins.com
	Version: 1.1
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

	const version = '1.1';

	function __construct() {

		$this->id   = 'nb_plugin';
		$this->name = 'Nicks Base Plugin';
        $this->dir  = plugin_dir_path( __FILE__ );
        $this->url  = plugins_url( '', __FILE__ );
        $this->icon = plugins_url( '/icon.png', __FILE__ );

		add_action( 'template_redirect',  array(&$this,'insert_less' ));
		add_action( 'init', array( &$this, 'init' ) );

	}

    // Add a less file
	function insert_less() {

        $file = sprintf( '%sstyle.less', plugin_dir_path( __FILE__ ) );
        if(function_exists('pagelines_insert_core_less')) {
            pagelines_insert_core_less( $file );
        }

    }

	function init(){

		add_action( 'wp_enqueue_scripts', array(&$this,'scripts' ));
		add_filter('pl_settings_array', array(&$this, 'options'));
	}

    // Enqueue stuffs
	function scripts(){

		wp_register_script('nbplugin-script',$this->url.'/script.js', array('jquery'), self::version, true );

		//wp_enqueue_script('nbplugin-script');
	}

    // Init options
    // Choose from Font Awesome icons for Icon
    // Position denotes how far from top in Global Options Tab
    function options( $settings ){

        $settings[ $this->id ] = array(
                'name'  => $this->name,
                'icon'  => 'icon-thumbs-up',
                'pos'   => 5,
                'opts'  => $this->global_opts()
        );

        return $settings;
    }

    // Draw Options Panel
    // Call settings as $var = pl_setting($this->id.'_optionB');
    function global_opts(){

        $global_opts = array(
            array(
                'key' => $this->id.'_optionA',
                'type' => 'multi',
                'title' => __('Sample Option', 'nb-plugin'),
                'opts' => array(
                    array(
                        'key' => $this->id.'_optionB',
                        'type' => 'text',
                        'label' => __('Some Option', 'nb-plugin'),
                    ),
                    array(
                        'key' => $this->id.'_optionC',
                        'type' => 'text',
                        'label' => __('Some Option', 'nb-plugin'),
                    ),
                ),
            ),

        );

        return array_merge($global_opts);
    }

}


