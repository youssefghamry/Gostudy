<?php
	// Utility data
	$is_enrolled           = apply_filters( 'tutor_alter_enroll_status', tutor_utils()->is_enrolled() );
	$lesson_url            = tutor_utils()->get_course_first_lesson();
	$is_privileged_user    = tutor_utils()->has_user_course_content_access();
	$tutor_course_sell_by  = apply_filters( 'tutor_course_sell_by', null );
	$is_public             = get_post_meta( get_the_ID(), '_tutor_is_public_course', true ) == 'yes';

	// Monetization info
	$monetize_by              = tutor_utils()->get_option( 'monetize_by' );
	$is_purchasable           = tutor_utils()->is_course_purchasable();

	// Get login url if
	$is_tutor_login_disabled = ! tutor_utils()->get_option( 'enable_tutor_native_login', null, true, true );
	$auth_url                = $is_tutor_login_disabled ? ( isset(  $wp->request  ) ? wp_login_url( $wp->request['REQUEST_SCHEME'] . '://' . $wp->request['HTTP_HOST'] . $wp->request['REQUEST_URI'] ) : '' ) : '';
	$default_meta = array(
		array(
			'icon_class' => 'tutor-icon-mortarboard',
			'label'      => __( 'Total Enrolled', 'gostudy' ),
			'value'      => tutor_utils()->get_option( 'enable_course_total_enrolled' ) ? tutor_utils()->count_enrolled_users_by_course() . ' ' . __("Total Enrolled", "tutor") : null,
		),
		array(
			'icon_class' => 'tutor-icon-clock-line',
			'label'      => __( 'Duration', 'gostudy' ),
			'value'      => get_tutor_option( 'enable_course_duration' ) ? ( get_tutor_course_duration_context() ? get_tutor_course_duration_context() . ' ' . __("Duration", "tutor") : false ) : null,
		),
		array(
			'icon_class' => 'tutor-icon-refresh-o',
			'label'      => __( 'Last Updated', 'gostudy' ),
			'value'      => get_tutor_option( 'enable_course_update_date' ) ? get_the_modified_date( get_option( 'date_format' ) ) . ' ' . __("Last Updated", "tutor") : null,
		),
	);

	// Add level if enabled
	if(tutor_utils()->get_option('enable_course_level', true, true)) {
		array_unshift($default_meta, array(
			'icon_class' => 'tutor-icon-level',
			'label'      => __( 'Level', 'gostudy' ),
			'value'      => get_tutor_course_level( get_the_ID() ),
		));
	}

	// Right sidebar meta data
	$sidebar_meta = apply_filters('tutor/course/single/sidebar/metadata', $default_meta, get_the_ID() );
	$login_url = tutor_utils()->get_option( 'enable_tutor_native_login', null, true, true ) ? '' : wp_login_url( tutor()->current_url );
