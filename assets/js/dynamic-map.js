(function($){


    var dynamicMap = $(".dynamicMap"),
        zoomToggle = $("#zoomToggle");

        zoomToggle.click(function(){

            if($(".dynamicMap.zoom").length){
                $(".dynamicMap.zoom").remove();

                $("html, body").css("overflow", "inherit");

            } else {

                dynamicMap.clone().appendTo($("html")).addClass("zoom");


                $("html, body").css("overflow", "hidden");

                $(".dynamicMap.zoom #zoomToggle").click(function(){

                $(".dynamicMap.zoom").remove();


                $("html, body").css("overflow", "inherit");


                })
            }


        });




})(jQuery);