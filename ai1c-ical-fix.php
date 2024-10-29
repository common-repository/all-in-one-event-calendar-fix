<?php
define('AI1CIF_PLUGIN_PATH', plugin_dir_PATH( __FILE__ ));
require_once(AI1CIF_PLUGIN_PATH . 'class.html2text.inc');

/*
Plugin Name: All-in-one Event Calendar Fix
Plugin URI: http://www.mortis.org.uk/?p=512
Description: Strips HTML tags from calendar events when synced with iCal or Outlook's calendar
Version: 1.0
Author: Matt Judge
Author URI: http://www.mortis.org.uk/


        Copyright 2013  Matt Judge  (email: wp-plugins@mortis.org.uk)

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
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


/* We don't need the All-in-One Event Calendar installed but this
   plugin is pretty pointless without it! */
function dependentplugin_activate()
{
  require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
 
  if ( !is_plugin_active( 'all-in-one-event-calendar/all-in-one-event-calendar.php' ) )
  {
    deactivate_plugins( __FILE__);
    exit ('This plugin requires All-in-One Event Calendar by Timely!');
   }
}
register_activation_hook( __FILE__, 'dependentplugin_activate' );


/* Wow.  Is this all I needed to do to fix the problem? */
function parse_ai1ec_content($content)
{
  if ( $_REQUEST['controller'] == 'ai1ec_exporter_controller' && $_REQUEST['action'] == 'export_events' )
  {
    /* Matching only iCal and Microsoft Outlook */
    //$uAgent = $_SERVER["HTTP_USER_AGENT"];
    //if ( preg_match('/^CalendarStore.*iCal/i', $uAgent) || preg_match('/^Microsoft Office/i', $uAgent) )
    //{
    //  $h2t =& new html2text($content);
    //  return $h2t->get_text();
    //}

    /* Match all requests for now */
    $h2t =& new html2text($content);
    return $h2t->get_text();
  }

  return $content;
}
add_filter('the_content', 'parse_ai1ec_content');
?>
