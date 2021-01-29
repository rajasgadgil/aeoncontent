<?php

/**
 * Template Name: Event Page
 *
 */

?>

<?php get_header(); ?>
<?php
    $currentdate= date("F Y");
    $custom_post_type  = 'event';
    $custom_date_field = 'occurence_date';
    $order             = 'DESC'; // from the oldest to the newest
    $title;
    $dropdown = [];
    // query
    $the_query = new WP_Query( [
        'post_type'      => $custom_post_type,
		'post_status'    => 'publish',
        'meta_key'       => $custom_date_field,
        'orderby'        => 'meta_value',
        'order'          => $order,
    ] );

// We are creating new multidimensional array
    $all_events = [];
    $year = [];
    while ( $the_query->have_posts() ) :
        $the_query->the_post();

        $date       = strtotime( get_post_meta( get_the_ID(), $custom_date_field, true ) );
        $month_year = date( "F Y", $date );
        if(strtotime($month_year) >= strtotime($currentdate)){
            $dropdown[] = $month_year;     
        }
        $all_events[ $month_year ][] = $the_query->post;

    endwhile;
    wp_reset_query();
//print_r($all_events);
?>

<div id="content-wrap" class="row justify-content-center">
    <div class="content-area clr col-10 my-5">
        <section class="event--body pt-4 pb-5">
            <div class="container event--container px-0 text-dark hc-fw-400">
                <div class="row mb-2 mt-0 titretop" style="">
                    <div class="col-xl-6 mt-3 col-md-12 col-lg-7 align-content-center justify-content-center pt-xl-2" style="font-size:30px">
                        <h2 style="text-transform:;font-size: 40px;font-family: inherit;font-weight: 700;line-height: 1.2;color: inherit;"><?= get_field('page_title')?></h2>
                    </div>
                    <div class="col-xl-6 text-xl-right text-lg-right text-md-left text-sm-left mt-3 col-md-12 col-lg-5">
                        
                        <div class="dropdown" style="">
                            <button class="dropbtn btn-primary dropdown-toggle event-dropdown" data-toggle="dropdown" style="" type="button">Dates des prochains événements</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php 
                                $dropdownlist = array_unique($dropdown);
                                foreach ( $dropdownlist as $dropdown_element ) : 
								$month_year_string = str_replace(' ', '_', $dropdown_element);?>
                                    <a class="dropdown-item pt-2 pb-0 mt-0 mb-0 event-dates" href="#event-<?= $month_year_string; ?>"><?= $dropdown_element ?></a>
                                <?php endforeach;?>
                                    <a class="pt-2 pb-0 mt-0 mb-0 dropdown-item event-dates" href="#DIGITAL_FACTORY" style="">Digital Factory</a>
                            </div>
                        </div>
                    </div>
                </div>
                 <hr>
        
                <?php
                 $count = 0;
                // And to print this:
                foreach ( $all_events as $month_year => $events ) : 
                    $month_year_arr = explode(' ', $month_year);
                    $month = $month_year_arr[0];
                    $year = $month_year_arr[1];
                    $occurance_date = date_create(get_field('occurence_date', $event->ID));
                   
                    if(strtotime($month_year) < strtotime($currentdate)){
                        $count++;                  
                    }
                    
                    if($count == 1){
                        echo '<div class="row mb-2 mt-5" id="DIGITAL_FACTORY" >
                        <div class="mt-3 col-md-12 col-xl-12 col-lg-12" style="font-size:30px"><span style="text-transform: uppercase;">'. get_field('ended_event_title').'</span></div>
                        </div><hr>';  
                    }
				$month_year_string = str_replace(' ', '_', $month_year);
                    ?>
                   <div class="events-card card col-xl-12 color col-md-12  mt-5" id="event-<?= $month_year_string; ?>" style="box-shadow: 0 5px 15px 0 rgba(32,39,48,.16); cursor: pointer;border: 1px solid rgba(0,0,0,.125);">
                        <div class="card-body pl-xl-2 pr-xl-2">
                            <div class="row visibleonly1200 pb-3"><a id="inscription" name="inscription"> </a></div>
                            <div class="row ">
                                <div class="col-xl-2 col-lg-2 col-md-12 d-xl-block ">
                                    <hr align="left" class="mt-0" style="height: 2px; color: #3E4845; background-color: #3E4845; width: 70%; border: none;">
                                    <a id="inscription" name="inscription"> </a>
                                    <p style="color: #3E4845;line-height:25px; font-size:22px; font-weight: 700" class="month-year-style"><span class="month-style"><?= $month ?></span><br>
                                        <?= $year ?>
                                        </p>
                                </div>
                                <div class="col-xl-10 col-lg-10 col-md-12 d-xl-block  event-block">
                                    
                                    <?php 
                                    /** @var \WP_Post $event */
                                    foreach ( $events as $event ) : 

                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $event->ID ), 'single-post-thumbnail' )[0];
										$terms =  get_the_terms( $event->ID, 'event_categories');
                                        if($terms){
                                            foreach ($terms as $term) {
                                                $event_categories = $term->name;
                                            }
                                        }
									?>
                                        <div class="row event-month">
											<div class="col-xl-1 col-lg-1 text-xl-center col-2 col-md-2  d-xl-block  suppressiondiv  pl-xl-0"><img alt="Placeholder image" class="text-center" src="<?= get_field('occurence_date_image', $event->ID); ?>" style=""></div>
                                            <div class="pr-3 pl-3 text-xl-center text-lg-left col-xl-3  d-lg-block col-md-4 col-sm-12 col-lg-4 marge1400 ">
                                            <img alt="Placeholder image" class="rounded event-preview-img" height="" src="<?= $image ?>" style="max-width: 250px">
                                            </div>
                                            <div class="col-xl offset-xl-1 mt-3 mt-lg-0 col-12 adaptationimage col-sm-12 col-lg-8 col-md-12 marge1200 pl-0 pl-lg-3">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 btn-group-vertical">

                                                        <table border="0" cellpadding="0" cellspacing="0" class="text-center" style="background-color: #DFDFDF; color: #FFFFFF" width="130">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="py-1 event-type" scope="col" ><?php 
																		if($event_categories){ echo  $event_categories; }
												 						else { echo get_field('event_type', $event->ID);} ?></th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        
                                                    </div>
                                                    <div class="col-xl-7 border-right-0 col-lg-7 col-md-8 col-sm-8 mt-3 mt-sm-0 offset-xl-2 offset-lg-2 offset-md-8 offset-sm-8" style="text-align: right">
                                                        <?php if(get_field('has_partnership', $event->ID) ):?>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="partnership-table">
                                                            <tbody>
                                                                <tr>
                                                                    <th style="text-align: right;font-weight: 700; font-size: 15px">In partnership with</th>
                                                                    <th class="text-right ml-1" width="135"><img alt="Placeholder image" src="<?= get_field('partner_logo', $event->ID); ?>" style="text-align: left;" width="70"></th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                                <h2 class="card-title mt-3 event-card-title post-title event-title " ><b><?= $event->post_title ?></b></h2>
                                                <hr align="left" class="mt-0 title-hr">
                                                <div class="row detail-events">
                                                    <div class="pl-2 col-12 offset-xl-0 offset-lg-0 col-lg-5 offset-md-0 col-md-4 col-xl-5 pl-3 text-md-center text-lg-left col-sm-5">
                                                        <img alt="Placeholder image" class="mb-2 mr-2 calendrier-icon" height="25" src="<?= get_field('calender_icon') ?>"> 
                                                        <span style="font-size: 14px; line-height:15px; color: #3E4845; font-weight: 400">
                                                            <?php 
                                                                if(!get_field('check_if_event_ends_on_different_date', $event->ID)):
                                                                 $date=date_create(get_field('occurence_date', $event->ID));
                                                                echo date_format($date,"l j F");

                                                                else:

                                                                   $date=date_create(get_field('occurence_date', $event->ID));
                                                                    $occurance_end_date=date_create(get_field('occurance_end_date', $event->ID));
                                                                    $start_month = date_format($date,"F");
                                                                    $end_month = date_format($occurance_end_date,"F");

                                                                    // 
                                                                  
                                                                    $Variable1 = strtotime(get_field('occurence_date', $event->ID)); 
                                                                    $Variable2 = strtotime(get_field('occurance_end_date', $event->ID)); 
                                                                      
                                                                    $date_string = '';
                                                                    if($end_month == $start_month):
																		
                                                                        for ($currentDate = $Variable1; $currentDate <= $Variable2;  
                                                                            $currentDate += (86400)) { 
                                                                            if(!empty($date_string)):                            
                                                                            $date_string = $date_string .', '.date('d', $currentDate);
                                                                            else:
                                                                                 $date_string = date('d', $currentDate); 
                                                                            endif;
                                                                             
                                                                        } 
                                                                        $date_string = $date_string .' '.$end_month;
													
                                                                    elseif($end_month != $start_month):
																		
                                                                        for ($currentDate = $Variable1; $currentDate <= $Variable2;  
                                                                            $currentDate += (86400)) { 
                                                                           
                                                                            if(!empty($date_string)):                            
                                                                            $date_string = $date_string .', '.date('d F', $currentDate);
                                                                            else:
                                                                                 $date_string = date('d F', $currentDate); 
                                                                            endif;
                                                                        } 
                                                                        
                                                                    endif;
                                                                    
                                                                 echo  $date_string;
                                                                endif;
                                                         ?></span>
                                                    </div>
                                                    <div class="pl-2 col-12 col-lg-3 col-xl-3 col-sm-3 col-md-4 pl-3 text-md-center text-lg-left mt-sm-1">
                                                        <img alt="Placeholder image" class="mr-2 mb-1 horloge-icon" height="24" src="<?= get_field('time_icon') ?>">
                                                        <span style="font-size: 14px; line-height:15px; color: #3E4845; font-weight: 400"><?= get_field('minutes',  $event->ID )?></span>
                                                    </div>
                                                    <div class="pl-2 col-lg-4 col-12 offset-md-0 offset-sm-0 col-md-4 col-xl-4 mt-sm-1 text-md-center text-lg-left col-sm-4 pl-3">
                                                        <?php 

                                                    if(get_field('occurance_medium',$event->ID) == 'Online'):
                                                    ?>
                                                        <img alt="Placeholder image" class="mr-2 mb-1 picto-icon" height="22" src="<?= get_field('online_icon') ?>">
                                                        <span style="font-size: 14px; line-height:15px; color: #3E4845; font-weight: 400"><?= get_field('occurance_medium',$event->ID) ?></span>
                                                    <?php elseif(get_field('occurance_medium',$event->ID) == 'Location'):?>
                                                            <img alt="Placeholder image" class="mr-2 mb-1 picto-icon" height="22" src="<?= get_field('location_icon') ?>">
                                                        <span style="font-size: 14px; line-height:15px; color: #3E4845; font-weight: 400"><?= get_field('location_detail',$event->ID)?></span>
                                                    <?php endif;?>
                                                    </div>
                                                </div>
                                                <div class="row align-items-xl-end mt-4">
                                                   
                                                    <?php 

                                                    if(get_field('check_if_event_ends_on_different_date', $event->ID)){
                                                        $row_date = strtotime(get_field('occurance_end_date', $event->ID));
                                                    } else {
                                                        $row_date = strtotime(get_field('occurence_date', $event->ID));
                                                    }
                                                    
                                                    $today = strtotime(date('Y-m-d'));
														
                                                    if(get_field('webinar_link', $event->ID) && $row_date >= $today ):?>
													 <div class="col-sm-6 offset-xl-0 pl-sm-1 col-12 text-center text-sm-center text-lg-left col-xl-6 pl-lg-3"><a class="btn btn-primary pt-2 pb-2 taillebouton colorbutton" href="<?= get_permalink( $event->ID )?>" target="_blank"><?= get_field('read_more_button_text') ?> </a></div>
                                                        <div class="col-sm-6 col-12 text-center text-sm-center text-lg-left mt-3 mt-sm-0 col-xl-6"><a class="btn btn-primary pt-2 pb-2 taillebouton colorbutton" href="<?= get_field('webinar_link', $event->ID) ?>" target="_blank"><?= get_field('register_button_text') ?></a></div>
													<?php else:?>
														<div class="offset-xl-0 pl-sm-1 col-12 text-center text-sm-center text-lg-center pl-lg-3 col-xl-12 col-md-12 col-sm-12"><a class="btn btn-primary pt-2 pb-2 taillebouton colorbutton" href="<?= get_permalink( $event->ID )?>" target="_blank"><?= get_field('read_more_button_text') ?> </a></div>
                                                    <?php endif;?>
                                                </div>
                                            </div>

                                        </div>
                                        <hr class="text-center justify-content-xl-center align-self-xl-center post-hr" >
                                    <?php endforeach; ?>
                                   
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>
<!-- ==================================== -->

<?php get_footer(); ?>