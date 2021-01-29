<?php

/**
* Template Name: Shared Documents
*
*/
 get_header(); 
if(is_user_logged_in()){
	$userid=get_current_user_id();
?>
<section class="userspace_container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 colorful-background">
				<h2>Documents Shared By Me</h2>
				<div class="card outercard">
					<div class="card-body">
											<div class="table-responsive">
								<table class="table table-bordered userspacetable">
									<thead>
										<tr>
											<th>Document</th>
											<th>Documnet Type</th>
											<th>Author</th>
											<th>Publication Date</th>
											<th>Shared With</th>
											<th>Shared ON</th>
										</tr>
									</thead>
									<tbody>
									<?php
								$shraedbymelist=$wpdb->get_results("SELECT * FROM wp_sharedocs WHERE sharedby='$userid' order by sd_id desc");
								if(sizeof($shraedbymelist)>0){
									$count=0;
									foreach($shraedbymelist as $shareddoc){
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
				<h2>Documents Shared To Me</h2>
				<div class="card outercard">
					<div class="card-body">
											<div class="table-responsive">
								<table class="table table-bordered userspacetable">
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
											$postid=$shareddoc->postid;
											$sharedby=$shareddoc->sharedto;
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