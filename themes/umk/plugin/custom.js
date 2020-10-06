


/*=============================================================
    Authour URI: www.binarycart.com
    License: Commons Attribution 3.0

    http://creativecommons.org/licenses/by/3.0/

    100% To use For Personal And Commercial Use.
    IN EXCHANGE JUST GIVE US CREDITS AND TELL YOUR FRIENDS ABOUT US
   
    ========================================================  */


(function ($) {
    "use strict";
    var mainApp = {

        main_fun: function () {
            /*====================================
            METIS MENU 
            ======================================*/
            $('#main-menu').metisMenu();

            /*====================================
              LOAD APPROPRIATE MENU BAR
           ======================================*/
            $(window).bind("load resize", function () {
                if ($(this).width() < 768) {
                    $('div.sidebar-collapse').addClass('collapse')
                } else {
                    $('div.sidebar-collapse').removeClass('collapse')
                }
            });  
     
        },

        initialization: function () {
            mainApp.main_fun();
        }

    }
    // Initializing ///

    $(document).ready(function () {
        mainApp.main_fun();
        $('#logo-cms').html('<a href="http://technophoria.co.id" target="blank" style="padding:0px;margin:0px;" title="TechnoPhoria.co.id"><img src="http://website.serverjogja.com/assets/img/techno.png" style="height:21px;float:left;margin:7px 5px;"></a>');
    });

}(jQuery));
