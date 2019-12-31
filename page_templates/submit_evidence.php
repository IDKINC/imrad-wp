<?php
/*
Template Name: Submit Evidence Page
 */
?>

<?php

if($_POST) 
{ 
    if(!is_user_logged_in(  )){

        wp_redirect(home_url('/login'));
        exit;
    }
    $submitted = array("title" => sanitize_text_field( $_POST["evidence_title"] ), "url" => esc_url( $_POST['evidence_url'] ), 'person' => intval($_POST['evidence_people']));

    print_r($submitted); 


}
    
    
    ?>


<?php get_header();?>

<container class="banner purple page__title">
		<?php
echo sprintf("<h1><a href='%s'>%s</a></h1>", get_the_permalink(), get_the_title()); ?>
		</container>

        <section class="page__content submit__grid">

            <div class="submit__form">
                <h2>Submit Evidence</h2>
                <em>All Evidence is verified for authenticity & accuracy.</em>
        <form name="submitEvidenceForm" id="submitEvidenceForm" method="post">
            <?php $field = new FormField("text", "Title", "evidence_title", array("required", "placeholder='So & So '", "minlength='25'"));?>

            <?php $field = new FormField("url", "URL", "evidence_url", array("required", "placeholder='e.g. https://twitter.com/IsMyRepADipshit/status/1207046141386412032'"));?>

            <span class="group material_input select evidence_people">
				<label for="evidence_people">Person</label>

				<select name="evidence_people" id="evidence_people" required>


                <?php

$current_person = intval($_GET['politician']);
$args           = array(
    'post_type'      => array('people'),
    'order'          => 'ASC',
    'orderby'        => 'name',
    'posts_per_page' => -1,
);

// The Query
$issues = new WP_Query($args);

// The Loop
if ($issues->have_posts()) {
    echo "<option disabled ". ($current_person === 0 ? "selected" : "").">Select A Person</option>";
    while ($issues->have_posts()) {
        $issues->the_post();
        // do something
        echo "<option " . ($current_person !== 0 && get_the_id() == $current_person ? "selected" : "") . " value='" . get_the_id() . "'>" . get_the_title() . "</option>";

    }
} else {
    // no posts found
}

// Restore original Post Data
wp_reset_postdata();?>


                </select>




			</span>

            <input type="submit" name="contactForm" value="Submit">
        </form>
                </div>


        <div class="submit__rules">
            <h2>Submission Rules</h2>

            <ul>
                <li>No Hate Speech.</li>
            </ul>
        </div>



		</section>


<?php get_footer();?>