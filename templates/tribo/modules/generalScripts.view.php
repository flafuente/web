<script>
    //$(window).load(function () {
    $(window).load(function () {
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
    $(document).on("click","#triber_masinfo",function () {
        $('.masinfo_triber').add('.mask').fadeIn();
    });
    $(document).on("click","#open_new_tema",function () {
        $('.new_temaforo').add('.mask').fadeIn();
    });
    $(document).on("click",".mask",function () {
        //$('.login_form').add('.mask').fadeOut();
        $('.login_form').add('.contact_form').add('.search_form').add('.mask').add('.form-change-pass').add('.uppic').add('.greysquare').add('.secondgrey').add('.editgrey').add('.masinfo_triber').add('.new_temaforo').fadeOut();
    });
    $(document).on("click",".aclose",function () {
        //$('.login_form').add('.mask').fadeOut();
        $('.login_form').add('.contact_form').add('.search_form').add('.mask').add('.form-change-pass').add('.uppic').add('.greysquare').add('.secondgrey').add('.editgrey').add('.masinfo_triber').add('.new_temaforo').fadeOut();
    });
    $(function () {
        $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53193233-1', 'auto');
  ga('send', 'pageview');

</script>

