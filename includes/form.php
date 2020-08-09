        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>

            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>"
                name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>"
                size="3" /></p>

        <p>

            <label for="<?php echo $this->get_field_id("sort_by"); ?>">

                <?php _e('Sort by'); ?>:

                <select id="<?php echo $this->get_field_id("sort_by"); ?>"
                    name="<?php echo $this->get_field_name("sort_by"); ?>">

                    <option value="date" <?php selected($instance["sort_by"], "date"); ?>>Date</option>

                    <option value="title" <?php selected($instance["sort_by"], "title"); ?>>Title</option>

                    <option value="comment_count" <?php selected($instance["sort_by"], "comment_count"); ?>>Number of
                        comments</option>

                    <option value="rand" <?php selected($instance["sort_by"], "rand"); ?>>Random</option>

                </select>

            </label>

        </p>


        <p>

            <label for="<?php echo $this->get_field_id("asc_sort_order"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("asc_sort_order"); ?>"
                    name="<?php echo $this->get_field_name("asc_sort_order"); ?>"
                    <?php checked((bool)$instance["asc_sort_order"], true); ?> />

                <?php _e('Reverse sort order (ascending)'); ?>

            </label>

        </p>

        <p>

            <label for="<?php echo $this->get_field_id("link_new_window"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("link_new_window"); ?>"
                    name="<?php echo $this->get_field_name("link_new_window"); ?>"
                    <?php checked((bool)$instance["link_new_window"], true); ?> />

                <?php _e('Open post links in new windows?'); ?>

            </label>

        </p>

        <p>

            <label for="<?php echo $this->get_field_id("hide_current_post"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("hide_current_post"); ?>"
                    name="<?php echo $this->get_field_name("hide_current_post"); ?>"
                    <?php checked((bool)$instance["hide_current_post"], true); ?> />

                <?php _e('Hide the current post?'); ?>

            </label>

        </p>

        <p>

            <label for="<?php echo $this->get_field_id("hide_sticky"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("hide_sticky"); ?>"
                    name="<?php echo $this->get_field_name("hide_sticky"); ?>"
                    <?php checked((bool)$instance["hide_sticky"], true); ?> />

                <?php _e('Hide the sticky posts?'); ?>

            </label>

        </p>        

        <p><strong>Title</strong></p>

        <p>

            <label for="<?php echo $this->get_field_id("p_title"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("p_title"); ?>"
                    name="<?php echo $this->get_field_name("p_title"); ?>"
                    <?php checked((bool)$instance["p_title"], true); ?> />

                <?php _e('Hide post title'); ?>

            </label>

        </p>

        <p>

            <label for="<?php echo $this->get_field_id("title_length"); ?>">

                <?php _e('Post title length (in words):'); ?>

            </label>

            <input type="text" id="<?php echo $this->get_field_id("title_length"); ?>"
                name="<?php echo $this->get_field_name("title_length"); ?>" value="<?php echo $title_length; ?>"
                size="4" />

        </p>

        <p><strong>Excerpt</strong></p>

        <p>

            <label for="<?php echo $this->get_field_id("excerpt"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>"
                    name="<?php echo $this->get_field_name("excerpt"); ?>"
                    <?php checked((bool)$instance["excerpt"], true); ?> />

                <?php _e('show post excerpt'); ?>

            </label>

        </p>



        <p>

            <label for="<?php echo $this->get_field_id("excerpt_length"); ?>">

                <?php _e('Excerpt length (in words):'); ?>

            </label>

            <input type="text" id="<?php echo $this->get_field_id("excerpt_length"); ?>"
                name="<?php echo $this->get_field_name("excerpt_length"); ?>" value="<?php echo $excerpt_length; ?>"
                size="3" />

        </p>

        <p>

            <label for="<?php echo $this->get_field_id("readmore"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("readmore"); ?>"
                    name="<?php echo $this->get_field_name("readmore"); ?>"
                    <?php checked((bool)$instance["readmore"], true); ?> />

                <?php _e('Include read more link in excerpt'); ?>

            </label>

        </p>

        <p>

            <label for="<?php echo $this->get_field_id("excerpt_readmore"); ?>">

                <?php _e('Excerpt read more text:'); ?>

            </label>

            <input type="text" id="<?php echo $this->get_field_id("excerpt_readmore"); ?>"
                name="<?php echo $this->get_field_name("excerpt_readmore"); ?>" value="<?php echo $excerpt_readmore; ?>"
                size="10" />

        </p>
        <p><strong>Date</strong></p>
        <p>

            <label for="<?php echo $this->get_field_id("date"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>"
                    name="<?php echo $this->get_field_name("date"); ?>"
                    <?php checked((bool)$instance["date"], true); ?> />

                <?php _e('Include post date'); ?>

            </label>

        </p>

        <p><strong>Comments</strong></p>
        <p>

            <label for="<?php echo $this->get_field_id("comment_num"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>"
                    name="<?php echo $this->get_field_name("comment_num"); ?>"
                    <?php checked((bool)$instance["comment_num"], true); ?> />

                <?php _e('Show number of comments'); ?>

            </label>

        </p>
        <p><strong>Media</strong></p>
        <?php if (function_exists('the_post_thumbnail') && current_theme_supports("post-thumbnails")): ?>

        <p>

            <label for="<?php echo $this->get_field_id("thumb"); ?>">

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("thumb"); ?>"
                    name="<?php echo $this->get_field_name("thumb"); ?>"
                    <?php checked((bool)$instance["thumb"], true); ?> />

                <?php _e('Show post thumbnail'); ?>

            </label>

        </p>

        <p>

            <label>

                <?php _e('Thumbnail dimensions'); ?>:<br />

                <label for="<?php echo $this->get_field_id("thumb_w"); ?>">

                    W: <input class="widefat" style="width:40%;" type="text"
                        id="<?php echo $this->get_field_id("thumb_w"); ?>"
                        name="<?php echo $this->get_field_name("thumb_w"); ?>" value="<?php echo $thumb_w; ?>" />

                </label>



                <label for="<?php echo $this->get_field_id("thumb_h"); ?>">

                    H: <input class="widefat" style="width:40%;" type="text"
                        id="<?php echo $this->get_field_id("thumb_h"); ?>"
                        name="<?php echo $this->get_field_name("thumb_h"); ?>" value="<?php echo $thumb_h; ?>" />

                </label>

            </label>

        </p>

        <?php endif; ?>

        <p><strong>Post Types & Taxonomies</strong></p>
        <p>
            <label for="<?php echo $this->get_field_id('show_type'); ?>"><?php _e('Show Post Type:'); ?>
                <select class="widefat" id="<?php echo $this->get_field_id('show_type'); ?>"
                    name="<?php echo $this->get_field_name('show_type'); ?>">
                    <?php
                    global $wp_post_types;
                    foreach ($wp_post_types as $k => $sa) {
                        if ($sa->exclude_from_search) {
                            continue;
                        }

                        echo '<option value="' . $k . '"' . selected($k, $show_type, true) . '>' . $sa->labels->name . '</option>';
                    }
                    ?>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Taxonomies:'); ?>
                <?php
                        $taxonomy_names = get_object_taxonomies($show_type, 'objects');
                        if ($taxonomy_names) {
                            foreach ($taxonomy_names as $taxonomy) {
                                $categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy->name);
                                if ($categories) {
                                    echo '<br>' . $taxonomy->label; ?>
                <select class="widefat" id="<?php echo $this->get_field_id('cats') . '[' . $taxonomy->name . '][]'; ?>"
                    name="<?php echo $this->get_field_name('cats') . '[' . $taxonomy->name . '][]'; ?>" multiple>
                    <?php
                        foreach ($categories as $cat) {
                                        echo '<option value="' . $cat->term_id . '"' . selected($k, $show_type, true) . '>' . $cat->cat_name . '</option>';
                                    }
                                    echo '</select>';
                                }
                            }
                        }
                        ?>
            </label>
        </p>