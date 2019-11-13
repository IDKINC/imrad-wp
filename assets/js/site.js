
(function ($) {




    function bindToggleOpen(toggle, dropdown) {

        $(toggle).click(function () {

            console.log(toggle + " CLICKED");
            var searchBar = $(dropdown);

            if (searchBar.hasClass("is-open")) {

                searchBar.removeClass("is-open");

            } else {

                $(".is-open").removeClass("is-open");

                searchBar.addClass("is-open");
                $(dropdwon + " input").focus();


            }
        });

    }


    bindToggleOpen("#mobileSearchToggle", "#searchBar");
    bindToggleOpen("#mobileMenuToggle", ".header__nav");


    $("#submitSearch").click(function (e) {

        if ($("#searchBar").hasClass('is-open')) {


        } else {

            e.preventDefault();

            $("#searchBar").addClass("is-open");
            $("#searchBar input").focus();
        }


    });
    $("#searchBar input").focusout(function () {

        if ($(this).val() === '') {

            $("#searchBar").removeClass("is-open");

        }


    });


})(jQuery);