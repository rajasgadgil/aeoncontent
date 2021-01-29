<?php
/* Template Name: Company Profile */
get_header();
?>
<?php
if($user_ID) {
    if($_POST) {
    global $wpdb;
    global $current_user;
    $mainActivities = array();
    require_once('./wp-admin/includes/file.php');
    
    $nationality = $wpdb->escape($_POST['txtNationality']);
    $parentCompany = $wpdb->escape($_POST['txtParentCompany']);
    $mainActivities = $wpdb->escape($_POST['txtMainActivities']);
    $companyWebsite = $wpdb->escape($_POST['txtCompanyWebsite']);
    $yearofCreation = $wpdb->escape($_POST['txtYearofCreation']);
    $primaryContact = $wpdb->escape($_POST['txtPrimaryContact']);
    $uploadedfile = $_FILES['imageLogo'];
    $sectorofActivity = $wpdb->escape($_POST['txtSectorOfActivity']);
    $legalStatus = $wpdb->escape($_POST['txtLegalStatus']);
    $companySize = $wpdb->escape($_POST['txtCompanySize']);
    $apeCode = $wpdb->escape($_POST['txtApeCode']);
    $otherContacts = $wpdb->escape($_POST['txtOtherContacts']);

    $socialLinkedin = $wpdb->escape($_POST['txtSocialLinkedin']);
    $socialTwitter = $wpdb->escape($_POST['txtSocialTwitter']);
    $socialYoutube = $wpdb->escape($_POST['txtSocialYoutube']);
    $socialOther = $wpdb->escape($_POST['txtSocialOther']);

    $movefile = wp_handle_upload($uploadedfile, array('test_form' => false)); 

    // if ( $movefile ){
    //     echo $movefile['url'];
    //     // return $movefile['url'];
    //   }

    update_user_meta($current_user->ID, 'companyIDcard_status', 1);
    update_user_meta( $current_user->ID, 'nationality', $nationality );
    update_user_meta( $current_user->ID, 'parent_company', $parentCompany );
    update_user_meta( $current_user->ID, 'main_activities', $mainActivities);
    update_user_meta( $current_user->ID, 'company_website', $companyWebsite);
    update_user_meta( $current_user->ID, 'year_of_creation', $yearofCreation);
    update_user_meta( $current_user->ID, 'primary_contact', $primaryContact);
    update_user_meta( $current_user->ID, 'logo', $movefile['url']);
    update_user_meta( $current_user->ID, 'sector_of_activity', $sectorofActivity);
    update_user_meta( $current_user->ID, 'legal_status', $legalStatus);
    update_user_meta( $current_user->ID, 'company_size', $companySize);
    update_user_meta( $current_user->ID, 'ape_code', $apeCode);

    update_user_meta( $current_user->ID, 'social_linkedin', $socialLinkedin);
    update_user_meta( $current_user->ID, 'social_twitter', $socialTwitter);
    update_user_meta( $current_user->ID, 'social_youtube', $socialYoutube);
    update_user_meta( $current_user->ID, 'social_other', $socialOther);

    echo '<script>alert("Saved Successfully!")</script>';

    $redirecturl = get_site_url();
    wp_redirect( $redirecturl . '/' );

    ?>
    <?php
}
get_header();
?>

    <form class="card col-md-6 offset-md-3 p-0" method="post" enctype="multipart/form-data">
    <div class="card-body">
    Welcome <?php echo $current_user->first_name; ?>, Complete your company profile.
    <hr>


<p>
<label>Nationality</label>
<div>
<input type="text" id="txtNationality" name="txtNationality" class="form-control" value="<?php echo get_user_meta( $current_user->ID, 'nationality', true ); ?>">
</div>
</p>

<p>
<label>Parent Company</label>
<div>
<input type="text" id="txtParentCompany" name="txtParentCompany" class="form-control" value="<?php echo get_user_meta( $current_user->ID, 'parent_company', true ); ?>">
</div>
</p>

<p>
<label>Main Activities</label>
<div>
<select class="selectpicker form-control" name="txtMainActivities[]" multiple data-live-search="true">
    <option value="1" <?php $activities_array = get_user_meta( $current_user->ID, 'main_activities', true ); if (in_array("1", $activities_array)){ echo 'selected'; } ?>>1</option>
    <option value="2" <?php $activities_array = get_user_meta( $current_user->ID, 'main_activities', true ); if (in_array("2", $activities_array)){ echo 'selected'; } ?>>2</option>
    <option <?php $activities_array = get_user_meta( $current_user->ID, 'main_activities', true ); if (in_array("3", $activities_array)){ echo 'selected'; } ?>>3</option>
</select>
</div>
</p>

<p>
<label>Company Website</label>
<div>
<input type="text" id="txtCompanyWebsite" name="txtCompanyWebsite" class="form-control" value="<?php echo get_user_meta( $current_user->ID, 'company_website', true ); ?>">
</div>
</p>

<p>
<label>Year of Creation</label>
<div>
<input type="text" id="txtYearofCreation" name="txtYearofCreation" class="form-control" value="<?php echo get_user_meta( $current_user->ID, 'year_of_creation', true ); ?>">
</div>
</p>

<p>
<label>Primary Contact</label>
<div>
<input type="text" id="txtPrimaryContact" name="txtPrimaryContact" class="form-control" value="<?php echo get_user_meta( $current_user->ID, 'primary_contact', true ); ?>">
</div>
</p>

<p>
<label>Logo</label>
<div>
<input type="file" id="imageLogo" name="imageLogo" class="form-control">
<img src="<?php echo get_user_meta( $current_user->ID, 'logo', true ); ?>" width="100">
</div>
</p>


<p>
<label>Sector of activity of your customers</label>
<div>
<input type="text" id="txtSectorOfActivity" name="txtSectorOfActivity" class="form-control"  value="<?php echo get_user_meta( $current_user->ID, 'sector_of_activity', true ); ?>">
</div>
</p>

<p>
<label>Legal Status</label>
<div>
    <select name="txtLegalStatus" id="txtLegalStatus" class="form-control">
        <option <?php $activities_array = get_user_meta( $current_user->ID, 'legal_status', true ); if (in_array("1", $activities_array)){ echo 'selected'; } ?>>1</option>
        <option <?php $activities_array = get_user_meta( $current_user->ID, 'legal_status', true ); if (in_array("2", $activities_array)){ echo 'selected'; } ?>>2</option>
        <option <?php $activities_array = get_user_meta( $current_user->ID, 'legal_status', true ); if (in_array("3", $activities_array)){ echo 'selected'; } ?>>3</option>
    </select>
</div>
</p>

<p>
<label>Company Size</label>
<div>
    <select name="txtCompanySize" id="txtCompanySize" class="form-control">
    <?php
    for($i=1; $i<=50; $i++){
    ?>
        <option value="<?php echo $i; ?>" <?php $activities_array = get_user_meta( $current_user->ID, 'legal_status', true ); if (in_array($i, $activities_array)){ echo 'selected'; } ?>><?php echo $i; ?></option>
      <?php
    }
      ?>  
    </select>
</div>
</p>

<p>
<label>ape code</label>
<div>
<input type="text" id="txtApeCode" name="txtApeCode" class="form-control">
</div>
</p>

<p>------</p>
<b>table test for contacts</b>
<?php 
$results = $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta where meta_key = 'company_name'");
print_r($results);
?>
<p>------</p>



<p>
<label>Other Contacts</label>
<div>
<select name="txtOtherContacts" id="txtOtherContacts" class="form-control">
    <option></option>
</select>
</div>
<div>
<p>
<label>Main Activities</label>
<div>
<select class="selectpicker form-control" name="txtOtherContacts[]" multiple data-live-search="true">
    <option>1</option>
    <option>2</option>
    <option>3</option>
</select>
</div>
</p>
</div>
</p>

<hr>
<h2 class="mb-4">Network</h2>
<p>
<label>Linkedin</label>
<div>
<input type="text" id="txtSocialLinkedin" name="txtSocialLinkedin" class="form-control">
</div>
</p>

<p>
<label>Twitter</label>
<div>
<input type="text" id="txtSocialTwitter" name="txtSocialTwitter" class="form-control">
</div>
</p>

<p>
<label>Youtube</label>
<div>
<input type="text" id="txtSocialYoutube" name="txtSocialYoutube" class="form-control">
</div>
</p>

<p>
<label>Other</label>
<div>
<input type="text" id="txtSocialOther" name="txtSocialOther" class="form-control">
</div>
</p>

<input type="submit" value="Save" class="btn btn-success">

    </div>
    </form>
<?php 
}
get_footer(); 
?>