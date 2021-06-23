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
require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
global $DB,$USER,$CFG; 

$tutorid = optional_param('tutorid', 0, PARAM_INT);


$mbttutors = new local_mbttutors();
$tutorcourses = $mbttutors->getTutorCourses($tutorid);
$check = 0;
foreach($tutorcourses->data as $cours){       
    $context = context_course::instance($cours->id);    
    // What role to enrol as?
    $studentroleid = $DB->get_field('role', 'id', array('shortname' => 'student'));
    if (!is_enrolled($context, $USER->id)) {
    // Not already enrolled so try enrolling them.
        if (!enrol_try_internal_enrol($cours->id, $USER->id, $studentroleid, time())) {
        // There's a problem.
            throw new moodle_exception('unabletoenrolerrormessage', 'langsourcefile');
        }else{
            $check = 1;
        }
    }
}
print_r($check);
die;