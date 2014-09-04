<script>
    //$(window).load(function(){
    $(window).load(function(){
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
       // $(".file-input-wrapper span").text($(".file-input-wrapper input").val());
        $(".viddis span").text($("#viddis").attr("value"));
        $(".vidord span").text($("#vidord").attr("value"));
        $(".fotdis span").text($("#fotdis").attr("value"));
        $(".fotord span").text($("#fotord").attr("value"));
        //alert($("#inputtext").attr("value"));
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
    $(document).on("click","#btn_subir_video",function () {
        $('.greysquare').add('.mask').fadeIn();
    });
    $(document).on("click",".editclick",function () {
        $('.editgrey').add('.mask').fadeIn();
    });
    $(document).on("click",".mask",function () {
        //$('.login_form').add('.mask').fadeOut();
        $('.login_form').add('.contact_form').add('.search_form').add('.mask').add('.form-change-pass').add('.uppic').add('.greysquare').add('.secondgrey').add('.editgrey').fadeOut();
    });
    $(document).on("click",".aclose",function () {
        //$('.login_form').add('.mask').fadeOut();
        $('.login_form').add('.contact_form').add('.search_form').add('.mask').add('.form-change-pass').add('.uppic').add('.greysquare').add('.secondgrey').add('.editgrey').fadeOut();
    });
    $(function() {
         $( "#datepicker" ).datepicker();
    });

</script>