jQuery(document).ready(function () {
    jQuery("#votePlus").click(function (e) {
        e.preventDefault();
        post_id = jQuery(this).attr("data-post_id");
        nonce = jQuery(this).attr("data-nonce");
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            data: { action: "imrad_vote", post_id: post_id, nonce: nonce, vote: 1 },
            success: function (response) {
                if (response.type == "success") {
                    jQuery("#voteCount").html(response.vote_count);
                    jQuery('.voted').removeClass("voted");

                    jQuery("#votePlus").addClass("voted");
                }
                else {
                    alert("Your like could not be added");
                }
            }
        });
    });

 
    jQuery("#voteMinus").click(function (e) {
        e.preventDefault();
        post_id = jQuery(this).attr("data-post_id");
        nonce = jQuery(this).attr("data-nonce");
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            data: { action: "imrad_vote", post_id: post_id, nonce: nonce, vote: -1 },
            success: function (response) {
                if (response.type == "success") {
                    jQuery("#evidence__"+post_id+" #voteCount").html(response.vote_count);
                    jQuery('.voted').removeClass("voted");
                    jQuery("#voteMinus").addClass("voted");

                }
                else {
                    alert("Your like could not be added");
                }
            }
        });
    });

});