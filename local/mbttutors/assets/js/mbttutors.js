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
            alert("Enrolled successfully");
        });
        $('.free-enrol-now').click(function(e){
            e.preventDefault();
            var url = M.cfg.wwwroot+'/local/mbttutors/freeenrolled.php';           
            var tutorid = $(this).attr('tutor-id');
            $.ajax({
                type: 'post',
                url: url,
                data: {tutorid:tutorid},
                beforeSend: function() {               
                   
                },
                success: function (data) {
                    if(data){
                        if(data==1){
                            alert('Enrolled successfully');
                            window.location.href = M.cfg.wwwroot+"/my/";
                        }else{                        
                            alert("Already enrolled");  
                            window.location.href = M.cfg.wwwroot+"/my/";                  
                        }
                    }else{
                        alert("Not  enrolled, please contact"); 
                    }                    
                }
              });
            //alert("Enrolled successfully");
        });
        
        setTimeout(function() {
            jQuery('#termsandconditions').modal('show');
          }, 1000);  
    } );
});
