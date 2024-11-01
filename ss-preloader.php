<?php

    /*

    Plugin Name: SS Pre-Loader

    Description: SS Pre-Loader plugin is for your wordpress site. You can add SS Pre-Loader in your site in just few clicks. Just install the SS Pre-Loader in your wordpress site and let people enjoy your animations while actual data loads in the background. This plugin is light weight and do not need any jQuery so there is no chance of any confliction.

    Plugin URI: https://wordpress.org/plugins/ss-preloader

    Author: Sohail Sajid

    Author URI: http://#

    Version: 1.0

    License: GPL2

    

        Copyright (C) 2016  sohailsajid32@gmail.com

    

        This program is free software; you can redistribute it and/or modify

        it under the terms of the GNU General Public License, version 2, as

        published by the Free Software Foundation.

    */

defined( 'ABSPATH' ) or die( 'Restricted Access!' );



add_action('admin_menu', 'ss_preloader');

function ss_preloader() {

	add_menu_page('SS Preloader', 'SS Preloader', 'administrator', 'ss-preloader', 'ss_preloader_main', 'dashicons-admin-generic');

}

add_action( 'admin_init', 'ss_preloader_settings' );
function load_wp_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );


function ss_preloader_settings() {

	register_setting( 'ss-preloader-settings-group', 'ss_preloader_image' );

	register_setting( 'ss-preloader-settings-group', 'ss_preloader_color' );

	register_setting( 'ss-preloader-settings-group', 'ss_preloader_opacity' );

}

function ss_preloader_main() {

  ?>

<form method="post" action="options.php">

    <?php settings_fields( 'ss-preloader-settings-group' ); ?>

    <?php do_settings_sections( 'ss-preloader-settings-group' ); ?>

    <table class="form-table" align="center">
    <tr>
    <th colspan="2">SS Pre-Loader plugin is for your wordpress site. You can add SS Pre-Loader in your site in just few clicks. Just install the SS Pre-Loader in your wordpress site and let people enjoy your animations while actual data loads in the background. This plugin is light weight and do not need any jQuery so there is no chance of any confliction.</th>
    </tr>

        <tr valign="top">

        <th scope="row">Image</th>

        <td>
            <div style="margin-top:15px;">
            <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image" style="float:left;">
            <input type="text" name="ss_preloader_image" id="ss_preloader_image" class="regular-text" value="<?php echo esc_attr( get_option('ss_preloader_image') ); ?>" style="visibility:hidden;">
			<script type="text/javascript">
            jQuery(document).ready(function($){
            $('#upload-btn').click(function(e) {
            e.preventDefault();
            var image = wp.media({ 
                title: 'Upload Image',
                // mutiple: true if you want to upload multiple files at once
                multiple: false
            }).open()
            .on('select', function(e){
                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get('selection').first();
                // We convert uploaded_image to a JSON object to make accessing it easier
                // Output to the console uploaded_image
                console.log(uploaded_image);
                var image_url = uploaded_image.toJSON().url;
                // Let's assign the url value to the input field
                $('#ss_preloader_image').val(image_url);
				$('#img-preview').attr("src",image_url);
            });
            });
            });
            </script>
            <style>
            	.image_preloader{ width:50px; height:50px; float:left; margin-left:50px; padding:6px 15px;  box-shadow: 0 1px 0 #ccc;; background:#f7f7f7;  border:1px solid #ccc; }
				.image_preloader img{ max-width:100%; width:100%;
				
				
				}
				.form-table td{ padding-top:0px;
				padding-bottom:0px}
            </style>
            <?php if( get_option('ss_preloader_image') ){?>
            	<div class="image_preloader"><img id="img-preview" src="<?php echo esc_attr( get_option('ss_preloader_image') ); ?>" 	/></div>
                <?php }?>
            </div>
        </td>

        </tr>

        <tr valign="top">

        <th scope="row">Background Color</th>

        <td><input type="text" name="ss_preloader_color" value="<?php echo esc_attr( get_option('ss_preloader_color') ); ?>" placeholder="#FFFFFF" class="wp-color-picker-field" data-default-color="#ffffff" /></td>

        </tr>

        <tr valign="top">

        <th scope="row">Background Opacity</th>

        <td><input type="text" name="ss_preloader_opacity" value="<?php echo esc_attr( get_option('ss_preloader_opacity') ); ?>" placeholder="0 - 1" /></td>

        </tr>

    </table>

    

    <?php submit_button(); ?>



</form>  

  <?php

  

}

	/* Adding javascript file in the head section of the page.*/

	wp_enqueue_script( "JavaScript", plugins_url( '/js/ss-preloader-script.js', __FILE__ ), array(), 1.0, false);

	/* Adding style in the head section of the page as per options saved in the backend.*/

	add_action( 'wp_head', 'ss_preloader_asset' );

	function ss_preloader_asset() {

		if( get_option('ss_preloader_image') ){

			$ss_preloader_image = get_option('ss_preloader_image');

		}else{

			$ss_preloader_image = plugins_url( '/img/ss-preloader.gif', __FILE__ );

		}

		if( get_option('ss_preloader_color') ){

			$ss_preloader_color = get_option('ss_preloader_color');

		}else{

			$ss_preloader_image = "#ffffff";

		}

		if( get_option('ss_preloader_opacity') ){

			$ss_preloader_opacity = get_option('ss_preloader_opacity');

		}else{

			$ss_preloader_opacity = 1;

		}

	?>  

	<style>#load{width:100%;height:100%;position:fixed;z-index:9999999;background:url(<?=$ss_preloader_image;?>) no-repeat center center; background-color:<?=$ss_preloader_color;?>; opacity:<?=$ss_preloader_opacity;?>;}</style>

	<?php }

	/* Adding html, it will add div right after body tag*/

	function ss_preloader_html() {

		echo '<div id="load"></div>';

	}

	add_action( 'wp_head', 'ss_preloader_html' );





add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );

function wp_enqueue_color_picker( ) {

    wp_enqueue_style( 'wp-color-picker' );

    wp_enqueue_script( 'wp-color-picker-script', plugins_url('js/ss-preloader-color-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

}

?>