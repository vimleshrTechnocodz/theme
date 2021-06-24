var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
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
                   $(".loading").toggle();
                },
                success: function (data) {
                    if(data){
                        if(data==1){
                           
                            setTimeout(function() {
                                alert('Join successfully');
                                $(".loading").toggle();
                                window.location.href = M.cfg.wwwroot+"/my/";                                
                            },5000);
                        }else{     
                            setTimeout(function() {
                                alert("Already join");
                                $(".loading").toggle();  
                                window.location.href = M.cfg.wwwroot+"/my/";                                
                            },5000);            
                        }
                    }else{
                        alert("Not  join, please contact"); 
                    }                    
                }
              });
            //alert("Enrolled successfully");
        });        
        setTimeout(function() {
            jQuery('#termsandconditions').modal('show');            
            var cat_id,filtercountry,state;
            if(getUrlParameter('cat_id')){
                cat_id = getUrlParameter('cat_id');
            }
            if(getUrlParameter('filtercountry')){
                filtercountry = getUrlParameter('filtercountry');
            }
            if(getUrlParameter('state')){
                state = getUrlParameter('state');
            }
            $("#filtercountry").val(filtercountry).change();
            $("input[name=cat_id][value=" + cat_id + "]").attr('checked', 'checked');
            $("#fstate").val(state.split('+').join(' '));         
          }, 1000);  
    } );
});
