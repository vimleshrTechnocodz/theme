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

defined('MOODLE_INTERNAL') || die();

/**
 * local_contact class. Handles processing of information submitted from a web form.
 * @copyright  2016-2019 TNG Consulting Inc. - www.tngconsulting.ca
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_coupons {    
    public function getCouponList(){
        global $DB,$USER,$CFG; 
        $coupons = $DB->get_records('coupons');
        $data = array(); 
        foreach($coupons as $key=>$coupon){
            $data[$key] = $coupon;
        }
        $results = new stdClass();
        $results->data = array_values($data);
        return  $results;
    }
    public function insertCoupon($data){
        global $DB,$USER,$CFG; 
        $couponid = $DB->insert_record('coupons', $data);
        return $couponid;
    }
}