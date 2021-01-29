<?php

/**
 * Template Name: Manage Favorite
 *
 */

?>

<?php get_header(); 
if(is_user_logged_in()){
	$userid=get_current_user_id();
?>
<section class="userspace_container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 colorful-background">
				<h2>My Favorites</h2>
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
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
								<?php 
								$favoritelist=get_user_favorites($user_id = $userid, $site_id = null, $filters = null);
								if(sizeof($favoritelist)>0){
									$count=0;
									foreach($favoritelist as $fav){
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