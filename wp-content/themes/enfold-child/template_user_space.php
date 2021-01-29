<?php

/**
 * Template Name: User Space
 *
 */

?>

<?php get_header(); 
if(is_user_logged_in()){
	$companyuser=0;
	$myteknowusermanager=0;
	$userid=get_current_user_id();
	$user = get_userdata( $userid );
	$user_roles = $user->roles;
	if ( in_array( 'company_user', $user_roles, true ) ) {
		//user is company user
		$companyuser=1;
	}
	if ( in_array( 'myteknow_user_manager', $user_roles, true ) ) {
		$myteknowusermanager=1;
	}
	if($myteknowusermanager==0){
?>
<section class="userspace_container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2>Espace Membre</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				<div class="card outercard">
					<div class="card-header">
						<div class="row">
							<div class="col-sm-6">
								<h3>My Favorites</h3>
							</div>
							<div class="col-sm-6 text-right">
								<a href="<?php echo get_home_url();?>/manage-favorite" class="btn btn-primary btn-lg">View More</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Document</th>
											<th>Documnet Type</th>
											<th>Author</th>
											<th>Publication Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
								<?php 
								$favoritelist=get_user_favorites($user_id = $userid, $site_id = null, $filters = null);
								if(sizeof($favoritelist)>0){
									$count=0;
									foreach($favoritelist as $fav){
										if($count<10){
											$postid=$fav;
											$posttype=get_post_type($postid);
											$posttitle=get_the_title($postid);
											$posturl=get_the_permalink($postid);
											$postexcerpt=get_the_excerpt($postid);
											$postdate=get_the_date('d/m/Y', $postid);
											$author_id = get_post_field( 'post_author', $postid );
											$author_name = get_the_author_meta('user_nicename', $author_id);
											?>
											<tr>

												<td><a href="<?php echo $posturl; ?>"> <?php echo $posttitle;?></a> </td>
												<td><?php echo ucfirst($posttype); ?></td>
												<td><?php echo ucfirst($author_name);?></td>
												<td><?php echo $postdate; ?></td>
												<td><?php the_favorites_button($postid, $site_id);?></td>
											</tr>
											<?php
										}
										$count++;
										}
									}
									?>

									</tbody>
								</table>
							</div>
					</div>
				</div>

			</div>
			<div class="col-sm-2">
				<?php if($companyuser==1){?>
				<div class="card">
					<a href="<?php echo get_home_url();?>/company-users">
					<div class="cardhighlight1">
						<i class="fas fa-users"></i>					
						Company Users
					</div>
					</a>
				</div>
				<?php } ?>
				<div class="card">
					<a href="<?php echo get_home_url();?>/my-profile">
					<div class="cardhighlight2">
						<i class="fas fa-users"></i>					
						My Profile
					</div>
					</a>
				</div>
			</div>
		</div>
		<?php if($companyuser==1){?>
		<div class="row">
			<div class="col-sm-12">
				<div class="card outercard">
					<div class="card-header">
						<div class="row">
							<div class="col-sm-6">
								<h3>Documents Shared By Me</h3>
							</div>
							<div class="col-sm-6 text-right">
								<a href="<?php echo get_home_url();?>/shared-documents/" class="btn btn-primary btn-lg">View More</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Document</th>
											<th>Documnet Type</th>
											<th>Author</th>
											<th>Publication Date</th>
											<th>Shared With</th>
											<th>Shared On</th>
										</tr>
									</thead>
									<tbody>
								<?php 
								$shraedbymelist=$wpdb->get_results("SELECT * FROM wp_sharedocs WHERE sharedby='$userid' order by sd_id desc");
								if(sizeof($shraedbymelist)>0){
									$count=0;
									foreach($shraedbymelist as $shareddoc){
										if($count<5){
											$postid=$shareddoc->postid;
											$sharedto=$shareddoc->sharedto;
											$sharedon=$shareddoc->sharedon;
											//shared with user details
											$sharedtodetails = get_userdata( $sharedto );
											$posttype=get_post_type($postid);
											$posttitle=get_the_title($postid);
											$posturl=get_the_permalink($postid);
											$postexcerpt=get_the_excerpt($postid);
											$postdate=get_the_date('d/m/Y', $postid);
											$author_id = get_post_field( 'post_author', $postid );
											$author_name = get_the_author_meta('user_nicename', $author_id);
											?>
											<tr>

												<td><a href="<?php echo $posturl; ?>"> <?php echo $posttitle;?></a> </td>
												<td><?php echo ucfirst($posttype); ?></td>
												<td><?php echo ucfirst($author_name);?></td>
												<td><?php echo $postdate; ?></td>
												<td><?php echo $sharedtodetails->display_name;?></td>
												<td><?php echo date('d-m-Y',strtotime($sharedon));?></td>
											</tr>
											<?php
										}
										$count++;
										}
									}else{
									echo "<tr ><td colspan='6'><h4>No documents shared by you</h4></td></tr>";
								}
									?>

									</tbody>
								</table>
							</div>
					</div>
				</div>
				<br>
				<div class="card outercard">
					<div class="card-header">
						<div class="row">
							<div class="col-sm-6">
								<h3>Documents Shared To Me</h3>
							</div>
							<div class="col-sm-6 text-right">
								<a href="<?php echo get_home_url();?>/shared-documents/" class="btn btn-primary btn-lg">View More</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Document</th>
											<th>Documnet Type</th>
											<th>Author</th>
											<th>Publication Date</th>
											<th>Shared By</th>
											<th>Shared On</th>
										</tr>
									</thead>
									<tbody>
								<?php 
								$shraedtomelist=$wpdb->get_results("SELECT * FROM wp_sharedocs WHERE sharedto='$userid' order by sd_id desc");
								if(sizeof($shraedtomelist)>0){
									$count=0;
									foreach($shraedtomelist as $shareddoc){
										if($count<5){
											$postid=$shareddoc->postid;
											$sharedby=$shareddoc->sharedby;
											$sharedon=$shareddoc->sharedon;
											//shared with user details
											$sharedbydetails = get_userdata( $sharedby );
											$posttype=get_post_type($postid);
											$posttitle=get_the_title($postid);
											$posturl=get_the_permalink($postid);
											$postexcerpt=get_the_excerpt($postid);
											$postdate=get_the_date('d/m/Y', $postid);
											$author_id = get_post_field( 'post_author', $postid );
											$author_name = get_the_author_meta('user_nicename', $author_id);
											?>
											<tr>

												<td><a href="<?php echo $posturl; ?>"> <?php echo $posttitle;?></a> </td>
												<td><?php echo ucfirst($posttype); ?></td>
												<td><?php echo ucfirst($author_name);?></td>
												<td><?php echo $postdate; ?></td>
												<td><?php echo $sharedbydetails->display_name;?></td>
												<td><?php echo date('d-m-Y',strtotime($sharedon));?></td>
											</tr>
											<?php
										}
										$count++;
										}
								}else{
									echo "<tr ><td colspan='6'><h4>No documents shared with you</h4></td></tr>";
								}
									
									?>

									</tbody>
								</table>
							</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</section>

<?php 
}elseif($myteknowusermanager==1){
	?>
<section class="userspace_container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2>Manages the Company Users & profiles</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="card outercard">
					<div class="card-header">
						<div class="row">
							<div class="col-sm-6">
								<h3>All COMPANIES user’s team</h3>
							</div>
							<div class="col-sm-6 text-right">
								<a href="#" class="btn btn-primary btn-lg">Add User</a>
								<a href="#" class="btn btn-primary btn-lg">Manage Companies</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>User Name</th>
											<th>User Email</th>
											<th>Company</th>
											<th>Habilitation</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Dummy User 1</td>
											<td>dummyuser@gmail.com</td>
											<td>Prospect Company</td>
											<td>Company 1</td>
											<td><a class="btn btn-primary btn-lg" href="#">Reinit Password</a></td>
										</tr>
									</tbody>
								</table>
							</div>
					</div>
				</div>

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