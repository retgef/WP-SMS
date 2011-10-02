<?php
/*
Plugin Name: EasySMS
Plugin URI: http://www.misternifty.com/easysms/
Description: SMS message your readers and broadcast a new post to user cell phones automatically.  User group organization.  Add custom carriers.
Version: 2.0.7.2
Author: Brian Fegter
Author URI: http://www.misternifty.com
*/

/*  Copyright 2008  Brian Fegter  (email : brian atum fegter dotty commy)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Create Database User Table and Group Tables

define ('EASYSMS_FULL',ABSPATH."wp-content/plugins/easysms/");
define ('EASYSMS',get_bloginfo('wpurl')."/wp-content/plugins/easysms/");


function ro($i)
{
       require_once(EASYSMS_FULL.$i.".php"); 
}

// Require Includes & Create Database User Table and Group Tables

ro('db');
ro('options');
ro('post_publish');
ro('css');


// WP Hooks

add_action('publish_post', 'easysmspost');
add_action('admin_menu', 'bf_add_pages');
add_action('admin_head', 'bf_easysms_style');
add_action('wp_head', 'bf_easysms_style');
add_action('easysms_form', 'bf_easysms_subscribe');
add_filter('the_content', 'bf_embed_form');
add_action('widgets_init', 'EasySMSWidgetInit');

add_filter('query_vars', 'var_register');

function var_register($public_query_vars) {
	$public_query_vars[] = 'smsregister';
        $public_query_vars[] = 'smsmanage';
        $public_query_vars[] = 'smsconfirm';
        $public_query_vars[] = 'smsresend';
        $public_query_vars[] = 'smschange';
        $public_query_vars[] = 'smshome';
        $public_query_vars[] = 'smsretrieve';
        $public_query_vars[] = 'smsunsubscribe';
        return $public_query_vars;
}

add_action('template_redirect', 'smsregistration');
function smsregistration() {
	$register=get_query_var('smsregister');
        $manage=get_query_var('smsmanage');
        $confirm=get_query_var('smsconfirm');
        $home=get_query_var('smshome');
        $resend=get_query_var('smsresend');
        $change=get_query_var('smschange');
        $retrieve=get_query_var('smsretrieve');
        $unsubscribe=get_query_var('smsunsubscribe');
        
	if ($register) {
                ro('form_functions');
		ro('register');
		exit;
	}
        if ($manage) {
                ro('form_functions');
		ro('manage');
		exit;
	}
        if ($retrieve) {
                ro('form_functions');
		ro('manage');
		exit;
	}
        if ($home) {
                ro('form_functions');
		ro('manage');
		exit;
	}
        if ($unsubscribe) {
                ro('form_functions');
		ro('manage');
		exit;
	}
        if ($confirm) {
                ro('form_functions');
		ro('confirm');
		exit;
	}
        if ($resend) {
                ro('form_functions');
		ro('confirm');
		exit;
	}
        if ($change) {
                ro('form_functions');
		ro('confirm');
		exit;
	}
}



function bf_add_pages() 
{	 
	if (current_user_can('level_10')) 
	{
	      add_menu_page('EasySMS', 'EasySMS', 8, __FILE__, 'bf_easysms_dash', EASYSMS."images/menu.png"); 
	      add_submenu_page(__FILE__, 'Send SMS', 'Send SMS', 8, 'easySMS_send', 'bf_easysms_send');
              add_submenu_page(__FILE__, 'Settings', 'Settings', 8, 'easySMS_settings', 'easysms_options');
	      add_submenu_page(__FILE__, 'Subscribers', 'Subscribers', 8, 'easySMS_subscribers', 'bf_easysms_subscribers');
	      add_submenu_page(__FILE__, 'Groups', 'Groups', 8, 'easySMS_groups', 'bf_easysms_groups');
	      add_submenu_page(__FILE__, 'Carriers', 'Carriers', 8, 'easySMS_carriers', 'bf_easysms_carriers');
	      add_submenu_page(__FILE__, 'Style', 'Style', 8, 'easySMS_editCSS', 'bf_easysms_editcss');
	      add_submenu_page('post-new.php', 'Send SMS', 'Send SMS', 0, 'easysms/sendsms', 'bf_easysms_send');
	}
}

function bf_easysms_editcss()
{
       easysms_editcss();
}

function bf_easysms_style()
{
       echo "<link rel=stylesheet href='".EASYSMS."style.css' type='text/css' media='all'>";
       ro('register');
}

function bf_easysms_dash()
{
       // Dashboard
       ro('dash');
	//require_once(get_bloginfo('wpurl')."/wp-content/plugins/easysms/dash.php");
}

function bf_easysms_carriers()
{
        // Carrier Menu
	ro('carrier_menu');
	//require_once(get_bloginfo('wpurl')."/wp-content/plugins/easysms/carrier_menu.php");
}

function bf_easysms_subscribers()
{
        // Subscriber Menu
	ro('subscriber_menu');
	//require_once(get_bloginfo('wpurl')."/wp-content/plugins/easysms/subscriber_menu.php");
}


function bf_easysms_groups()
{
        // Groups Menu
	ro('group_menu');
	//require_once(get_bloginfo('wpurl')."/wp-content/plugins/easysms/group_menu.php");
}

function bf_easysms_subscribe()
{ 
        // Cell Form
	ro('form_functions'); ?>
       <div class="<? $options = get_option('bf_easysms_widget_options'); echo $options['class']; ?>">
       <div id='easysmsDiv'>
       <? easysms_subscribe_form('','','','') ?>
       </div>
       </div>
<? }


function bf_easysms_send() 
{ 
       //Admin Messaging Center
       ro('sms_message_menu');
	//require_once(get_bloginfo('wpurl')."/wp-content/plugins/easysms/sms_message_menu.php");

}

function bf_embed_form($content)
{
       // Embed Form
       if(strpos($content, "[easysms]"))
       {
              $part = explode("[easysms]", $content);
              if ($part[0] != '')
              {
                     echo $part[0];
              }
              
              bf_easysms_subscribe();
              
              if ($part[1] != '')
              {
                     echo $part[1];
              }
	      
       }
       else
       {
	      return $content;
       }
       
}

class EasySMSWidget extends WP_Widget
{
       function EasySMSWidget(){
	      $widget_ops = array('classname' => 'easysms_widget', 'description' => __( "EasySMS subscribe to updates form.") );
	      $control_ops = array('width' => 300, 'height' => 400);
	      $widget_ops = array('title' => 'Subscribe to SMS', 'class' => 'easysms_widget');
	      $this->WP_Widget('easysms', __('EasySMS Form'), $widget_ops, $control_ops);
       }
       function widget($args, $instance){
	      extract($args);
	      $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
	      echo $before_widget.$before_title.$title.$after_title;
	      bf_easysms_subscribe();
	      echo $after_widget;
       }
       
       function update($new_instance, $old_instance){
	      $instance = $old_instance;
	      $instance['title'] = strip_tags(stripslashes($new_instance['title']));
	      $instance['terms'] = strip_tags(stripslashes($new_instance['terms']));
	      $instance['terms_status'] = strip_tags(stripslashes($new_instance['terms_status']));
	      return $instance;
       }
       
       function form($instance){
	      $instance = wp_parse_args( (array) $instance, array('title'=>'Subscribe to SMS') );
	      $title = htmlspecialchars($instance['title']);
	      echo '<p style="text-align:right;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 250px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';
       }
}

function EasySMSWidgetInit() {
       register_widget('EasySMSWidget');
}

?>