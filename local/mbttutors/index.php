<?php
// This file is part of the Contact Form plugin for Moodle - http://moodle.org/
//
// Contact Form is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Contact Form is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Contact Form.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This plugin for Moodle is used to send emails through a web form.
 *
 * @package    local_mbttutors
 * @copyright  2021 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Techno
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/local/mbttutors/classes/mbttutors.php');
global $DB,$USER,$CFG; 

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/mbttutors/assets/js/mbttutors.js'));
$PAGE->requires->css(new moodle_url($CFG->wwwroot.'/local/mbttutors/assets/css/style.css'));

$PAGE->set_url('/local/mbttutors/index.php');
$PAGE->set_title(get_string('pluginname', 'local_mbttutors'));
$PAGE->set_heading(get_string('heading', 'local_mbttutors'));

$mbttutors = new local_mbttutors();
$results = $mbttutors->getTutorsList();
// Display page header.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_mbttutors/tutors',$results);
// Display page footer.
echo $OUTPUT->footer();

