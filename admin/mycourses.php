<?php
require_once('../config.php');

require_login(null, false);
$url = new moodle_url('/admin/mycourses.php');

$PAGE->set_url($url);
$PAGE->set_context(context_user::instance($USER->id));
$PAGE->set_pagelayout('mydashboard');


$PAGE->set_title("My Courses");
$PAGE->set_heading("My Courses");

echo $OUTPUT->header();

echo $OUTPUT->footer();
