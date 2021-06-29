<?php
require_once('../../config.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot . '/local/mbttutors/classes/mbttutors.php');
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/mbttutors/assets/js/mbttutors.js'));
$PAGE->requires->css(new moodle_url($CFG->wwwroot.'/local/mbttutors/assets/css/style.css'));

require_login(null, false);
if(!is_siteadmin()){
    $url = $CFG->wwwroot.'/my';
    redirect($url, '', 10);
}
$url = new moodle_url('/local/mbttutors/tutorslist.php');
$PAGE->set_url($url);
$PAGE->set_pagelayout('mydashboard');

$mbttutors = new local_mbttutors();

$tutors = $mbttutors->getTutors();

$PAGE->set_title("Tutors List");
$PAGE->set_heading("Tutors List");

echo $OUTPUT->header();
//print_r($tutors);
echo $OUTPUT->render_from_template('local_mbttutors/tutorslist',$tutors);
echo '<style>.ff_one{display:none;}</style>';
echo $OUTPUT->footer();
