<?php
require_once('../config.php');

require_login(null, false);
$url = new moodle_url('/admin/coursecatalog.php');

$PAGE->set_url($url);
$PAGE->set_context(context_user::instance($USER->id));
$PAGE->set_pagelayout('mydashboard');


$PAGE->set_title("Course Catalog");
$PAGE->set_heading("Course Catalog");

echo $OUTPUT->header();

echo $OUTPUT->footer();
