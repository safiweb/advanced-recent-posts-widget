<?php

    // standard query params
    $query_args = array(
        'posts_per_page'      => $number,
        'no_found_rows'       => true,
        'post_status'         => 'publish',
    );

    $query_args[ 'orderby' ] = $sort_by;
    $query_args[ 'order' ] = $sort_order;
    $query_args[ 'post_type' ] = $show_type;

    if ( ! in_array( 0, $cats ) ) {
        $query_args[ 'category__in' ] = $cats;
    }

    // exclude current displayed post
    if ( $hide_current_post ) {
        if ( isset( $post->ID ) and is_singular() ) {
            $query_args[ 'post__not_in' ] = array( $post->ID );
        }
    }

    // ignore sticky posts if desired, else show them on top
	$query_args[ 'ignore_sticky_posts' ] = $hide_sticky;


    $adv_recent_posts = null;
    $adv_recent_posts = new WP_Query(
        apply_filters(
            'adrp_widget_posts_args',
            $query_args,
            $instance
        )
    );

    if ( ! $adv_recent_posts->have_posts() ) {
        return;
    }
    ?>

    <?php echo $args['before_widget']; ?>

    <?php
    if ( $title ) {
        echo $args['before_title'] . $title . $args['after_title'];
    }

    $format = current_theme_supports( 'html5', 'navigation-widgets' ) ? 'html5' : 'xhtml';

    /** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
    $format = apply_filters( 'navigation_widgets_format', $format );

    if ( 'html5' === $format ) {
        // The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
        $title      = trim( strip_tags( $title ) );
        $aria_label = $title ? $title : $default_title;
        echo '<nav role="navigation" aria-label="' . esc_attr( $aria_label ) . '">';
    }
    ?>

    <ul>
        <?php while ( $adv_recent_posts->have_posts() ) : $adv_recent_posts->the_post();  ?>
            <?php
            $post_title   = get_the_title();
            $title        = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
            $aria_current = '';

            if ( get_queried_object_id() === get_the_ID() ) {
                $aria_current = ' aria-current="page"';
            }
            ?>
            <li class="recent-post-item">
                <a href="<?php the_permalink(); ?>"<?php echo $aria_current; ?>><?php echo $title; ?></a>
                <?php if ( $show_date ) : ?>
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                <?php endif; ?>

                <?php if ( $instance['excerpt'] || $instance["thumb"] ) : ?>
                    <div class="post-entry">
                        <?php
                            //Thumbnail display
                            if (

                                function_exists('the_post_thumbnail') &&
                                current_theme_supports("post-thumbnails") &&
                                $instance["thumb"] &&
                                has_post_thumbnail()

                            ) :
                            
                            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),array($thumb_w,$thumb_h));
                            $plugin_dir = 'advanced-recent-posts-widget';
                        ?>

                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo $thumb_w; ?>" height="<?php echo $thumb_h; ?>" />
                            </a>

                        <?php endif; ?>

                        <?php if ( $instance['excerpt'] ) : ?>
                            <?php if ( $instance['readmore'] ) : $linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>'; else: $linkmore =''; endif; ?>
                            <p><?php echo get_the_excerpt() . $linkmore; ?> </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $instance['comment_num'] ) : ?>
                <p class="comment-num">(<?php comments_number(); ?>)</p>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </ul>