<?php
/**
 * Template Name: Job Listing Page
 */
get_header();
if ((isset($_REQUEST['btnsub'])) && $_REQUEST['dropdept'] != '0') {
    $dept_val = sanitize_text_field($_REQUEST['dropdept']);
}
?>
<div class="wpjbs_listing">
    <div class="wpjbs_listleft">
        <h1 class="entry-title"><?php the_title(); ?></h1><div>

            <form action="" method="" class="wpjbs_flterfrm">
                <?php
                  if (isset($_POST['btnsub'])) {
                      $taxonomy = 'department';
                      $terms = get_terms('department');
                      echo "<select class='wpjbs_fselect' id='mytrem' name='dropdept'>";
                      echo "<option value='0'>All department</option>";
                      foreach ($terms as $term) {
                          $term_link = get_term_link($term, 'department');
                          if (is_wp_error($term_link))
                              continue;
                          echo '<option  value=' . $term->term_id . ' >' . $term->name . '</option>';
                      }
                      echo '</select>';
                  }else {
                      $taxonomy = 'department';
                      $terms = get_terms('department');
                      echo "<select class='wpjbs_fselect' id='mytrem' name='dropdept'>";
                      echo "<option value='0'>All department</option>";
                      foreach ($terms as $term) {
                          $term_link = get_term_link($term, 'department');
                          if (is_wp_error($term_link))
                              continue;
                          echo '<option  value=' . $term->term_id . ' >' . $term->name . '</option>';
                      }
                      echo '</select>';
                  }
                ?>

                <input type="submit" name="btnsub" class="wpjbs_sbtn" value="Filter Jobs"/>
            </form>
            <?php
            global $post, $wp_query;
            if (isset($dept_val)) {
                $myquery['tax_query'] = array(
                    array(
                        'taxonomy' => 'department',
                        'terms' => $dept_val,
                        'field' => 'id',
                        'post_type' => 'job',
                        'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                ));
                ?>
                <script type="text/javascript">
                    document.getElementById('mytrem').value = "<?php echo $dept_val ?>";
                </script>
                <?php
                $items = query_posts($myquery);
                #$wp_query = $items;
            } else {
                $args_job = array(
                    'post_type' => 'job',
                    'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                );
                $items = query_posts($args_job);
            }
            #$count = $items->post_count; #count($items);
            #echo "<div class='info-error'><br/>" . __('Job result found ', 'wp-jobs') . $count . "</div>";
            ?>
            <ul class="wpjbs_jbmain">
                <li>
                    <div class="wpjbs_first"><strong><?php _e('Job Title', 'wp-jobs'); ?></strong></div>
                    <div class="wpjbs_second"><strong><?php _e('Department', 'wp-jobs'); ?></strong></div>
                    <div class="wpjbs_third"><strong><?php _e('Designation', 'wp-jobs'); ?></strong></div>
                    <div class="wpjbs_fourth"><strong><?php _e('Location', 'wp-jobs'); ?></strong></div>
                    <div class="wpjbs_fifth"><strong><?php _e('Salary', 'wp-jobs'); ?></strong></div>
                </li>
                <?php
                foreach ($items as $item) {
                    setup_postdata($item);
                    ?>
                    <li>
                        <div class="wpjbs_first"><a href="<?php echo get_permalink($item->ID) ?>" ><?php echo esc_html($item->post_title); ?></a></div>
                        <div class="wpjbs_second"><?php
                            $terms_as_text = strip_tags(get_the_term_list($item->ID, 'department', '', ', ', ''));
                            echo esc_html($terms_as_text);
                            ?></div>
                        <div class="wpjbs_third"><?php echo get_post_meta($item->ID, 'wp_jobs_designation', true); ?></div>
                        <div class="wpjbs_fourth"><?php echo get_post_meta($item->ID, 'wp_jobs_location', true); ?></div>
                        <div class="wpjbs_fifth"><?php echo get_post_meta($item->ID, 'wp_jobs_salary', true); ?></div>
                    </li>
                <?php } ?>

            </ul>
            <div class="wpjbs_navigation">
                <div class="wpjbs_alignleft"><?php previous_posts_link('&laquo; Previous Page') ?></div>
                <div class="wpjbs_alignright"><?php next_posts_link('Next Page &raquo;') ?></div>
            </div>

        </div>
    </div>
    <?php wp_reset_postdata(); ?>

    <!--<div class="wpjbs_listright">
        <?php //get_sidebar(); ?>
    </div>-->
    <div class="clear"></div>
</div><!-- #content -->

<?php
get_footer();
