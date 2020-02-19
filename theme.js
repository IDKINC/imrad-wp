/* start donut charts */
(function (one) {
    var chart = d3.select("#votesWith"),
    chartJ = jQuery('#votesWith'),
    withColor = chartJ.data('withcolor'),
    againstColor = chartJ.data('againstcolor');

    var width = 400,
        height = 400,
        radius = 200,
        colors = d3.scaleOrdinal()
            .range([withColor, againstColor]);
    var piedata = [{
        label: "Votes With Party",
        value: chartJ.data('with')
    }, {
        label: "Votes Against Party",
        value: chartJ.data('against')
    },];


    var pie = d3.pie().value(function (d) {

            return d.value;

        })
    var arc = d3.arc()
        .innerRadius(radius - 100)
        .outerRadius(radius)

    var donutChart = chart.append('svg')
    .attr("preserveAspectRatio", "xMidYMid meet")
    .attr("viewBox", "0 0 " + width + " " + height)
        .append('g')
        .attr('transform', 'translate(' + (width - radius) + ',' + (height - radius) + ')')
        .selectAll('path').data(pie(piedata))
        .enter().append('g')
        .attr('class', 'slice')



    var slices1 = d3.selectAll('g.slice')
        .append('path')
        .attr('fill', function (d, range) {
            return colors(range);
        })
        .attr('d', arc)

})();
function animateValue(id, start, end, duration) {
    // assumes integer values for start and end
    
    var obj = document.querySelector(id);
    var range = end - start;
    // no timer shorter than 50ms (not really visible any way)
    var minTimer = 50;
    // calc step time to show all interediate values
    var stepTime = Math.abs(Math.floor(duration / range));
    
    // never go below minTimer
    stepTime = Math.max(stepTime, minTimer);
    
    // get current time and calculate desired end time
    var startTime = new Date().getTime();
    var endTime = startTime + duration;
    var timer;
  
    function run() {
        var now = new Date().getTime();
        var remaining = Math.max((endTime - now) / duration, 0);
        var value = Math.round(end - (remaining * range));
        obj.innerHTML = value;
        if (value == end) {
            clearInterval(timer);
        }
    }
    
    timer = setInterval(run, stepTime);
    run();
}


var counters = document.querySelectorAll(".countUp");
var countersArr = [];

counters.forEach(function(counter, i){
    counter.id = "counter-" + i;
    countersArr[i] = "#" + counter.id;
    
});

countersArr.forEach(function(id, i){

    return animateValue(id, 0, document.querySelector(id).dataset.number, 5000 * 0.5 * (i + 1));
}); 
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
function toggleButton(button, disabled = false){

    if(disabled){
        button.attr("disabled", true);
    } else {

        button.attr("disabled", false);

    }


}

jQuery(document).ready(function () {

    jQuery("[data-voteButton]").click(function (e) {
        e.preventDefault();
        var evidence_id = jQuery(this).attr("data-evidence_id");
        var buttonClicked = jQuery(this);
        var vote = null;
        if(buttonClicked.data("voteminus") === true) {vote = -1}
        if(buttonClicked.data("voteplus") === true) {vote = 1}

        toggleButton(buttonClicked, true);

        nonce = jQuery(this).attr("data-nonce");
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            data: { action: "imrad_vote", evidence_id: evidence_id, nonce: nonce, vote: vote},
            success: function (response) {
                toggleButton(buttonClicked, false);

                if (response.type === "success") {
                    jQuery("#evidence__" + evidence_id + " #voteCount").html(response.vote_count);
                    jQuery("#evidence__" + evidence_id + " .voted").removeClass("voted");

                    buttonClicked.addClass("voted");
                } else if (response.type === "login"){
                    toggleButton(buttonClicked, true);

                    buttonClicked.html("<a href='/login'>Please Login To Vote</a>");
                } else {
                    alert("Your Vote could not be added");
                }
            }
        });
    });


    // jQuery("[data-voteMinus]").click(function (e) {
    //     e.preventDefault();
    //     buttonClicked = jQuery(this);
    //     evidence_id = jQuery(this).attr("data-evidence_id");
    //     nonce = jQuery(this).attr("data-nonce");
    //     jQuery.ajax({
    //         type: "post",
    //         dataType: "json",
    //         url: myAjax.ajaxurl,
    //         data: { action: "imrad_vote", evidence_id: evidence_id, nonce: nonce, vote: -1 },
    //         success: function (response) {
    //             if (response.type == "success") {
    //                 jQuery("#evidence__" + evidence_id + " #voteCount").html(response.vote_count);
    //                 jQuery("#evidence__" + evidence_id + " .voted").removeClass("voted");
    //                 buttonClicked.addClass("voted");

    //             }
    //             else {
    //                 alert("Your Vote could not be added");
    //             }
    //         }
    //     });
    // });

});



//# sourceMappingURL=theme.js.map
