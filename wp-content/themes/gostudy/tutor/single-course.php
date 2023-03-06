<?php
/**
 * Template for displaying single course
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

get_header();

// Prepare the nav items
$course_id          = get_the_ID();
$course_nav_item    = apply_filters( 'tutor_course/single/nav_items', tutor_utils()->course_nav_items(), $course_id );
$is_public          = \TUTOR\Course_List::is_public( $course_id );
$is_mobile          = wp_is_mobile();

$enrollment_box_position            = tutor_utils()->get_option( 'enrollment_box_position_in_mobile', 'bottom' );
if ( '-1' === $enrollment_box_position ) {
    $enrollment_box_position = 'bottom';
}
$student_must_login_to_view_course  = tutor_utils()->get_option( 'student_must_login_to_view_course' );

tutor_utils()->tutor_custom_header();

if ( ! is_user_logged_in() && ! $is_public && $student_must_login_to_view_course ) {
    tutor_load_template( 'login' );
    tutor_utils()->tutor_custom_footer();
    return;
}

?>

<?php do_action('tutor_course/single/before/wrap'); ?>

<div <?php tutor_post_class('tutor-full-width-course-top tutor-course-top-info tutor-page-wrap'); ?>>
    <div class="rt-container rt-tutor-container">
        <div class="row">
            
            <div class="rt_col-8 tutor-col-md-100 gostudy-col-space">

	            <?php do_action('tutor_course/single/before/inner-wrap'); ?>
                <?php if ( $is_mobile && 'top' === $enrollment_box_position ): ?>
                    <div class="tutor-mt-32">
                        <?php tutor_load_template( 'single.course.course-entry-box' ); ?>
                    </div>
                <?php endif; ?>

                <div class="tutor-course-details-tab tutor-mt-32">
                    <?php if ( is_array( $course_nav_item ) && count( $course_nav_item ) > 1 ) : ?>
                        <div class="tutor-is-sticky">
                            <?php tutor_load_template( 'single.course.enrolled.nav', array('course_nav_item' => $course_nav_item ) ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="tutor-tab tutor-pt-24">
                        <?php foreach( $course_nav_item as $key => $subpage ) : ?>
                            <div id="tutor-course-details-tab-<?php echo esc_attr($key); ?>" class="tutor-tab-item<?php echo esc_attr($key) == 'info' ? ' is-active' : ''; ?>">
                                <?php
                                    do_action( 'tutor_course/single/tab/'.$key.'/before' );
                                    
                                    $method = $subpage['method'];
                                    if ( is_string($method) ) {
                                        $method();
                                    } else {
                                        $_object = $method[0];
                                        $_method = $method[1];
                                        $_object->$_method(get_the_ID());
                                    }

                                    do_action( 'tutor_course/single/tab/'.$key.'/after' );
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

	            <?php do_action('tutor_course/single/after/inner-wrap'); ?>
            </div> <!-- .tutor-col-8 -->

            <?php  
                $tutor_single_sidebar_sticky = Gostudy_Theme_Helper::get_mb_option('tutor_single_sidebar_sticky');
                if ($tutor_single_sidebar_sticky) {
                    wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js');
                    $sidebar_class = ' sticky-sidebar';
                    $sb_data['class'] = $sidebar_class ?? '';
                }

            ?>
            <div class="rt_col-4 <?php if($tutor_single_sidebar_sticky == '1') : echo esc_attr( $sidebar_class ); endif; ?>">
                <div class="tutor-single-course-sidebar">
                    <?php do_action('tutor_course/single/before/sidebar'); ?>
                    <div class="tutor-price-preview-box">
                        <?php tutor_load_template('single.course.course-entry-box'); ?>
                        <?php tutor_course_requirements_html(); ?>
                        <?php tutor_course_tags_html(); ?>
                        <?php tutor_course_target_audience_html(); ?>
                    </div>
                    <?php do_action('tutor_course/single/after/sidebar'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php do_action('tutor_course/single/after/wrap'); ?>

<?php
tutor_utils()->tutor_custom_footer();
