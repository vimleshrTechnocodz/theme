<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Content bank and its plugins settings.
 *
 * @package    core
 * @subpackage contentbank
 * @copyright  2020 Amaia Anabitarte <amaia@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');

$action = required_param('action', PARAM_ALPHANUMEXT);
$name   = required_param('name', PARAM_PLUGIN);

$syscontext = context_system::instance();
$PAGE->set_url('/admin/contentbank.php');
$PAGE->set_context($syscontext);

require_admin();
require_sesskey();

$return = new moodle_url('/admin/settings.php', array('section' => 'managecontentbanktypes'));

$plugins = core_plugin_manager::instance()->get_plugins_of_type('contenttype');
$sortorder = array_flip(array_keys($plugins));

if (!isset($plugins[$name])) {
    print_error('contenttypenotfound', 'error', $return, $name);
}

switch ($action) {
    case 'disable':
        if ($plugins[$name]->is_enabled()) {
            set_config('disabled', 1, 'contentbank_'. $name);
        }
        break;
    case 'enable':
        if (!$plugins[$name]->is_enabled()) {
            unset_config('disabled', 'contentbank_'. $name);
        }
        break;
    case 'up':
        if ($sortorder[$name]) {
            $currentindex = $sortorder[$name];
            $seq = array_keys($plugins);
            $seq[$currentindex] = $seq[$currentindex - 1];
            $seq[$currentindex - 1] = $name;
            set_config('contentbank_plugins_sortorder', implode(',', $seq));
        }
        break;
    case 'down':
        if ($sortorder[$name] < count($sortorder) - 1) {
            $currentindex = $sortorder[$name];
            $seq = array_keys($plugins);
            $seq[$currentindex] = $seq[$currentindex + 1];
            $seq[$currentindex + 1] = $name;
            set_config('contentbank_plugins_sortorder', implode(',', $seq));
        }
        break;
}
core_plugin_manager::reset_caches();
$cache = cache::make('core', 'contentbank_enabled_extensions');
$cache->purge();
$cache = cache::make('core', 'contentbank_context_extensions');
$cache->purge();

redirect($return);
