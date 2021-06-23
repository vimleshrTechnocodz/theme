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
 * Page module version information
 *
 * @package local_mbttutors
 * @copyright  2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../config.php');
require_once($CFG->dirroot . '/course/renderer.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/mdl_handler/ccn_mdl_handler.php');
require_once($CFG->dirroot . '/local/mbttutors/classes/mbttutors.php');
global $DB,$USER,$CFG; 

$tutorid = optional_param('tutorid', 0, PARAM_INT);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/mbttutors/assets/js/mbttutors.js'));
$PAGE->requires->css(new moodle_url($CFG->wwwroot.'/local/mbttutors/assets/css/style.css'));

$PAGE->set_url('/local/mbttutors/tutorcourses.php');
$PAGE->set_title(get_string('pluginname', 'local_mbttutors'));
$PAGE->set_heading(get_string('tutorcourses', 'local_mbttutors'));


if(!isloggedin()){
    $url = $CFG->wwwroot.'/login/index.php';
    redirect($url, '', 10);
}elseif(empty($tutorid)){
    $url = $CFG->wwwroot.'/local/mbttutors/';
    redirect($url, '', 10);
}

$mbttutors = new local_mbttutors();
$results = $mbttutors->getTutorCourses($tutorid);
echo $OUTPUT->header();

echo $OUTPUT->render_from_template('local_mbttutors/tutorcourses',$results);
echo $OUTPUT->render_from_template('local_mbttutors/popup',[]);
echo $OUTPUT->footer();