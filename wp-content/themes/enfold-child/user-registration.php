<?php
    if ($_POST) {
        global $wpdb;


        $email = $wpdb->escape($_POST['txtEmail']);
        $password = $wpdb->escape($_POST['txtPassword']);
        $confirm_password = $wpdb->escape($_POST['txtConfirmPassword']);
        $username = $wpdb->escape($_POST['txtEmail']);
        $firstname = $wpdb->escape($_POST['txtFirstname']);
        $lastname = $wpdb->escape($_POST['txtLastname']);
        $companyname = $wpdb->escape($_POST['txtCompanyName']);
        $companyphone = $wpdb->escape($_POST['txtphone']);


        $userdata = array(
            'user_email' => $email,
            'user_login' => $email,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'user_pass' => $password,
			'user_nicename'=>$firstname.'_'.$lastname,
            'role' => 'prospect'
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
			//prosepect company
			$company=1;
            $user = wp_insert_user($userdata);
            wp_update_user(array('ID' => $user, 'role' => 'prospect'));
            add_user_meta($user, 'company_name', $companyname);
            add_user_meta($user, 'companyassigned', $company);

            // getting registered user data
            $user_info = get_userdata($user);

            $v_code = md5(time());

            $string = array('id' => $user_info->ID, 'code' => $v_code);

            add_user_meta($user_info->ID, 'account_activated', 0);
            add_user_meta($user_info->ID, 'activation_code', $v_code);

            $url = get_site_url() . '/activate/?act=' . base64_encode(serialize($string));

            // email template
            $html = 'Please click the following link to verify : ' . $url;
            wp_mail($user_info->user_email, 'Verify Email', $html);

?>

            <div class="col-md-12">
                <p>Thankyou for Registering! Check your email for account activation link or <a href="/login">Login</a></p>
            </div>

        <?php
        } else {
        }
        ?>
    <?php
    }
    ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <form class="card col-md-12 p-0 prospectregister" method="post">
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
      <div class="g-recaptcha" data-sitekey="6LcBSzcaAAAAAGOwVICtk-syP2ki5_gCzDMoXEVo"></div>
      <br/>
     
            <input type="submit" value="Register" class="btn btn-success">

        </div>
    </form>
            <?php
		if($error){
	?>
	<div class="col-md-6 offset-md-3 p-5">
        <?php
			foreach($error as $e){
				echo '<div class="text-danger">' .$e . '</div>';
			}
        ?>
    </div>
		<?php } ?>