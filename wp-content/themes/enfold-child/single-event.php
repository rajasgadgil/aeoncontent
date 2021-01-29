<?php
	if ( !defined('ABSPATH') ){ die(); }
	
	global $avia_config;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();

	

	if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title(array('heading'=>'strong', 'title' => $title, 'link' => $t_link, 'subtitle' => $t_sub));
	
	do_action( 'ava_after_main_title' );
$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' )[0];
if(get_field('occurance_medium',$event->ID) == 'Online'):
 $medium = get_field('occurance_medium',$event->ID);
elseif(get_field('occurance_medium',$event->ID) == 'Location'):
    
    $medium = get_field('location_detail',$event->ID);
 endif;

 $register_button = get_field('register_button'); 
 $download_button = get_field('download_button');
 $contact_button = get_field('contact_button');
?>

		<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container template-blog template-single-blog '>

				<main class='content units <?php avia_layout_class( 'content' ); ?> <?php echo avia_blog_class_string(); ?>' <?php avia_markup_helper(array('context' => 'content','post_type'=>'post'));?>>

                 <div  class="event-page row justify-content-center mt-4">
					<div  class="col-12 page-title row align-items-center">
						
						<div  class="image card card-body" style="background-image: url(<?= $image ?>);"></div>
						
						<h1  class="col-12 font-weight-bold event-single-title"><?php the_title(); ?> </h1>
						
						<h3  class="col-12 date-author"> <?php echo date_format(date_create(get_field('occurance_date', $event->ID)) ,"d M Y");?> | <?= $medium ?> </h3> </div>
					<div  class="col-12 col-sm-10 my-5">
						<div  class="event-buttons-card card card-footer">
							<div  class="event-buttons row no-gutters my-3 justify-content-start">
								<div >
									
									<a  class="d-inline-block" container="body" href="<?= get_field('webinar_link'); ?>">
										<i class="fas fa-file-signature"></i>
									</a>
									
								</div>
								<?php if( $medium == 'Online'):?>
								<div >
									
									<a  class="d-inline-block" container="body" href="<?= $download_button['link']?>">
										<i class="fas fa-calendar-alt"></i>
									</a>
									
								</div>
								<?php endif; ?>
								<div >
									
									<a  class="d-inline-block" container="body" href="<?= $contact_button['link']?>">
										<i class="fas fa-envelope"></i>
									</a>
									
								</div>
							</div>
						</div>
						<div  class="card">
							<div  class="card-body">
								<div  class="page-content">
									<div  class="row description">
										<div  class="col-12">
											<style type="text/css">
											
											</style> 
											<?php if($medium == 'Online'):?>
												<span style="font-size:26px;"><strong><span style="color:#3081f1;"><img alt="" class="mb-3" src="https://cxp-prd-s3-cxp-statics.s3.eu-west-3.amazonaws.com/FR/Events_Images/Webinar_9_juillet_2020/picto_webinar.png" style="height: 36px;">&nbsp; </span></strong>
												</span><strong><span class="event-type-single" style="color:#3081f1;"><?php 
										$terms =  get_the_terms( get_the_ID(), 'event_categories');
                                        if($terms){
                                            foreach ($terms as $term) {
                                                $event_categories = $term->name;
                                            }
                                        }
											if($event_categories){ echo  $event_categories; }
											else { echo get_field('event_type');} ?>&nbsp;</span>
												</strong>
												<strong style="font-size: 18px; text-align: center; color: #42505d;">- <?php echo date_format(date_create(get_field('occurance_date', $event->ID)) ,"d M Y");?> à <?= get_field('minutes'); ?></strong>
											<?php endif;?>
											<div class="mb-3" style="text-align: justify;"><br>
												<?php the_content(); ?>
											</div>
											<?php if($medium == 'Online' && get_field('intervenants')):?>
											<h3 class="mt-4 event-single-intervenants">Intervenants</h3>
											
											<div class="row justify-content-xl-center mt-4 mb-4" style="background-color: #F9FBFF; border-radius: 5px 5px 0px 0px;box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);background-color:#fdfdfd;    margin: 3px;">
												<div class="col-12 mt-2 align-self-center mb-2 col-xl-6 pt-3 col-md-12 col-sm-12 col-lg-6" style="text-align: justify;">
													<div class="row">
														<?php $intervenants_1 = get_field('intervenants'); 
														if($intervenants_1):?>
															<div class="col-lg-12 text-center col-xl-12"><img alt="Placeholder image" class="rounded-circle img-fluid d-inline-block mr-3" min-width="110" src="<?= $intervenants_1['image']?>" style="min-width: 110px; max-width: 110px;">
																<aside class="align-self-center text-center mt-2"><?= $intervenants_1['Detail']?></aside>
															</div>
														<?php endif;?>
													</div>
												</div>
												<div class="col-12 mt-2 align-self-center mb-2 col-xl-6 pt-3 col-md-12 col-sm-12 col-lg-6" style="text-align: justify;">
													<div class="row">
														<?php $intervenants_2 = get_field('intervenants_2'); 
														if($intervenants_2):?>
															<div class="col-lg-12 text-center col-xl-12"><img alt="Placeholder image" class="rounded-circle img-fluid d-inline-block mr-3" min-width="110" src="<?= $intervenants_2['image']?>" style="min-width: 110px; max-width: 110px;">
																<aside class="align-self-center text-center mt-2"><?= $intervenants_2['Detail']?></aside>
															</div>
														<?php endif;?>
													</div>
												</div>
											</div>
											
											<h3 class="mt-5 event-single-intervenants">Modalités pratiques</h3> <span style="font-size: 16px; font-weight: 400;"><?= $medium ?><br>
				Les éléments vous permettant d'assister au webinar vous seront adressés par email.</span>
											<?php endif;?>
										</div>						
									</div>
									<hr  class="sep">
								
										<div  class="row justify-content-center align-items-center mt-4">
											<?php 
											if($register_button  ):?>
												<a  class="col row justify-content-center" href="<?= get_field('webinar_link'); ?>">
													<button  class="btn btn-primary w-100 m-3 event-single-detail-button" type="button"><i class="fas fa-file-signature"></i>
														 <span  ><span><?php if($register_button['label']){ echo $register_button['label'];} else { echo "S'inscrire à l'événement"; }?></span></span>
													</button>
												</a>
											<?php endif;?>
											<?php 
												if($download_button && $medium == 'Online'):?>
											<a  class="col row justify-content-center" href="<?= $download_button['link']?>">
												<button  class="btn btn-primary w-100 m-3  event-single-detail-button" type="button"><i class="fas fa-calendar-alt"></i>
													<span ><span><?php if($download_button['label']){ echo $download_button['label'];} else { echo "Ajouter à l'agenda"; }?></span></span>
												</button>
											</a>
											<?php endif;?>
											<?php 
												if($contact_button):?>
											<a  class="col row justify-content-center" href="<?= $contact_button['link']?>">
												<button  class="btn btn-primary w-100 m-3  event-single-detail-button" type="button"><i class="fas fa-envelope"></i>
													 <span ><span><?php if($contact_button['label']){ echo $contact_button['label'];} else { echo 'Contactez-nous'; }?></span></span>
												</button>
											</a>
											<?php endif;?>
										</div>

								</div>
							</div>
						</div>
					</div>
				</div>
	
		</main>

	</div>

</div>


<?php 
get_footer();
		
		