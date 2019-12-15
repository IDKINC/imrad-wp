<div class="account__menu">

<i class="fas fa-user-circle"></i>


<ul class="account__sub-menu">
<?php if(!is_user_logged_in(  )){

    echo "<li><a href='/login'>Login</a></li>";
    echo "<li><a href='/register'>Create Account</a></li>";
    
} else {

    echo "<li><a>My Account</a></li>";

}


?>

</ul>


</div>