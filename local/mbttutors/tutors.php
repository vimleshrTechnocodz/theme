<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Page module version information
 *
 * @package mod_page
 * @copyright  2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../config.php');

echo $OUTPUT->header();
global $DB,$USER;
$sql = "SELECT distinct 
            u.id as userid, 
            c.id, 
            c.fullname as coursename, 
            u.username, 
            u.firstname, 
            u.lastname,
            u.email,
            u.description FROM 
            cocoon_course as c, 
            cocoon_role_assignments AS ra, 
            cocoon_user AS u, 
            cocoon_context AS ct 
            WHERE c.id = ct.instanceid AND 
                ra.roleid =3 AND 
                ra.userid = u.id AND 
                ct.id = ra.contextid;";
      //GROUP BY u.username
$tutors = $DB->get_records_sql($sql);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tutors').DataTable({
            'iDisplayLength': 100,
            'language': {
                        searchPlaceholder: "Search Tutor..."
                    }
        });
        $('.free-enrol-now').click(function(e){
            e.preventDefault();
            var tutorId = $(this).attr('tutor-id');
            var d = new Date();
            d.setTime(d.getTime() + (2 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = "tutorId" + "=" + tutorId + ";" + expires + ";path=/";
            window.location = $(this).attr('href');           
        });
    } );
</script>
<style>
    .tutor-section{
        margin-top:30px;
        margin-bottom:80px;
    }
    #tutors thead{
        display: none;
    }
    #tutors tbody tr:last-child td{
        border-bottom: 1px solid #dee2e6;
    }
    .tutor-list{
        background-color: #FFF;
        border-radius: 5px;
        padding: 15px 0;
        border: 1px solid #ddd;
    }
    .tutor-list .dataTables_filter .form-control.form-control-sm{
        position: absolute;
        right: 20px;
        height: 45px;
        top: -11px;
        width: 100%;
    }
    .tutor-list .dataTables_length{
        display: none;
    }
    .tutor-list .dataTables_info{
        margin-left: 15px;
    }
    .tutor-list .dataTables_filter{
        margin-right: 15px
    }
    .tutor-list .dataTables_filter label{
        
    }
    .tutor-list .dataTables_paginate{
        margin-right: 15px !important;
    }
    .tutor-list .tutors-thum{
        width: 100%;
        min-height: 225px;
        background: #22222275;
        border-radius: 10px;
    }
    .tutor-list .description{
        margin-bottom: 50px;
    }
    .tutor-list .description p{
        height: 98px;
        overflow-y: auto;
    }
    .tutor-list  .tutor-bottm{
        float: left;
        position: absolute;
        right: 15px;
        bottom: 0;
        left: 15px;
    }
    .tutor-list  .tutor-bottm .comment{
        float: left;
        position: relative;
    }
    .connect-users,.comments{
        margin-right: 15px;
    }
    .tutor-list .free-enrol-now{
        float: right;
        background: #ff1053;
        border: 0;
        outline: none;
        color: #fff;
        font-weight: 600;
        font-size: 18px;
        padding: 5px 15px;
        border-radius: 20px;
    }
    .filter-list{
        background: #ddd;
    }
</style>
<div class="row tutor-section">
    <div class="col-sm-9"> 
        <div class="tutor-list">
        <table id="tutors" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>*</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($tutors as $tutor):
                    $link = '';
                    if(isloggedin()){
                        $link =  $CFG->wwwroot.'/course/tutorcourses.php?tutorid='.$tutor->userid;
                    }else{
                        $link =  $CFG->wwwroot.'/login/index.php';
                    }
                    ?>
                    <tr>
                        <td>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="tutors-thum"></div>
                            </div>
                            <div class="col-sm-8">
                                <h4><?php echo $tutor->coursename;?></h4>
                                <h3><?php echo  $tutor->firstname.' '.$tutor->lastname;?></h3>
                                <div class="rating">
                                    <span></span>
                                </div>
                                <div class="description">
                                    <p><?php echo  $tutor->description;?></p>                            
                                </div>
                                <div class="tutor-bottm">
                                    <div class="comment">
                                        <span class="connect-users"><i class="fa fa-user-o"></i> 200</span>
                                        <span class="comments"><i class="fa fa-comment"></i> 200</span>
                                    </div>
                                    <a href="<?php echo $link;?>" class="free-enrol-now" tutor-id="<?php echo  $tutor->userid;?>">Free Enrol Now</a>
                                </div>
                            </div>
                        </div>
                        </td>                
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="filter-list">
        
        </div>
    </div>
</div>
<?php

echo $OUTPUT->footer();
