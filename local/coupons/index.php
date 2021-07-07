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
 * @package    local_coupons
 * @copyright  2021 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Techno
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/local/coupons/classes/coupons.php');
require_once($CFG->dirroot . '/local/coupons/classes/coupon_form.php');

$url = new moodle_url('/local/coupons/index.php');
$PAGE->set_url($url);
$PAGE->set_title(get_string('pluginname', 'local_coupons'));
$PAGE->set_heading(get_string('heading', 'local_coupons'));
$PAGE->set_pagelayout('mydashboard');

$mform = new coupon_form();
$coupon = new local_coupons();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {   
  $data = new stdClass();
  $data->couponname = $fromform->couponname;
  $data->courseid = $fromform->courseid;
  $data->couponcode = $fromform->couponcode;
  $data->amount = $fromform->amount;
  $data->startdate = $fromform->strat;
  $data->enddate = $fromform->end;  
  $data->timeupdated = time();  
  $couponid = $coupon->insertCoupon($data);
  
} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.
 
  //Set default data (if any)
  $mform->set_data($toform);   
}
$coupons = $coupon->getCouponList();
// Display page header.
echo $OUTPUT->header();
if($couponid){
    echo "Success";
}else{
  echo "Fail";
}
$mform->display();
echo $OUTPUT->render_from_template('local_coupons/couponlist',$coupons);
echo '<style>.ff_one{display:none;}</style>';
echo $OUTPUT->footer();

