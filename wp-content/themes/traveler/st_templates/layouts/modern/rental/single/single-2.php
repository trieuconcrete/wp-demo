<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 20-11-2018
     * Time: 8:08 AM
     * Since: 1.0.0
     * Updated: 1.0.0
     */
    while ( have_posts() ): the_post();
        $room_id  = get_the_ID();
        $post_id   = get_the_ID();
        $thumbnail = get_the_post_thumbnail_url( $room_id, 'full' );

        $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
        $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));


        $start           = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
        $end             = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
        $date            = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar)) ) );
        $room_num_search = (int)STInput::get( 'room_num_search', 1 );
        if ( $room_num_search <= 0 ) $room_num_search = 1;
        $start       = TravelHelper::convertDateFormat( $start );
        $end         = TravelHelper::convertDateFormat( $end );

        $orgin_price=STPrice::getRentalPriceOnlyCustomPrice(get_the_ID(), strtotime($start), strtotime($end));
        $price= STPrice::getSalePrice(get_the_ID(), strtotime($start), strtotime($end));


        $booking_period = (int)get_post_meta($room_id, 'rentals_booking_period', true);
        $location       = get_post_meta( $room_id, 'multi_location', true );
        if ( !empty( $location ) ) {
            $location = explode( ',', $location );
            if ( isset( $location[ 0 ] ) ) {
                $location = str_replace( '_', '', $location[ 0 ] );
            } else {
                $location = false;
            }
        }
        $address = get_post_meta($room_id, 'address', true);
        $marker_icon = st()->get_option('st_rental_icon_map_marker', '');

        $review_rate = STReview::get_avg_rate();

        $gallery       = get_post_meta( $room_id, 'gallery', true );
        $gallery_array = explode( ',', $gallery );

        $room_external = get_post_meta(get_the_ID(), 'st_rental_external_booking', true);
        $room_external_link = get_post_meta(get_the_ID(), 'st_rental_external_booking_link', true);
        $booking_type = st_get_booking_option_type();
        $number_day = STDate::dateDiff($start, $end);
        ?>
        <div id="st-content-wrapper">
            <?php st_breadcrumbs_new() ?>
            <div class="st-featured-background"
                 style="background-image: url('<?php echo esc_url( $thumbnail ) ?>')"></div>
            <div class="st-hotel-room-content">
                <div class="hotel-target-book-mobile">
                    <div class="price-wrapper">
                        <?php echo wp_kses( sprintf( __( 'from <span class="price">%s</span>', 'traveler' ), TravelHelper::format_money( $price ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
                    </div>
                    <?php
                    if($room_external == 'off' || empty($room_external)){
                        ?>
                        <a href=""
                           class="btn btn-mpopup btn-green"><?php echo esc_html__( 'Book Now', 'traveler' ) ?></a>
                        <?php
                    }else{
                        ?>
                        <a href="<?php echo esc_url($room_external_link); ?>"
                           class="btn btn-green"><?php echo esc_html__( 'Book Now', 'traveler' ) ?></a>
                        <?php
                    }
                    ?>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-9">
                            <div class="room-heading">
                                <div class="left">
                                    <h2 class="st-heading"><?php the_title(); ?></h2>
                                </div>
                                <div class="right">
                                    <div class="review-score style-2">
                                        <?php echo st()->load_template( 'layouts/modern/common/star', '', [ 'star' => $review_rate, 'style' => 'style-2' ] ); ?>
                                        <p class="st-link"><?php comments_number( __( 'from 0 review', 'traveler' ), __( 'from 1 review', 'traveler' ), __( 'from % reviews', 'traveler' ) ); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="st-hr large"></div>
                            <div class="room-featured-items">
                                <div class="row">
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_square_blue', '', '32px' ); ?>
                                            <?php echo sprintf( __( 'S: %s', 'traveler' ), get_post_meta( $room_id, 'rental_size', true ) ) ?>m<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_beds_blue', '', '32px' ); ?>
                                            <?php echo sprintf( __( 'Beds: %s', 'traveler' ), get_post_meta( $room_id, 'rental_bed', true ) ) ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_adults_blue', '', '32px' ); ?>
                                            <?php echo sprintf( __( 'Adults: %s', 'traveler' ), get_post_meta( $room_id, 'rental_max_adult', true ) ) ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_children_blue', '', '32px' ); ?>
                                            <?php echo sprintf( __( 'Children: %s', 'traveler' ), get_post_meta( $room_id, 'rental_max_children', true ) ) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                if ( !empty( $gallery_array ) ) { ?>
                                    <div class="st-gallery mt20" data-width="100%"
                                         data-nav="false" data-allowfullscreen="true">
                                        <div class="fotorama" data-auto="false">
                                            <?php
                                                foreach ( $gallery_array as $value ) {
                                                    ?>
                                                    <img src="<?php echo wp_get_attachment_image_url( $value, [ 870, 555 ] ) ?>">
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="shares dropdown">
                                            <?php
                                            $video_url = get_post_meta(get_the_ID(), 'video', true);
                                            if (!empty($video_url)) {
                                                ?>
                                                <a href="<?php echo esc_url($video_url); ?>"
                                                   class="st-video-popup share-item"><?php echo TravelHelper::getNewIcon('video-player', '#FFFFFF', '20px', '20px') ?></a>
                                                <?php
                                            } ?>
                                            <a href="#" class="share-item social-share">
                                                <?php echo TravelHelper::getNewIcon( 'ico_share', '', '20px', '20px' ) ?>
                                            </a>
                                            <ul class="share-wrapper">
                                                <li><a class="facebook"
                                                       href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                                       target="_blank" rel="noopener" original-title="Facebook"><i
                                                                class="fa fa-facebook fa-lg"></i></a></li>
                                                <li><a class="twitter"
                                                       href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                                       target="_blank" rel="noopener" original-title="Twitter"><i
                                                                class="fa fa-twitter fa-lg"></i></a></li>
                                                <li><a class="google"
                                                       href="https://plus.google.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                                       target="_blank" rel="noopener" original-title="Google+"><i
                                                                class="fa fa-google-plus fa-lg"></i></a></li>
                                                <li><a class="no-open pinterest"
                                                href="http://pinterest.com/pin/create/bookmarklet/?url=<?php the_permalink() ?>&is_video=false&description=<?php the_content() ?>&media=<?php echo get_the_post_thumbnail_url(get_the_ID())?>"
                                                       target="_blank" rel="noopener" original-title="Pinterest"><i
                                                                class="fa fa-pinterest fa-lg"></i></a></li>
                                                <li><a class="linkedin"
                                                       href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                                       target="_blank" rel="noopener" original-title="LinkedIn"><i
                                                                class="fa fa-linkedin fa-lg"></i></a></li>
                                            </ul>
                                            <?php echo st()->load_template( 'layouts/modern/hotel/loop/wishlist' ); ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                            <h2 class="st-heading-section"><?php echo __( 'Description', 'traveler' ) ?></h2>
                            <?php
                                global $post;
                                $content = $post->post_content;
                                $count   = str_word_count( $content );
                            ?>
                            <div class="st-description"
                                 data-toggle-section="st-description" <?php if ( $count >= 420 ) {
                                echo 'data-show-all="st-description"
                             data-height="420"';
                            } ?>>
                                <?php the_content(); ?>
                                <?php if ( $count >= 420 ) { ?>
                                    <div class="cut-gradient"></div>
                                <?php } ?>
                            </div>
                            <?php if ( $count >= 420 ) { ?>
                                <a href="#" class="st-link block" data-show-target="st-description"
                                   data-text-less="<?php echo esc_html__( 'View Less', 'traveler' ) ?>"
                                   data-text-more="<?php echo esc_html__( 'View More', 'traveler' ) ?>"><span
                                            class="text"><?php echo esc_html__( 'View More', 'traveler' ) ?></span><i
                                            class="fa fa-caret-down ml3"></i></a>
                            <?php } ?>
                            <div class="st-hr large"></div>
                            <?php
                                $all_attribute = TravelHelper::st_get_attribute_advance( 'st_rental');
                                foreach ($all_attribute as $key_attr => $attr) {
                                    if(!empty($attr["value"])){
                                        $get_label_tax = get_taxonomy($attr["value"]);
                                        ?>
                                        <?php
                                            if(!empty($get_label_tax)){
                                                echo '<h2 class="st-heading-section">'.esc_html($get_label_tax->label).'</h2>';
                                            }
                                        ?>
                                        <?php
                                            $facilities = get_the_terms( get_the_ID(), $attr["value"]);
                                            if ( $facilities ) {
                                                $count = count( $facilities );
                                                ?>
                                                <div class="facilities" data-toggle-section="st-<?php echo esc_attr($attr["value"]);?>"
                                                    <?php if ( $count > 6 ) echo 'data-show-all="st-'. esc_attr($attr["value"]) .'"
                                                 data-height="150"'; ?>
                                                    >
                                                    <div class="row">
                                                        <?php

                                                            foreach ( $facilities as $term ) {
                                                                $icon     = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon', true ) );
                                                                $icon_new = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon_new', true ) );
                                                                if ( !$icon ) $icon = "fa fa-cogs";
                                                                ?>
                                                                <div class="col-xs-6 col-sm-4">
                                                                    <div class="item has-matchHeight">
                                                                        <?php
                                                                            if ( !$icon_new ) {
                                                                                echo '<i class="' . esc_attr($icon) . '"></i>' . esc_html($term->name);
                                                                            } else {
                                                                                echo TravelHelper::getNewIcon( $icon_new, '#5E6D77', '24px', '24px' ) . esc_html($term->name);
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php if ( $count > 6 ) { ?>
                                                    <a href="#" class="st-link block" data-show-target="st-<?php echo esc_attr($attr["value"]);?>"
                                                       data-text-less="<?php echo esc_html__( 'Show Less', 'traveler' ) ?>"
                                                       data-text-more="<?php echo esc_html__( 'Show All', 'traveler' ) ?>"><span
                                                                class="text"><?php echo esc_html__( 'Show All', 'traveler' ) ?></span>
                                                        <i
                                                                class="fa fa-caret-down ml3"></i></a>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        <div class="st-hr large"></div>
                                    <?php }
                                }

                            ?>
                            <div class="st-hr large"></div>

                            <!--Map And Calendar-->
                            <div class="st-flex space-between">
                                <h2 class="st-heading-section mg0"><?php echo __( 'Availability', 'traveler' ) ?></h2>
                                <ul class="st-list st-list-availability">
                                    <li>
                                        <span class="not_available"></span><?php echo esc_html__( 'Not Available', 'traveler' ) ?>
                                    </li>
                                    <li>
                                        <span class="available"></span><?php echo esc_html__( 'Available', 'traveler' ) ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="st-house-availability st-availability">
                                <div class="st-calendar clearfix">
                                    <input type="text" class="calendar_input"
                                           data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                                           data-room-id="<?php echo esc_attr($room_id) ?>"
                                           data-action="st_get_availability_rental_single"
                                           value="" name="calendar_input">
                                </div>
                            </div>
                            <div class="st-hr large"></div>
                            <?php if ( $location ) {
                                    $lat  = get_post_meta( get_the_ID(), 'map_lat', true );
                                    $lng  = get_post_meta( get_the_ID(), 'map_lng', true );
                                    $zoom = get_post_meta( get_the_ID(), 'map_zoom_location', true );
                                    if(!$zoom){
                                        $zoom = 13;
                                    }
                                    ?>
                                    <div class="st-flex space-between">
                                        <h2 class="st-heading-section mg0"><?php echo __( 'Map', 'traveler' ) ?></h2>
                                        <?php if($address){
                                            ?>
                                            <div class="c-grey"><?php
                                                    echo TravelHelper::getNewIcon( 'Ico_maps', '#5E6D77', '18px', '18px' );
                                                    echo esc_html($address); ?></div>
                                            <?php
                                        } ?>
                                    </div>
                                    <?php
                                    $default = array(
                                        'number'      => '12' ,
                                        'range'       => '20' ,
                                        'show_circle' => 'no' ,
                                    );
                                    extract($default);
                                    $hotel = new STRental();
                                    $data  = $hotel->get_near_by( get_the_ID() , $range , $number );
                                    $location_center  = '[' . $lat . ',' . $lng . ']';
                                    $map_lat_center = $lat;
                                    $map_lng_center = $lng;

                                    $data_map = array();
                                    $stt  =  1;
                                    $map_icon = st()->get_option('st_rental_icon_map_marker', '');
                                    if (empty($map_icon)){
                                        $map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_rental.png';
                                    }

                                    $properties = $hotel->properties_near_by(get_the_ID(), $lat, $lng, $range);
                                    if( !empty($properties)){
                                        foreach($properties as $key => $val){
                                            $data_map[] = array(
                                                'id' => get_the_ID(),
                                                'name' => $val['name'],
                                                'post_type' => 'st_hotel',
                                                'lat' => (float)$val['lat'],
                                                'lng' => (float)$val['lng'],
                                                'icon_mk' => (empty($val['icon']))? 'http://maps.google.com/mapfiles/marker_black.png': $val['icon'],
                                                'content_html' => preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $val])),

                                            );
                                        }
                                    }
                                    $data_map_origin = array(
                                        'id' => $post_id,
                                        'post_id' => $post_id,
                                        'name' => get_the_title(),
                                        'description' => "",
                                        'lat' => (float)$lat,
                                        'lng' => (float)$lng,
                                        'icon_mk' => $map_icon,
                                        'featured' => get_the_post_thumbnail_url($post_id),
                                    );
                                    $data_map[] = array(
                                        'id' => $post_id,
                                        'name' => get_the_title(),
                                        'post_type' => 'st_hotel',
                                        'lat' =>(float) $lat,
                                        'lng' => (float)$lng,
                                        'icon_mk' => $map_icon,
                                        'content_html' => preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $data_map_origin])),

                                    );

                                    $data_map       = json_encode( $data_map , JSON_FORCE_OBJECT );
                                    ?>
                                    <?php $google_api_key = st()->get_option('st_googlemap_enabled');
                                    if ($google_api_key === 'on') { ?>
                                        <div class="st-map mt30">
                                            <div class="google-map gmap3" id="list_map"
                                                data-data_show='<?php echo str_ireplace(array("'"),'\"',$data_map) ;?>'
                                                data-lat="<?php echo trim($lat) ?>"
                                                data-lng="<?php echo trim($lng) ?>"
                                                data-icon="<?php echo esc_url($marker_icon); ?>"
                                                data-zoom="<?php echo (int)$zoom; ?>" data-disablecontrol="true"
                                                data-showcustomcontrol="true"
                                                data-style="normal">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="st-map-box mt30">
                                            <div class="google-map-mapbox" data-lat="<?php echo trim($lat) ?>"
                                                 data-lng="<?php echo trim($lng) ?>"
                                                 data-icon="<?php echo esc_url($marker_icon); ?>"
                                                 data-zoom="<?php echo (int)$zoom; ?>" data-disablecontrol="true"
                                                 data-showcustomcontrol="true"
                                                 data-style="normal">
                                                <div id="st-map">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                            <?php if(comments_open() and st()->get_option( 'rental_review' ) == 'on') {?>
                            <div class="st-hr"></div>
                            <!--End Map And Calendar-->

                            <div class="st-flex space-between">
                                <h2 class="st-heading-section"><?php echo esc_html__( 'Review', 'traveler' ); ?></h2>
                                <div class="f18 font-medium15">
                                    <span class="mr15"><?php comments_number( __( '0 review', 'traveler' ), __( '1 review', 'traveler' ), __( '% reviews', 'traveler' ) ); ?></span>
                                    <?php echo st()->load_template( 'layouts/modern/common/star', '', [ 'star' => $review_rate, 'style' => 'style-2', 'element' => 'span' ] ); ?>
                                </div>
                            </div>
                            <div id="reviews" class="hotel-room-review">
                                <div class="review-pagination">
                                    <div id="reviews" class="review-list">
                                        <?php
                                            $comments_count   = wp_count_comments( get_the_ID() );
                                            $total            = (int)$comments_count->approved;
                                            $comment_per_page = (int)get_option( 'comments_per_page', 10 );
                                            $paged            = (int)STInput::get( 'comment_page', 1 );
                                            $from             = $comment_per_page * ( $paged - 1 ) + 1;
                                            $to               = ( $paged * $comment_per_page < $total ) ? ( $paged * $comment_per_page ) : $total;
                                        ?>
                                        <?php
                                            $offset         = ( $paged - 1 ) * $comment_per_page;
                                            $args           = [
                                                'number'  => $comment_per_page,
                                                'offset'  => $offset,
                                                'post_id' => get_the_ID(),
                                                'status' => ['approve']
                                            ];
                                            $comments_query = new WP_Comment_Query;
                                            $comments       = $comments_query->query( $args );

                                            if ( $comments ):
                                                foreach ( $comments as $key => $comment ):
                                                    echo st()->load_template( 'layouts/modern/common/reviews/review', 'list', [ 'comment' => (object)$comment ] );
                                                endforeach;
                                            endif;
                                        ?>
                                    </div>
                                </div>
                                <?php TravelHelper::pagination_comment( [ 'total' => $total ] ) ?>
                                <?php
                                    if ( comments_open( $room_id ) ) {
                                        ?>
                                        <div id="write-review">
                                            <h4 class="heading">
                                                <a href="" class="toggle-section c-main f16"
                                                   data-target="st-review-form"><?php echo __( 'Write a review', 'traveler' ) ?>
                                                    <i class="fa fa-angle-down ml5"></i></a>
                                            </h4>
                                            <?php
                                                TravelHelper::comment_form();
                                            ?>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                            <?php }?>
                            <div class="stoped-scroll-section"></div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="widgets">
                                <div class="fixed-on-mobile" data-screen="992px">
                                    <div class="close-icon hide">
                                        <?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?>
                                    </div>

                                    <?php
                                        if($booking_type == 'instant_enquire'){
                                            ?>
                                            <div class="form-book-wrapper">
                                                <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                                <div class="form-head">
                                                    <?php
                                                    if (isset($number_day) && $number_day > 1)
                                                        echo wp_kses( sprintf( __( 'from <span class="price">%s</span> per %s nights', 'traveler' ), TravelHelper::format_money($price), $number_day ), [ 'span' => [ 'class' => [] ] ] );
                                                    else
                                                        echo wp_kses( sprintf( __( 'from <span class="price">%s</span> per night', 'traveler' ), TravelHelper::format_money($price) ), [ 'span' => [ 'class' => [] ] ] );
                                                    ?>
                                                </div>
                                                <?php if(empty($room_external) || $room_external == 'off'){ ?>
                                                    <nav>
                                                        <ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
                                                            <li class="active"><a id="nav-book-tab" data-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
                                                            <li><a id="nav-inquirement-tab" data-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
                                                        </ul>
                                                    </nav>
                                                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                        <div class="tab-pane fade in active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
                                                            <form id="form-booking-inpage single-room-form" class="form single-room-form rental-booking-form" method="post">
                                                                <input name="action" value="rental_add_cart" type="hidden">
                                                                <input name="item_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                                                                <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                                                                <?php
                                                                $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                                                $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

                                                                $start    = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                                                                $end      = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                                                $date     = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar)) ) );
                                                                $has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
                                                                ?>
                                                                <div class="form-group form-date-field date-enquire form-date-hotel-room clearfix <?php if ( $has_icon ) echo ' has-icon '; ?>"
                                                                     data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                                                                    <?php
                                                                    if ( $has_icon ) {
                                                                        echo '<i class="field-icon fa fa-calendar"></i>';
                                                                    }
                                                                    ?>
                                                                    <div class="date-wrapper clearfix">
                                                                        <div class="check-in-wrapper">
                                                                            <ul class="st_grid_date">
                                                                                <li>
                                                                                    <div class="st-item-date">
                                                                                        <label><?php echo __('Check In', 'traveler'); ?></label>
                                                                                        <div class="render check-in-render"><?php echo esc_attr($start); ?></div>
                                                                                    </div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="st-item-date">
                                                                                        <label><?php echo __('Check Out', 'traveler'); ?></label>
                                                                                        </span><div class="render check-out-render"><?php echo esc_html($end); ?></div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" class="check-in-input"
                                                                           value="<?php echo esc_attr( $start ) ?>" name="start">
                                                                    <input type="hidden" class="check-out-input"
                                                                           value="<?php echo esc_attr( $end ) ?>" name="end">
                                                                    <input type="text" class="check-in-out"
                                                                           data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                                                                           data-room-id="<?php echo esc_attr($room_id) ?>"
                                                                           data-action="st_get_availability_rental_single"
                                                                           value="<?php echo esc_attr( $date ); ?>" name="date">
                                                                </div>
                                                                <?php
                                                                $has_icon        = ( isset( $has_icon ) ) ? $has_icon : false;
                                                                $adult_number    = STInput::get( 'adult_number', 1 );
                                                                $child_number    = STInput::get( 'child_number', 0 );
                                                                ?>
                                                                <div class="form-group form-extra-field dropdown clearfix field-guest <?php if ( $has_icon ) echo ' has-icon '; ?>">
                                                                    <?php
                                                                    if ( $has_icon ) {
                                                                        echo TravelHelper::getNewIcon( 'ico_guest_search_box' );
                                                                    }
                                                                    ?>
                                                                    <div class="dropdown" data-toggle="dropdown" id="dropdown-1">
                                                                        <label><?php echo __( 'Guests', 'traveler' ); ?></label>
                                                                        <div class="render">
                                                                            <span class="adult" data-text="<?php echo __( 'Adult', 'traveler' ); ?>" data-text-multi="<?php echo __( 'Adults', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Adult', '%s Adults', esc_attr($adult_number), 'traveler' ), esc_attr($adult_number) ) ?></span>
                                                                            -
                                                                            <span class="children" data-text="<?php echo __( 'Child', 'traveler' ); ?>"
                                                                                  data-text-multi="<?php echo __( 'Children', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Child', '%s Children', esc_attr($child_number), 'traveler' ), esc_attr($child_number) ); ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdown-1">
                                                                        <li class="item">
                                                                            <label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
                                                                            <div class="select-wrapper">
                                                                                <div class="st-number-wrapper">
                                                                                    <input type="text" name="adult_number" value="<?php echo esc_attr($adult_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="<?php echo (int)get_post_meta($room_id, 'rental_max_adult', true) ?>"/>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="item">
                                                                            <label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
                                                                            <div class="select-wrapper">
                                                                                <div class="st-number-wrapper">
                                                                                    <input type="text" name="child_number" value="<?php echo esc_attr($child_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="<?php echo (int)get_post_meta($room_id, 'rental_max_children', true) ?>"/>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <span class="hidden-lg hidden-md hidden-sm btn-close-guest-form"><?php echo __('Close', 'traveler'); ?></span>
                                                                    </ul>
                                                                    <i class="fa fa-angle-down arrow"></i>
                                                                </div>
                                                                <?php echo st()->load_template( 'layouts/modern/rental/elements/search/extra', '' ); ?>
                                                                <div class="submit-group">
                                                                    <button class="btn btn-green btn-large btn-full upper font-medium btn_hotel_booking btn-book-ajax"
                                                                           type="submit"
                                                                           name="submit">
                                                                        <?php echo __( 'Book Now', 'traveler' ) ?>
                                                                        <i class="fa fa-spinner fa-spin hide"></i>
                                                                    </button>
                                                                    <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                                                                </div>
                                                                <div class="mt30 message-wrapper">
                                                                    <?php echo STTemplate::message() ?>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
                                                            <?php echo st()->load_template( 'email/email_single_service' ); ?>
                                                        </div>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="submit-group mb30">
                                                        <a href="<?php echo esc_url($room_external_link); ?>" class="btn btn-green btn-large btn-full upper"><?php echo esc_html__( 'Book Now', 'traveler' ); ?></a>
                                                        <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }else{
                                            if($booking_type == 'enquire'){
                                                ?>
                                                <div class="form-book-wrapper">
                                                    <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                                    <div class="form-head">
                                                        <?php
                                                        if (isset($number_day) && $number_day > 1)
                                                            echo wp_kses( sprintf( __( 'from <span class="price">%s</span> per %s nights', 'traveler' ), TravelHelper::format_money($price), $number_day ), [ 'span' => [ 'class' => [] ] ] );
                                                        else
                                                            echo wp_kses( sprintf( __( 'from <span class="price">%s</span> per night', 'traveler' ), TravelHelper::format_money($price) ), [ 'span' => [ 'class' => [] ] ] );
                                                        ?>
                                                    </div>
                                                    <h4 class="title-enquiry-form"><?php echo esc_html__('Inquiry', 'traveler'); ?></h4>
                                                    <?php echo st()->load_template( 'email/email_single_service' ); ?>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="form-book-wrapper">
                                                    <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                                    <div class="form-head">
                                                        <?php
                                                        if (isset($number_day) && $number_day > 1)
                                                            echo wp_kses( sprintf( __( 'from <span class="price">%s</span> per %s nights', 'traveler' ), TravelHelper::format_money($price), $number_day ), [ 'span' => [ 'class' => [] ] ] );
                                                        else
                                                            echo wp_kses( sprintf( __( 'from <span class="price">%s</span> per night', 'traveler' ), TravelHelper::format_money($price) ), [ 'span' => [ 'class' => [] ] ] );
                                                        ?>
                                                    </div>
                                                    <?php if(empty($room_external) || $room_external == 'off'){ ?>
                                                        <form id="form-booking-inpage single-room-form" class="form single-room-form rental-booking-form" method="post">
                                                            <input name="action" value="rental_add_cart" type="hidden">
                                                            <input name="item_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                                                            <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                                                            <?php
                                                            $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                                            $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

                                                            $start    = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                                                            $end      = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                                            $date     = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar)) ) );
                                                            $has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
                                                            ?>
                                                            <div class="form-group form-date-field form-date-hotel-room clearfix <?php if ( $has_icon ) echo ' has-icon '; ?>"
                                                                 data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                                                                <?php
                                                                if ( $has_icon ) {
                                                                    echo '<i class="field-icon fa fa-calendar"></i>';
                                                                }
                                                                ?>
                                                                <div class="date-wrapper clearfix">
                                                                    <div class="check-in-wrapper">
                                                                        <label><?php echo __( 'Check In - Out', 'traveler' ); ?></label>
                                                                        <div class="render check-in-render"><?php echo esc_attr($start); ?></div> - <div class="render check-out-render"><?php echo esc_html($end); ?></div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" class="check-in-input"
                                                                       value="<?php echo esc_attr( $start ) ?>" name="start">
                                                                <input type="hidden" class="check-out-input"
                                                                       value="<?php echo esc_attr( $end ) ?>" name="end">
                                                                <input type="text" class="check-in-out"
                                                                       data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                                                                       data-room-id="<?php echo esc_attr($room_id) ?>"
                                                                       data-action="st_get_availability_rental_single"
                                                                       value="<?php echo esc_attr( $date ); ?>" name="date">
                                                            </div>
                                                            <?php
                                                            $has_icon        = ( isset( $has_icon ) ) ? $has_icon : false;
                                                            $adult_number    = STInput::get( 'adult_number', 1 );
                                                            $child_number    = STInput::get( 'child_number', 0 );
                                                            ?>
                                                            <div class="form-group form-extra-field dropdown clearfix field-guest <?php if ( $has_icon ) echo ' has-icon '; ?>">
                                                                <?php
                                                                if ( $has_icon ) {
                                                                    echo TravelHelper::getNewIcon( 'ico_guest_search_box' );
                                                                }
                                                                ?>
                                                                <div class="dropdown" data-toggle="dropdown" id="dropdown-1">
                                                                    <label><?php echo __( 'Guests', 'traveler' ); ?></label>
                                                                    <div class="render">
                                                                        <span class="adult" data-text="<?php echo __( 'Adult', 'traveler' ); ?>" data-text-multi="<?php echo __( 'Adults', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Adult', '%s Adults', esc_attr($adult_number), 'traveler' ), esc_attr($adult_number) ) ?></span>
                                                                        -
                                                                        <span class="children" data-text="<?php echo __( 'Child', 'traveler' ); ?>"
                                                                              data-text-multi="<?php echo __( 'Children', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Child', '%s Children', esc_attr($child_number), 'traveler' ), esc_attr($child_number) ); ?></span>
                                                                    </div>
                                                                </div>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdown-1">
                                                                    <li class="item">
                                                                        <label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
                                                                        <div class="select-wrapper">
                                                                            <div class="st-number-wrapper">
                                                                                <input type="text" name="adult_number" value="<?php echo esc_attr($adult_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="<?php echo (int)get_post_meta($room_id, 'rental_max_adult', true) ?>"/>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li class="item">
                                                                        <label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
                                                                        <div class="select-wrapper">
                                                                            <div class="st-number-wrapper">
                                                                                <input type="text" name="child_number" value="<?php echo esc_attr($child_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="<?php echo (int)get_post_meta($room_id, 'rental_max_children', true) ?>"/>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <span class="hidden-lg hidden-md hidden-sm btn-close-guest-form"><?php echo __('Close', 'traveler'); ?></span>
                                                                </ul>
                                                                <i class="fa fa-angle-down arrow"></i>
                                                            </div>
                                                            <?php echo st()->load_template( 'layouts/modern/rental/elements/search/extra', '' ); ?>
                                                            <div class="submit-group">
                                                                <button class="btn btn-green btn-large btn-full upper font-medium btn_hotel_booking btn-book-ajax"
                                                                       type="submit"
                                                                       name="submit">
                                                                    <?php echo __( 'Book Now', 'traveler' ) ?>
                                                                    <i class="fa fa-spinner fa-spin hide"></i>
                                                                </button>
                                                                <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                                                            </div>
                                                            <div class="mt30 message-wrapper">
                                                                <?php echo STTemplate::message() ?>
                                                            </div>
                                                        </form>
                                                    <?php }else{ ?>
                                                        <div class="submit-group mb30">
                                                            <a href="<?php echo esc_url($room_external_link); ?>" class="btn btn-green btn-large btn-full upper"><?php echo esc_html__( 'Book Now', 'traveler' ); ?></a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                    ?>

                                    <div class="owner-info widget-box">
                                        <h4 class="heading"><?php echo __( 'Owner', 'traveler' ) ?></h4>
                                        <div class="media">
                                            <div class="media-left">
                                                <?php
                                                $author_id = get_post_field( 'post_author', get_the_ID() );
                                                $userdata  = get_userdata( $author_id );
                                                ?>
                                                <a href="<?php echo get_author_posts_url($author_id); ?>">
                                                    <?php
                                                    echo st_get_profile_avatar( $author_id, 60 );
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="<?php echo get_author_posts_url($author_id); ?>" class="author-link"><?php echo TravelHelper::get_username( $author_id ); ?></a></h4>
                                                <p><?php echo sprintf( __( 'Member Since %s', 'traveler' ), date( 'Y', strtotime( $userdata->user_registered ) ) ) ?></p>
                                            </div>
                                            <?php
                                                $enable_inbox = st()->get_option('enable_inbox');
                                                if($enable_inbox === 'on'){ ?>
                                                    <div class="st_ask_question">
                                                        <?php
                                                            if (!is_user_logged_in()) {?>
                                                            <a href="" class="login btn btn-primary upper mt5" data-toggle="modal" data-target="#st-login-form"><?php echo __('Ask a Question', 'traveler');?></a>
                                                        <?php } else{?>
                                                            <a href="" id="btn-send-message-owner" class="btn-send-message-owner btn btn-primary upper mt5" data-id="<?php echo get_the_ID();?>"><?php echo __('Ask a Question', 'traveler');?></a>
                                                        <?php }?>
                                                    </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endwhile;
