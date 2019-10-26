(function ($) {




    function bindToggleOpen(toggle, dropdown) {

        $(toggle).click(function () {


            var searchBar = $(dropdown);

            if (searchBar.hasClass("is-open")) {

                searchBar.removeClass("is-open");

            } else {

                $(".is-open").removeClass("is-open");

                searchBar.addClass("is-open");

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


    })


})(jQuery);