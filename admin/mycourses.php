<?php
require_once('../config.php');

require_login(null, false);
$url = new moodle_url('/admin/mycourses.php');

$PAGE->set_url($url);
$PAGE->set_pagelayout('mydashboard');


$PAGE->set_title("My Courses");
$PAGE->set_heading("My Courses");

echo $OUTPUT->header();
?>
<style>
.ff_one{display:none;}
.lw_courses_list .coursebox:not(.span12) .progress {
    background: red;
    background: rgba(0,0,0,.2);
}
.lw_courses_list .progress:before {
    top: 11px;
}

.block_lw_courses .lw_courses_list .coursebox.span12 .title {
    border-bottom: 0px solid #000;
    padding-bottom: 5px;
    font-size: 18px;
    font-weight: 600;
    font-family: "Nunito",sans-serif;
}
.block_lw_courses .coursebox.list .course_image_embed {
    border-radius: 5px;
}
.block_lw_courses .lw_courses_list .coursebox:not(.span12) .course_title:after {
    background: #029ad2;
}
.block_lw_courses .lw_courses_list .coursebox.span12 {
    box-shadow: none;
    height: 230px;
    border-bottom: 1px solid #eee;
}
.block_lw_courses .lw_courses_list .coursebox.span12:hover {
    background-color: #f9fafc;
}
.lw_courses_list .coursebox .progress {
    margin-top: 10px;
}
.block_lw_courses .categorypath {
    color: rgb(126,126,126);
    margin-top: 10px;
    font-size: 15px;
}

.lw_courses_list .coursebox:not(.span12) .progress {
    top: -25px;
    color:#fff;
}
.list .progress:before {
    color: #333;
}
.block_lw_courses .lw_courses_list .coursebox:not(.span12):hover .teacher_names, .block_lw_courses .lw_courses_list .coursebox:not(.span12):focus .teacher_names {
    top: 190px;
}
.block_lw_courses .lw_courses_list .coursebox:not(.span12) {
    margin-right: 2% !important;
    width: 31.3% !important;
}
</style>
<script>
    $(document).ready(function(){        
        $('.filter-by-category .category-list').on('change', function() {            
            $('.coursebox').hide();            
            $('.categorypath:contains("'+$(this).val()+'")').closest('.coursebox').show();
            if($(this).val()=='')
            $('.coursebox').show();            
        });
    });
</script>
<?php
echo $OUTPUT->footer();