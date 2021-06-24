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

defined('MOODLE_INTERNAL') || die();

/**
 * local_contact class. Handles processing of information submitted from a web form.
 * @copyright  2016-2019 TNG Consulting Inc. - www.tngconsulting.ca
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_mbttutors {
    
    public function getTutorsList($cat_id){         
        global $DB,$USER,$CFG; 
        $ccnCourseHandler = new ccnCourseHandler();
        if($cat_id){
            $sql = "SELECT distinct 
            u.id as userid, 
            c.id as courseid, 
            c.fullname as coursename, 
            cc.name as catname,
            u.username, 
            u.firstname, 
            u.lastname,
            u.email,
            u.description FROM 
            cocoon_course as c, 
            cocoon_course_categories as cc,
            cocoon_role_assignments AS ra, 
            cocoon_user AS u, 
            cocoon_context AS ct,
            cocoon_user_info_data as info_data 
            WHERE 
                c.id = ct.instanceid AND 
                cc.id = c.category AND
                cc.id = $cat_id AND
                ra.roleid =3 AND 
                ra.userid = u.id AND 
                ct.id = ra.contextid AND
                info_data.userid = u.id AND
                info_data.data='Tutor';";
        }else{
            $sql = "SELECT distinct 
            u.id as userid, 
            c.id as courseid, 
            c.fullname as coursename, 
            u.username, 
            u.firstname, 
            u.lastname,
            u.email,
            u.description FROM 
            cocoon_course as c, 
            cocoon_role_assignments AS ra, 
            cocoon_user AS u, 
            cocoon_context AS ct,
            cocoon_user_info_data as info_data 
            WHERE 
                c.id = ct.instanceid AND 
                ra.roleid =3 AND 
                ra.userid = u.id AND 
                ct.id = ra.contextid AND
                info_data.userid = u.id AND
                info_data.data='Tutor';";
        }
        
      //GROUP BY u.username
        $tutors = $DB->get_records_sql($sql);
        $data = array();        
        foreach($tutors as $key=>$tutor){            
            $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($tutor->courseid);             
            $data[$key] = $tutor;
            $data[$key]->categoryName = $ccnCourse->categoryName;
            if(isloggedin()){
                $data[$key]->link =  '#';
                $data[$key]->class = 'free-enrol-now';
            }else{
                $data[$key]->link =  $CFG->wwwroot.'/login/index.php';
                $data[$key]->class = '';
            }           
        }
        $results = new stdClass();
        $results->data = array_values($data);
        return  $results;
    }



    public function getTutorCourses($tutorid){
        global $DB,$USER,$CFG;   
        $ccnCourseHandler = new ccnCourseHandler();
        $sql = "SELECT 
        c.id,
        c.category,       
        c.fullname,
        c.shortname,
        c.sortorder,    
        c.idnumber,
        c.summary,
        c.summaryformat,
        c.format,
        c.showgrades,
        c.newsitems,
        c.startdate,
        c.enddate,  
        u.id as userid, 
        u.firstname, 
        u.lastname 
        FROM cocoon_course c
        JOIN cocoon_context ct ON c.id = ct.instanceid
        JOIN cocoon_role_assignments ra ON ra.contextid = ct.id
        JOIN cocoon_user u ON u.id = ra.userid
        JOIN cocoon_role r ON r.id = ra.roleid
        WHERE r.id = 3 AND u.id = $tutorid";
        $courses = $DB->get_records_sql($sql);


        foreach($courses as $key=>$course){            
            $data[$key] = $course;
            $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id); 
            $category = $DB->get_record('course_categories',array('id'=>$course->category));
            $rated = $this->overall_rating($course->id);
            $data[$key]->category = $category->name;
            $data[$key]->enrolmentIcon = $ccnCourse->ccnRender->enrolmentIcon;
            $data[$key]->announcementsIcon = $ccnCourse->ccnRender->announcementsIcon;
            $data[$key]->imageUrl = $ccnCourse->imageUrl;
            $data[$key]->link = $CFG->wwwroot.'/course/view.php?id='.$course->id;
            if($rated==0){
                $data[$key]->rated = '<i class="fa fa-star-o"></i> 
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>';
            }elseif($rated<=1){
                $data[$key]->rated = '<i class="fa fa-star"></i> 
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>';
            }elseif($rated<=2){
                $data[$key]->rated = '<i class="fa fa-star"></i> 
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>';
            }elseif($rated<=3){
                $data[$key]->rated = '<i class="fa fa-star"></i> 
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>';
            }elseif($rated<=4){
                $data[$key]->rated = '<i class="fa fa-star"></i> 
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>';
            }elseif($rated<=5){
                $data[$key]->rated = '<i class="fa fa-star"></i> 
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-"></i>';
            }
        }
        $results = new stdClass();
        $results->data = array_values($data);
        return $results;
    }


    public function overall_rating($courseID) {       
        global $DB,$USER,$CGF;     
        $sql = "  SELECT AVG(rating) AS average
                  FROM cocoon_theme_edumy_courserate
                  WHERE course = $courseID
               ";
        $totalAverage = -1;
        if ($getAverage = $DB->get_record_sql($sql)) {
            $totalAverage = round($getAverage->average * 2) / 2;
        }
        return $totalAverage;
    }

    public function mbtCategorie($idnumber){
        global $DB,$USER,$CFG;     
        $sql = "SELECT * FROM `cocoon_course_categories` WHERE idnumber='$idnumber'";
        $results = $DB->get_record_sql($sql);
        if($results){
            return $results;
        }
        return false;
    }
    public function mbtSubCategories($id){
        global $DB,$USER,$CFG;     
        $sql = "SELECT * FROM `cocoon_course_categories` WHERE parent=$id";
        $results = $DB->get_records_sql($sql);
        if($results){
            foreach($results as $key=>$result){ 
                $data[$key] = $result;
                $data[$key]->link =  $CFG->wwwroot.'/local/mbttutors/?cat_id='.$result->id;
            }
           
            return $data;
        }
        return new stdClass();
    }
}