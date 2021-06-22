require(['core/first','jquery','jqueryui','core/ajax'],function(core, $, bootstrap,ajax){
    $(document).ready(function() {        
        $('.free-enrol-now').click(function(e){
            e.preventDefault();
            var tutorId = $(this).attr('tutor-id');
            var d = new Date();
            d.setTime(d.getTime() + (10 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = "tutorId" + "=" + tutorId + ";" + expires + ";path=/";
            window.location = $(this).attr('href');           
        });
        $('.get-course').click(function(e){
            e.preventDefault();
            alert("Tutor Notify Successfully");
        });
    } );
});
