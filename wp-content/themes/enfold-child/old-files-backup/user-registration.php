<?php
/* Template Name: Registration Page */
?>



<?php

if (!$user_ID) {

    if ($_POST) {
        global $wpdb;


        $email = $wpdb->escape($_POST['txtEmail']);
        $password = $wpdb->escape($_POST['txtPassword']);
        $confirm_password = $wpdb->escape($_POST['txtConfirmPassword']);
        $username = $wpdb->escape($_POST['txtEmail']);
        $firstname = $wpdb->escape($_POST['txtFirstname']);
        $lastname = $wpdb->escape($_POST['txtLastname']);
        $companyaddress = $wpdb->escape($_POST['txtCompanyAddress']);
        $companyname = $wpdb->escape($_POST['txtCompanyName']);
        $companyphone = $wpdb->escape($_POST['txtphone']);


        $userdata = array(
            'user_email' => $email,
            'user_login' => $email,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'user_pass' => $password,
            'set_role' => 'company_user'
        );


        $error = array();

        if (!is_email($email)) {
            $error['email_valid'] = "Email has no valid value";
        }

        if (email_exists($email)) {
            $error['email_existance'] = "Email already exists";
        }

        if (strcmp($password, $confirm_password) !== 0) {
            $error['password'] = "Password Didn't matched";
        }



        if (count($error) == 0) {
            $user = wp_insert_user($userdata);
            wp_update_user(array('ID' => $user, 'role' => 'company_user'));
            add_user_meta($user, 'company_address', $companyaddress);
            add_user_meta($user, 'company_name', $companyname);
            add_user_meta($user, 'companyIDcard_status', 0);

            // getting registered user data
            $user_info = get_userdata($user);

            $v_code = md5(time());

            $string = array('id' => $user_info->ID, 'code' => $v_code);

            add_user_meta($user_info->ID, 'account_activated', 0);
            add_user_meta($user_info->ID, 'activation_code', $v_code);

            $url = get_site_url() . '/activate/?act=' . base64_encode(serialize($string));

            // email template
            $html = 'Please click the following link to verify <br/><br/> <a href="' . $url . '">' . $url . '</a>';
            wp_mail($user_info->user_email, 'Verify Email', $html);

            get_header();
?>

            <div class="col-md-6 offset-md-3">
                <p>Thankyou for Registering! Check your email for account activation link or <a href="/login">Login</a></p>
            </div>

        <?php
            get_footer();
            die();
        } else {
        }
        ?>
    <?php
    }
    get_header();
    ?>
<div class="container">
	
<?php

$forms = Forminator_API::get_forms(); // Method 1 to get all forms

$form_ids = array( 12, 34, 56, 78, 90 );
	
echo $form_ids[1];
	
	
	?>

	
</div>
    <form class="card col-md-6 offset-md-3 p-0" method="post">
        <div class="card-body">

            <p>
                <label>First Name</label><span class="star">*</span>
            <div>
                <input type="text" id="txtFirstname" name="txtFirstname" class="form-control" required>
            </div>
            </p>

            <p>
                <label>Last Name</label><span class="star">*</span>
            <div>
                <input type="text" id="txtFirstname" name="txtLastname" class="form-control" required>
            </div>
            </p>

            <p>
                <label>Enterprise</label><span class="star">*</span>
            <div>
                <input type="text" id="txtCompanyName" name="txtCompanyName" class="form-control" required>
            </div>
            </p>


            <p>
                <label>Your Email</label><span class="star">*</span>
            <div>
                <input type="text" id="txtEmail" name="txtEmail" class="form-control" required>
            </div>
            </p>

            <p>
                <label>Password</label><span class="star">*</span>
            <div>
                <input type="password" id="txtPassword" name="txtPassword" class="form-control" required>
            </div>
            </p>
            <p>
                <label>Confirm Password</label><span class="star">*</span>
            <div>
                <input type="password" id="txtConfirmPassword" name="txtConfirmPassword" class="form-control" required>
            </div>
            </p>
            <p>
                <label>Phone Number</label><span class="star">*</span>
            <div>
                <input type="tel" id="txtConfirmphone" name="txtphone" class="form-control" pattern="[0-9]{10}" required>
            </div>
            </p>

            <input type="submit" value="Register" class="btn btn-success">

        </div>
    </form>
    <br>
    <div class="col-md-6 offset-md-3 p-5">
        <?php
        echo '<p class="text-danger">' . print_r($error) . '</p>';
        ?>
    </div>
<?php

}
get_footer(); ?>