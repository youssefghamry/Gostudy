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

    <?php 

        if ($tutor_archive_layout == '1'): 
            get_template_part('tutor/loop/gostudy_course_1');

        elseif($tutor_archive_layout == '2') :
            get_template_part('tutor/loop/gostudy_course_2');

        elseif($tutor_archive_layout == '3') : 
            get_template_part('tutor/loop/gostudy_course_3');

       elseif($tutor_archive_layout == 'default_plugin_style') : 

            do_action('tutor_course/loop/before_content');

            do_action('tutor_course/loop/badge');


            do_action('tutor_course/loop/before_header');
            do_action('tutor_course/loop/header');
            do_action('tutor_course/loop/after_header');


            do_action('tutor_course/loop/start_content_wrap');

            do_action('tutor_course/loop/before_rating');
            do_action('tutor_course/loop/rating');
            do_action('tutor_course/loop/after_rating');

            do_action('tutor_course/loop/before_title');
            do_action('tutor_course/loop/title');
            do_action('tutor_course/loop/after_title');

            do_action('tutor_course/loop/before_meta');
            do_action('tutor_course/loop/meta');
            do_action('tutor_course/loop/after_meta');

            do_action('tutor_course/loop/before_excerpt');
            do_action('tutor_course/loop/excerpt');
            do_action('tutor_course/loop/after_excerpt');

            do_action('tutor_course/loop/end_content_wrap');
            do_action('tutor_course/loop/tutor_pagination');

            /**
             * Hooks for enrolled course progress
             * That will affected on dashboard enrolled course page
             *
             * @since v2.0.0
             */
            do_action('tutor_course/loop/before_enrolled_progress');
            do_action('tutor_course/loop/enrolled_course_progress');
            do_action('tutor_course/loop/after_enrolled_progress');

            do_action('tutor_course/loop/before_footer');
            do_action('tutor_course/loop/footer');
            do_action('tutor_course/loop/after_footer');

            do_action('tutor_course/loop/after_content');


        endif; ?>

