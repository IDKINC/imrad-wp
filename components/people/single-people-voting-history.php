<?php global $people; ?>

<section class="banner dipshit-meter__container">
<h2>Voting History</h2>
</section>

<container class="grid grid--two">
    <section>
        <div class="chart" id="votesWith" data-with="<?= $people_obj->votesWith ?>" data-withcolor="<?= $people_obj->partyColor ?>" data-againstcolor="#ccc" data-against="<?= $people_obj->votesAgainst ?>" viewBox="0 0 400 400" perserveAspectRatio="xMinYMid"></div>

        <div class="chart__legend" id="votesWith__legend">
            <ul>
                <li><span class="swatch" style="background-color: <?= $people_obj->partyColor ?>;"></span>Votes With Party: <?= $people_obj->votesWith ?>%</li>
                <li><span class="swatch" style="background-color: #ccc;"></span>Votes Against Party: <?= $people_obj->votesAgainst ?>%</li>
            </ul>
        </div>
    </section>
    <section>
        <h2>Voting History Details</h2>
        <?php 


        $content = apply_filters('the_content', $people_obj->votesDetails);

        if($content){

            echo $content;

        } else {

            echo "<h4>No Additional Information</h4>";
        }
            
            

        ?>
    </section>


</container>

