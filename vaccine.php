<?php
/*
Plugin Name: Vaccine
Plugin URI: http://studio.bloafer.com/wordpress-plugins/vaccine/
Description: It's like anti-virus for your WordPress with anti-spam stuff built-in.
Version: 0.1 Beta
Author: Kerry James
Author URI: http://studio.bloafer.com/
*/

global $vaccine;
$vaccine = new vaccine();

class vaccine {
	var $pluginName = "Vaccine";
	var $protectMessage = "Protected by Vaccine for WordPress";
	var $version = "0.1 Beta";
	var $spamCount = false;
	var $newsXML = false;
	var $nonceField = "";
	var $scanFiles = array();
	function vaccine(){
		$this->nonceField = md5($this->pluginName . $this->version);
		
		$this->scanFiles["perm"][] = array("file"=>"/", "permRequired"=>"0755", "friendlyName"=>"WordPress Root");
		$this->scanFiles["perm"][] = array("file"=>"/.htacces", "permRequired"=>"0644", "friendlyName"=>"WordPress htaccess file");
		$this->scanFiles["perm"][] = array("file"=>"/wp-admin/", "permRequired"=>"0755", "friendlyName"=>"WordPress Admin folder");
		$this->scanFiles["perm"][] = array("file"=>"/wp-admin/index.php", "permRequired"=>"0644", "friendlyName"=>"WordPress Admin index file");
		$this->scanFiles["perm"][] = array("file"=>"/wp-admin/js/", "permRequired"=>"0755", "friendlyName"=>"WordPress Admin JavaScript folder");
		$this->scanFiles["perm"][] = array("file"=>"/wp-includes/", "permRequired"=>"0755", "friendlyName"=>"WordPress Includes folder");
		$this->scanFiles["perm"][] = array("file"=>"/wp-content/", "permRequired"=>"0755", "friendlyName"=>"WordPress Content folder");
		$this->scanFiles["perm"][] = array("file"=>"/wp-content/themes/", "permRequired"=>"0755", "friendlyName"=>"WordPress Themes folder");
		$this->scanFiles["perm"][] = array("file"=>"/wp-content/plugins/", "permRequired"=>"0755", "friendlyName"=>"WordPress Plugins folder");

		add_action('admin_menu', array(&$this, 'hook_admin_menu'));
		add_action('admin_head', array(&$this, 'hook_admin_head'));
		add_action('admin_footer', array(&$this, 'hook_admin_footer'));
		add_action('wp_footer', array(&$this, 'hook_wp_footer'));
//		add_action('wp_head', array(&$this, 'hook_wp_head'));

	}
	function messageInfo($text, $type="updated"){
		return '<div id="message" class="' . $type . '"><p>' . $text . '</p></div>';
	}
	function hook_admin_menu(){
		if(current_user_can('manage_options')){
			add_menu_page('Vaccine', 'Vaccine', 10, 'vaccine/incs/welcome.php', '', plugins_url('vaccine/assets/images/icon-16.png'), 3);
		}
	}
	function hook_admin_head(){
		wp_enqueue_script("jquery");
		print $this->showLove();
	}
	function hook_wp_head(){
		print $this->showLove();
	}
	function hook_admin_footer(){
		print $this->showLove();
	}
	function hook_wp_footer(){
		print $this->showLove();
	}
	function fetchSpamCount(){
		global $wpdb;
		if(!$this->spamCount){
			$this->spamCount = $wpdb->get_var("SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = 'spam'");
		}
		return $this->spamCount;
	}
	function fetchVaccineNews(){
		if(!$this->newsXML){
			$this->newsXML = wp_remote_fopen('http://vaccine.studio.bloafer.com/');
		}
		return $this->newsXML;
	}
	function showLove(){
		return "\n\n<!-- " . $this->protectMessage . " -->\n\n";
	}
}
?>