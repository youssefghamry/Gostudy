<?php

/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gostudy
 * @author Pixelcurve <help.pixelcurve@gmail.com>
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

use Gostudy_Theme_Helper as Gostudy;

$learnpress_archive_layout = Gostudy_Theme_Helper::get_mb_option('learnpress_archive_layout');
$learnpress_archive_columns = Gostudy_Theme_Helper::get_mb_option('learnpress_archive_columns');
$learnpress_pagi_align = Gostudy_Theme_Helper::get_mb_option('learnpress_pagi_align');

// Taxonomies
$tax_obj = get_queried_object();
$term_id = $tax_obj->term_id ?? '';
$tax_description = false;
 if ($term_id) {
    $taxonomies[] = $tax_obj->taxonomy . ': ' . $tax_obj->slug;
    $tax_description = $tax_obj->description;
}

// Sidebar parameters
$sb = Gostudy::get_sidebar_data('learnpress_archive');
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '';

// Render
get_header();

echo '<div class="rt-container', apply_filters('gostudy/container/class', esc_attr( $container_class )), '">';
echo '<div class="row', apply_filters('gostudy/row/class', $row_class), '">';
    echo '<div id="main-content" class="rt_col-', apply_filters('gostudy/column/class', esc_attr( $column )), '">';

        if ($term_id) { ?>
            <div class="archive__heading">
                <h4 class="archive__tax_title"><?php
                    echo get_the_archive_title(); ?>
                </h4>
                <?php
                if (!empty($tax_description)) {
                    echo '<div class="archive__tax_description">' . esc_html($tax_description) . '</div>';
                }
                ?>
            </div><?php
        }
        ?>

        <section class="rt-courses layout-<?php echo esc_attr($learnpress_archive_layout); ?>">
        <?php
        /**
         * LP Hook
         */
        // do_action( 'learn-press/before-courses-loop' ); ?>

        <div class="rt-courses__grid grid-col--<?php echo esc_attr($learnpress_archive_columns); ?>">
        <?php
        $loop = new WP_Query( array( 
            'post_type' => 'lp_course', 
            'paged' => $paged 
        ) );
        if ( $loop->have_posts() ) :
                while ( $loop->have_posts() ) : $loop->the_post(); 

                learn_press_get_template_part( 'content', 'course' );

            endwhile;
        endif; ?>

        </div>

        <?php
        /**
         * @since 3.0.0
         */
        // do_action( 'learn-press/after-courses-loop' ); 

        // Pagination ?>

        <nav class="rt-paginate_links a<?php echo esc_attr($learnpress_pagi_align); ?>" role="navigation" aria-label="Posts">
            <div class="nav-links">
                <?php 
                    echo paginate_links( array(
                        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                        'total'        => $loop->max_num_pages,
                        'current'      => max( 1, get_query_var( 'paged' ) ),
                        'format'       => '?paged=%#%',
                        'show_all'     => false,
                        'type'         => 'plain',
                        'end_size'     => 1,
                        'mid_size'     => 2,
                        'prev_next'    => true,
                        'prev_text' => '<i class="flaticon-back" aria-hidden="true"></i>',
                        'next_text' => '<i class="flaticon-next" aria-hidden="true"></i>',
                        'add_args'     => false,
                        'add_fragment' => '',
                    ) );
                ?>
            </div> <!-- row -->  
        </nav>
        
    <?php
        wp_reset_postdata();
        ?>
            
        </section> 
    <?php

        echo Gostudy::pagination();

    echo '</div>';

    $sb && Gostudy::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
