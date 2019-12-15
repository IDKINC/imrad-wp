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
        if(buttonClicked.data("voteMinus") === true) {vote = -1}
        if(buttonClicked.data("votePlus") === true) {vote = 1}

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


