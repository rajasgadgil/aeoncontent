<?php

/**
 * Template Name: Company Users
 *
 */

?>

<?php get_header(); 
if(is_user_logged_in()){
	$userid=get_current_user_id();
	$companyuser=0;
	$usercompany=get_user_meta($userid,'company_name',true);
		$user = get_userdata( $userid );
		$user_roles = $user->roles;
		if ( in_array( 'company_user', $user_roles, true ) ) {
		//user is company user
		$companyuser=1;
	}
if($companyuser==1){
?>
<section class="userspace_container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 colorful-background">
				<h2>Company Users</h2>
				<div class="card outercard">
						<?php

						$args = array(
							'role'    => 'company_user',
							'orderby' => 'user_nicename',
							'order'   => 'ASC'
						);
						$users = get_users( $args );
						?>
					<div class="card-body">
						<table class="table table-bordered userspacetable">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
								</tr>
							</thead>
							<tbody>
								<?php	
								foreach ( $users as $user ) {
									$fetchuserid=$user->ID;
									if($fetchuserid!=$userid){
										$fetchusercompany=get_user_meta($fetchuserid,'company_name',true);
										if($fetchusercompany==$usercompany){
										?>
										<tr>
											<td><?php echo $user->display_name;?></td>
											<td><?php echo $user->user_email;?></td>
										</tr>
										<?php
										}
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
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
				<h2>Please contact Sales Team to become company user</h2>
			</div>
		</div>
	</div>
</section>
<?php	
}
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