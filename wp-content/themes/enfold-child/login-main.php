<?php

/*

TEMPLATE NAME: LOGIN MAIN

*/

global $user_ID;
global $wpdb;
if(!user_ID){        //logged out state
    get_header();
    
    ?>
    
<div class="container">


<form>

<label>Username or Email</label>    
<input type="text" id="username" name="username" placeholder="Username Or Email">

<lable>Password</lable>
<input type="password" id="password" name="password" placeholder="Password">
<input type="checkbox">Remember Me

<a href="">Forgot Password?</a>
</form>





</div>
<?php
get_footer();
    

}else{
    

    
    
}




?>
