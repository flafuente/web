<script>
    //$(window).load(function(){
    $( document ).ready(function() {
        $(".sqd_description").mCustomScrollbar({
            scrollButtons:{
                enable:true
            },
            theme:"dark"
        });
        $(".parrilla_big").mCustomScrollbar({
            scrollButtons:{
                enable:true
            },
            theme:"dark"
        });
        //$(".profile-picture-sq a.file-input-wrapper span").text($(".profile-picture-sq").parent().val());
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
    $(document).on("click","#seepasswd",function () {
        $('.form-change-pass').add('.mask').fadeIn();
    });
    $(document).on("click","#foto_upl_prof",function () {
        $('.uppic').add('.mask').fadeIn();
    });
    $(document).on("click",".mask",function () {
        //$('.login_form').add('.mask').fadeOut();
        $('.login_form').add('.contact_form').add('.search_form').add('.mask').add('.form-change-pass').add('.uppic').fadeOut();
    });
    $(document).on("click",".aclose",function () {
        //$('.login_form').add('.mask').fadeOut();
        $('.login_form').add('.contact_form').add('.search_form').add('.mask').add('.form-change-pass').add('.uppic').fadeOut();
    });

</script>