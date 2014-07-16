<script>
    //$(window).load(function(){
    $( document ).ready(function() {
        $(".sqd_description").mCustomScrollbar({
            scrollButtons:{
                enable:true
            },
            theme:"dark"
        });
    });
    $(document).on("click",".login",function () {
        $('.login_form').add('.mask').fadeIn();
    });
    $(document).on("click",".contact",function () {
        $('.contact_form').add('.mask').fadeIn();
    });
    $(document).on("click",".search",function () {
        $('.search_form').add('.mask').fadeIn();
    });
    $(document).on("click",".mask",function () {
        //$('.login_form').add('.mask').fadeOut();
        $('.login_form').add('.contact_form').add('.search_form').add('.mask').fadeOut();
    });
</script>