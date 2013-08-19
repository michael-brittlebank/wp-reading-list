<?php
/*
Plugin Name: WP Reading List
Plugin URI: https://github.com/mike-stumpf/reading-list
Description: A WordPress plugin for keeping track of and displaying the books that you read.
Version: 0.2
Author: Mike Stumpf
Author URI: http://mikestumpf.com
License: GPL2
*/

/*  Copyright 2013 Mike Stumpf  (email : mike@mikestumpf.com)

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

//Load the plugin functions
require 'wp-reading-list-functions.php';

//For uninstalling the plugin
register_uninstall_hook(__FILE__, 'delete_books');

 /*
 *End of File
 */