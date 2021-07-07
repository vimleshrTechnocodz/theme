<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_once($CFG->libdir. '/coursecatlib.php'); 
class coupon_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;
        
        $mform = $this->_form; // Don't forget the underscore!  
        
        $options = array();
        $allcourses = coursecat::get(0)->get_courses(array('recursive'=> true));
        foreach ($allcourses as $key=>$course) {
            $options[$course->id] = $course->fullname;
        }
        $mform->addElement('select', 'courseid', get_string('course'), $options);
        $mform->setDefault('courseid', $currentcourseid);

        $mform->addElement('text', 'couponname', get_string('couponname', 'local_coupons'));                  
        $mform->setDefault('couponname', get_string('entercouponname', 'local_coupons')); 
        

        $mform->addElement('text', 'couponcode', get_string('couponcode', 'local_coupons'));              
        $mform->setDefault('couponcode', get_string('entercouponcode', 'local_coupons')); 

        $mform->addElement('text', 'amount', get_string('amount', 'local_coupons'));         
        $mform->setDefault('amount', get_string('enteramount', 'local_coupons')); 

        $mform->addElement('date_selector', 'strat', get_string('start', 'local_coupons'));
        $mform->addElement('date_selector', 'end', get_string('end', 'local_coupons'));

        $buttonarray=array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('savechanges'));

        $buttonarray[] = $mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }

    
}