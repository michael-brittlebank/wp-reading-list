<?php
/*
Plugin Name: WP Reading List
Plugin URI: https://mikestumpf.com
Description: WP Reading List is a plugin designed to help organize and display books, magazines, articles, and anything else that you have read lately. 
Version: 4.0
Author: Mike Stumpf
Author URI: http://mikestumpf.com
License: GPL2
*/

/*

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
defined( 'ABSPATH' ) OR exit;

//register_activation_hook( __FILE__, 'wprl_rewrite_flush' );
/*Load the plugin functions*/
require 'wp-reading-list-functions.php';

//register_deactivation_hook( __FILE__, 'wprl_rewrite_flush' );
/*For uninstalling the plugin
register_uninstall_hook(__FILE__, 'delete_works');
*/

/*
*End of File
*/