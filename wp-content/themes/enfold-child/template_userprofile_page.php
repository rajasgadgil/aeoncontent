<?php

/**
* Template Name: User Profile
*
*/

?>

<?php get_header();
if(is_user_logged_in()){
$userid=get_current_user_id();
?>


<!-- This section used for FORM -->
<section class="userspace_container">
<div class="container">
<div class="row">
<div class="col-sm-12 colorful-background">
<h2>My Profile</h2>
<form method="post" id="adduser" action="<?php //the_permalink(); ?>">
<p class="form-username">
<label for="first-name"><?php _e('First Name', 'profile'); ?></label>
<input class="text-input" name="first-name" type="text" id="first-name" value="<?php //the_author_meta( 'first_name', $current_user->ID ); ?>" />
</p><!-- .form-username -->
<p class="form-username">
<label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
<input class="text-input" name="last-name" type="text" id="last-name" value="<?php //the_author_meta( 'last_name', $current_user->ID ); ?>" />
</p><!-- .form-username -->
<p class="form-email">
<label for="email"><?php _e('E-mail *', 'profile'); ?></label>
<input class="text-input" name="email" type="text" id="email" value="<?php //the_author_meta( 'user_email', $current_user->ID ); ?>" />
</p><!-- .form-email -->
<p class="form-url">
<label for="url"><?php _e('Website', 'profile'); ?></label>
<input class="text-input" name="url" type="text" id="url" value="<?php //the_author_meta( 'user_url', $current_user->ID ); ?>" />
</p><!-- .form-url -->
<p class="form-password">
<label for="pass1"><?php _e('Password *', 'profile'); ?> </label>
<input class="text-input" name="pass1" type="password" id="pass1" />
</p><!-- .form-password -->
<p class="form-password">
<label for="pass2"><?php _e('Repeat Password *', 'profile'); ?></label>
<input class="text-input" name="pass2" type="password" id="pass2" />
</p><!-- .form-password -->
<p class="form-textarea">
<label for="description"><?php _e('Biographical Information', 'profile') ?></label>
<textarea name="description" id="description" rows="3" cols="50"><?php //the_author_meta( 'description', $current_user->ID ); ?></textarea>
</p><!-- .form-textarea -->
<p class="form-submit">
<?php echo $referer; ?>
<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'profile'); ?>" />
<?php wp_nonce_field( 'update-user' ) ?>
<input name="action" type="hidden" id="action" value="update-user" />
</p><!-- .form-submit -->
</form><!-- #adduser -->
</div>
</div>
</div>
</section>

<?php 
}else{
?>
<section>
<div class="container">
<div class="row">
<div class="col-sm-12">
<h2>Please login to view this page</h2>
</div>
</div>
</div>
</section>
<?php
}

get_footer(); ?>