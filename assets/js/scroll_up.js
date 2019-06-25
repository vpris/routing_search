$(document).ready(function(){

    $(function (){
        $("#back-top").hide();

        $(window).scroll(function (){
            if ($(this).scrollTop() > 1000){
                $("#back-top").fadeIn();
            } else{
                $("#back-top").fadeOut();
            }
        });

        $("#back-top a").click(function (){
            $("body,html").animate({
                scrollTop:0
            }, 1000);
            return false;
        });
    });
});
