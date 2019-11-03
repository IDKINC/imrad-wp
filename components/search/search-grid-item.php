<section class="search-grid--item">

<?php

switch(get_post_type()){

    case "people" :
        $person = new Person(get_post());
        $person->personCard();
        break;
    case "state" :
        $state = new State(get_post());
        $state->stateCard();
        break;

}
 ?>



</section>