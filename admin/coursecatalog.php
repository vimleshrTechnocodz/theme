<?php
require_once('../config.php');

require_login(null, false);
$url = new moodle_url('/admin/coursecatalog.php');

$PAGE->set_url($url);
$PAGE->set_pagelayout('mydashboard');


$PAGE->set_title("Course Catalog");
$PAGE->set_heading("Course Catalog");

echo $OUTPUT->header();
echo '<style>.ff_one{display:none;}</style>';
echo $OUTPUT->footer();
