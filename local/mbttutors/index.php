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
require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot . '/local/mbttutors/classes/mbttutors.php');
$cat_id = optional_param('cat_id', 0, PARAM_INT);

global $DB,$USER,$CFG; 
/*if(!isloggedin()){
    $url = $CFG->wwwroot.'/login/index.php';
    redirect($url, '', 10);
}*/
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/mbttutors/assets/js/mbttutors.js'));
$PAGE->requires->css(new moodle_url($CFG->wwwroot.'/local/mbttutors/assets/css/style.css'));

$PAGE->set_url('/local/mbttutors/index.php');
$PAGE->set_title(get_string('pluginname', 'local_mbttutors'));
$PAGE->set_heading(get_string('heading', 'local_mbttutors'));

$mbttutors = new local_mbttutors();

$results = $mbttutors->getTutorsList($cat_id);

$mbtCategorie = $mbttutors->mbtCategorie('mbtmaincategory');
$datalist = new stdClass();
if($mbtCategorie){
    $mbtSubCategories = $mbttutors->mbtSubCategories($mbtCategorie->id);    
    $datalist->mbtSubCategories = array_values($mbtSubCategories);
}

// Display page header.
echo $OUTPUT->header();
/*echo '<pre>';
    print_r($mbtSubCategories);
    print_r($datalist);
echo '</pre>';*/
echo $OUTPUT->render_from_template('local_mbttutors/tutors',$results);
echo $OUTPUT->render_from_template('local_mbttutors/filters',$datalist);
echo $OUTPUT->render_from_template('local_mbttutors/popup',[]);
// Display page footer.
echo $OUTPUT->footer();

