    <?php

        use Gostudy_Theme_Helper as Gostudy;

        $tutor_archive_layout = Gostudy_Theme_Helper::get_mb_option('tutor_archive_layout');
        $tutor_see_more_text = Gostudy_Theme_Helper::get_mb_option('tutor_see_more_text');
        $tutor_archive_hide_media = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_media');
        $tutor_archive_hide_categories = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_categories');
        $tutor_archive_hide_categories_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_categories_popup');
        $tutor_archive_hide_price = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_price');
        $tutor_archive_hide_price_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_price_popup');
        $tutor_archive_hide_title = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_title');
        $tutor_archive_hide_title_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_title_popup');
        $tutor_archive_hide_created_by = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_created_by');
        $tutor_archive_hide_created_by_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_created_by_popup');
        $tutor_archive_hide_lessons = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_lessons');
        $tutor_archive_hide_lessons_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_lessons_popup');
        $tutor_archive_hide_lessons_text = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_lessons_text');
        $tutor_archive_hide_lessons_text_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_lessons_text_popup');
        $tutor_archive_hide_duration = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_duration');
        $tutor_archive_hide_duration_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_duration_popup');
        // $tutor_archive_hide_topic_text = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_topic_text');
        // $tutor_archive_hide_topic_text_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_topic_text_popup');
        $tutor_archive_hide_preview_btn = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_preview_btn');
        $tutor_archive_hide_enroll_btn = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_enroll_btn');
        $tutor_enroll_now_text = Gostudy_Theme_Helper::get_mb_option('tutor_enroll_now_text');
        $tutor_archive_enroll_btn_switch = Gostudy_Theme_Helper::get_mb_option('tutor_archive_enroll_btn_switch');
        $tutor_archive_hide_excerpt_content = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_excerpt_content');
        $tutor_archive_hide_excerpt_content_popup = Gostudy_Theme_Helper::get_mb_option('tutor_archive_hide_excerpt_content_popup');
        $tutor_free_text = Gostudy_Theme_Helper::get_mb_option('tutor_free_text');
        $tutor_enrolled_text = Gostudy_Theme_Helper::get_mb_option('tutor_enrolled_text');
        $tutor_completed_text = Gostudy_Theme_Helper::get_mb_option('tutor_completed_text');

        $tutor_tf_hover_popup_type = Gostudy_Theme_Helper::get_mb_option('tutor_tf_hover_popup_type');
    ?>

        <article class="rt-course layout-<?php echo esc_attr($tutor_archive_layout); ?>">
         <div class="course__container">
            <div class="course__media">

                <!-- ** Media **-->
              <a href="<?php the_permalink(); ?>"> <?php get_tutor_course_thumbnail(); ?> </a>

                <!-- ** Category **-->

                <?php  
                        $postID = get_post()->ID;
                        $tax_html = '';
                        $terms = get_the_terms($postID, 'course-category');
                        if (!empty($terms) && !is_wp_error($terms)) {
                            foreach ($terms as $cat) {
                                $tax_html .= '<a href="' . get_term_link($cat, $cat->taxonomy) . '" rel="tag">' . $cat->name . '</a>';
                            }
                        }

                        if (!$tax_html) {
                            //* Bailout, if nothing to render
                            return;
                        }

                        printf('<div class="course__categories ">%s</div>', $tax_html); 
                ?>
                <!-- ** Wishlist **-->

                <div class="tutor-course-bookmark">
                    <?php
                        $course_id = get_the_ID();
                        $is_wish_listed = tutor_utils()->is_wishlisted( $course_id );
                        
                        $action_class = '';
                        if ( is_user_logged_in() ) {
                            $action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
                        } else {
                            $action_class = apply_filters('tutor_popup_login_class', 'tutor-open-login-modal');
                        }
                        
                        echo '<a href="javascript:;" class="'. esc_attr( $action_class ) .' save-bookmark-btn tutor-iconic-btn tutor-iconic-btn-secondary" data-course-id="'. esc_attr( $course_id ) .'">
                            <i class="' . ( $is_wish_listed ? 'tutor-icon-bookmark-bold' : 'tutor-icon-bookmark-line') . '"></i>
                        </a>';
                    ?>
                </div>

            </div>
            <div class="course__content">
               <div class="course__content--info">

                    <!-- ** Author **-->
                    <?php 
                        global $post, $authordata;
                        $profile_url = tutor_utils()->profile_url($authordata->ID, true);
                        $disable_course_author = get_tutor_option('disable_course_author'); 
                    ?>

                    <?php if ( !$disable_course_author){ ?>

                        <div class="rt-course-author-name">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
                            <a href="<?php echo esc_url($profile_url) ?>"><?php echo get_the_author(); ?></a>
                        </div>
                    <?php }  ?>
                    <!-- ** Title **-->
                  <h4 class="course__title"><a class="course__media-link" href="<?php the_permalink(); ?>"><?php the_title(); ?>
                  </a>
                  </h4>

                <!-- ** Course Review **-->
                  <?php
                        $disable_course_review = get_tutor_option('disable_course_review');

                        if( !$disable_course_review){ 

                            $course_rating = tutor_utils()->get_course_rating();
                            tutor_utils()->star_rating_generator($course_rating->rating_avg);
                        }
                  ?>
           
               </div>
            <!-- ** Course total **-->
               <div class="course__content--meta">
                <?php
                    $disable_total_enrolled = get_tutor_option('disable_course_total_enrolled');
                    if( !$disable_total_enrolled){ ?>
                        <span class="course-enroll"><i class="flaticon-user-2"></i> <?php echo (int) tutor_utils()->count_enrolled_users_by_course(); ?></span>
                    <?php } 
                ?>

            <!-- ** price 2 **-->
                <?php 
                    //ob_start();
                    get_template_part('templates/tutor/price_within_button_2');
                    //$button = ob_get_clean();
                ?>
               </div>
            </div>
         </div>
        </article>