?>
<div class="media-preview">
	<div class="rt-video_popup with_image">
		<div class="videobox_content">

			<div class="videobox_background">
				<?php 
					$tutor_course_img = get_tutor_course_thumbnail_src();
					$placeholder_img = tutor()->url . 'assets/images/placeholder.svg';
				?>
				 <img class="tutor-card-image-top" src="<?php echo empty(esc_url($tutor_course_img)) ? $placeholder_img : esc_url($tutor_course_img) ?>" alt="<?php the_title(); ?>" loading="lazy">

			</div>
			<?php  

	       $video = maybe_unserialize( get_post_meta( get_the_ID(), '_video', true ) );
	        $videoSource    = tutor_utils()->avalue_dot( 'source', $video );

	        if ($video["source_youtube"] && $videoSource == 'youtube') {
	            $tutor_intro_video =    $video["source_youtube"];
	        }
	        elseif($video["source_vimeo"] && $videoSource == 'vimeo'){
	            $tutor_intro_video =    $video["source_vimeo"];
	        }
	        elseif($video["source_external_url"] && $videoSource == 'external_url'){
	            $tutor_intro_video =    $video["source_external_url"];
	        }
	        else{
	            $tutor_intro_video =    '';
	        }
	        
			if (class_exists('RWMB_Loader') && !empty($tutor_intro_video)) { ?>
			<div class="videobox_link_wrapper">

				<div class="videobox_link " data-lity="" href="<?php echo esc_url( $tutor_intro_video ); ?>">
					<svg class="videobox_icon" width="33%" height="33%" viewBox="0 0 232 232"><path d="M203,99L49,2.3c-4.5-2.7-10.2-2.2-14.5-2.2 c-17.1,0-17,13-17,16.6v199c0,2.8-0.07,16.6,17,16.6c4.3,0,10,0.4,14.5-2.2 l154-97c12.7-7.5,10.5-16.5,10.5-16.5S216,107,204,100z"></path>
					</svg>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>



		<?php
		if ( $is_enrolled || $is_privileged_user) {
			ob_start();

			// Course Info
			$completed_percent   = tutor_utils()->get_course_completed_percent();
			$is_completed_course = tutor_utils()->is_completed_course();
			$retake_course       = tutor_utils()->can_user_retake_course();
			$course_id           = get_the_ID();
			$course_progress     = tutor_utils()->get_course_completed_percent( $course_id, 0, true );
			?>
			<!-- course progress -->
			<?php if ( tutor_utils()->get_option('enable_course_progress_bar', true, true) && is_array( $course_progress ) && count( $course_progress ) ) : ?>
				<div class="tutor-course-progress-wrapper tutor-mb-32">
					<h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">
						<?php esc_html_e( 'Course Progress', 'gostudy' ); ?>
					</h3>
					<div class="list-item-progress">
						<div class="tutor-fs-6 tutor-color-secondary tutor-d-flex tutor-align-center tutor-justify-between">
							<span class="progress-steps">
								<?php echo esc_html( $course_progress['completed_count'] ); ?>/<?php echo esc_html( $course_progress['total_count'] ); ?>
							</span>
							<span class="progress-percentage">
								<?php echo esc_html( $course_progress['completed_percent'] . '%' ); ?>
								<?php esc_html_e( 'Complete', 'gostudy' ); ?>
							</span>
						</div>
						<div class="tutor-progress-bar tutor-mt-12" style="--tutor-progress-value:<?php echo esc_attr( $course_progress['completed_percent'] ); ?>%;">
							<span class="tutor-progress-value" area-hidden="true"></span>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php
			$start_content = '';

			// The user is enrolled anyway. No matter manual, free, purchased, woocommerce, edd, membership
			do_action( 'tutor_course/single/actions_btn_group/before' );

			// Show Start/Continue/Retake Button
			if ( $lesson_url ) {
				$button_class = 'tutor-btn ' .
								( $retake_course ? 'tutor-btn-outline-primary' : 'tutor-btn-primary' ) .
								' tutor-btn-block' .
								( $retake_course ? ' tutor-course-retake-button' : '' );

				// Button identifier class
				$button_identifier = 'start-continue-retake-button';
				$tag               = $retake_course ? 'button' : 'a';
				ob_start();
				?>
					<<?php echo esc_attr($tag); ?> <?php echo esc_attr($retake_course) ? 'disabled="disabled"' : ''; ?> href="<?php echo esc_url( $lesson_url ); ?>" class="<?php echo esc_attr( $button_class . ' ' . $button_identifier ); ?>" data-course_id="<?php echo esc_attr( get_the_ID() ); ?>">
					<?php
					if ( $retake_course ) {
						esc_html_e( 'Retake This Course', 'gostudy' );
					} elseif ( $completed_percent <= 0 ) {
						esc_html_e( 'Start Learning', 'gostudy' );
					} else {
						esc_html_e( 'Continue Learning', 'gostudy' );
					}
					?>
					</<?php echo esc_attr($tag); ?>>
					<?php
					$start_content = ob_get_clean();
			}
			echo apply_filters( 'tutor_course/single/start/button', $start_content, get_the_ID() );

			// Show Course Completion Button.
			if ( ! $is_completed_course ) {
				ob_start();
				?>
				<form method="post" class="tutor-mt-20">
					<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>

					<input type="hidden" value="<?php echo esc_attr( get_the_ID() ); ?>" name="course_id"/>
					<input type="hidden" value="tutor_complete_course" name="tutor_action"/>

					<button type="submit" class="tutor-btn tutor-btn-outline-primary tutor-btn-block" name="complete_course_btn" value="complete_course">
						<?php esc_html_e( 'Complete Course', 'gostudy' ); ?>
					</button>
				</form>
				<?php
				echo apply_filters( 'tutor_course/single/complete_form', ob_get_clean() );
			}

			?>
				<?php
					// check if has enrolled date.
					$post_date = is_object( $is_enrolled ) && isset( $is_enrolled->post_date ) ? $is_enrolled->post_date : '';
					if ( '' !== $post_date ) :
					?>
					<div class="tutor-fs-7 tutor-color-muted tutor-mt-20 tutor-d-flex">
						<span class="tutor-fs-6 tutor-color-success tutor-icon-purchase-mark tutor-mr-8"></span>
						<span class="tutor-enrolled-info-text">
							<?php esc_html_e( 'You enrolled in this course on', 'gostudy' ); ?>
							<span class="tutor-fs-7 tutor-fw-bold tutor-color-success tutor-ml-4 tutor-enrolled-info-date">
								<?php
									echo esc_html( tutor_i18n_get_formated_date( $post_date, get_option( 'date_format' ) ) );
								?>
							</span>
						</span>
					</div>
				<?php endif; ?>
			<?php
			do_action( 'tutor_course/single/actions_btn_group/after' );
			echo apply_filters( 'tutor/course/single/entry-box/is_enrolled', ob_get_clean(), get_the_ID() );
		} else if ( $is_public ) {
			// Get the first content url
			$first_lesson_url = tutor_utils()->get_course_first_lesson( get_the_ID(), tutor()->lesson_post_type );
			!$first_lesson_url ? $first_lesson_url = tutor_utils()->get_course_first_lesson( get_the_ID() ) : 0;
			ob_start();
			?>
				<a href="<?php echo esc_url( $first_lesson_url ); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block">
					<?php esc_html_e( 'Start Learning', 'gostudy' ); ?>
				</a>
			<?php
			echo apply_filters( 'tutor/course/single/entry-box/is_public', ob_get_clean(), get_the_ID() );
		} else {
			// The course enroll options like purchase or free enrolment
			$price = apply_filters( 'get_tutor_course_price', null, get_the_ID() );

			if ( tutor_utils()->is_course_fully_booked( null ) ) {
				ob_start();
				?>
					<div class="tutor-alert tutor-warning tutor-mt-28">
						<div class="tutor-alert-text">
							<span class="tutor-icon-circle-info tutor-alert-icon tutor-mr-12" area-hidden="true"></span>
							<span>
								<?php esc_html_e( 'This course is full right now. We limit the number of students to create an optimized and productive group dynamic.', 'gostudy' ); ?>
							</span>
						</div>
					</div>
				<?php
				echo apply_filters( 'tutor/course/single/entry-box/fully_booked', ob_get_clean(), get_the_ID() );
			} elseif ( $is_purchasable && $price && $tutor_course_sell_by ) {
				// Load template based on monetization option
				ob_start();
				tutor_load_template( 'single.course.add-to-cart-' . $tutor_course_sell_by );
				echo apply_filters( 'tutor/course/single/entry-box/purchasable', ob_get_clean(), get_the_ID() );
			} else {
				ob_start();
				?>
					<div class="tutor-course-single-pricing">
						<span class="tutor-fs-4 tutor-fw-bold tutor-color-black">
							<?php esc_html_e( 'Free', 'gostudy' ); ?>
						</span>
					</div>

					<div class="tutor-course-single-btn-group <?php echo is_user_logged_in() ? '' : 'tutor-course-entry-box-login'; ?>" data-login_url="<?php echo esc_url($login_url); ?>">
						<form class="tutor-enrol-course-form" method="post">
							<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
							<input type="hidden" name="tutor_course_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
							<input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">
							<button type="submit" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block tutor-mt-24 tutor-enroll-course-button tutor-static-loader">
								<?php esc_html_e( 'Enroll now', 'gostudy' ); ?>
							</button>
						</form>
					</div>

					<div class="tutor-fs-7 tutor-color-muted tutor-mt-20 tutor-text-center">
						<?php esc_html_e( 'Free access this course', 'gostudy' ); ?>
					</div>
				<?php
				echo apply_filters( 'tutor/course/single/entry-box/free', ob_get_clean(), get_the_ID() );
			}
		}

		do_action('tutor_course/single/entry/after', get_the_ID());
		?>




<?php
if ( ! is_user_logged_in() ) {
	tutor_load_template_from_custom_path( tutor()->path . '/views/modal/login.php' );
}
?>
