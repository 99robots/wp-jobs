<div class="wrap">
    <h2>WP Jobs - <?php _e('Settings', 'wp-jobs'); ?></h2>
    <?php
    $wpjobs_pg_pro_list = "";
    $wpjobs_send_mail = "";
    if (get_option('wpjobs_pg_pro_list') <> '') {
        $wpjobs_pg_pro_list = get_option('wpjobs_pg_pro_list');
    }
    if (get_option('wpjobs_send_mail') <> '') {
        $wpjobs_send_mail = get_option('wpjobs_send_mail');
    }
    ?>
    <div class="ajxrsp" id="wpjobs_output_div"></div>
    <form id="form1" name="form1" method="POST" action="">
        <table width="600" border="0" cellspacing="1" cellpadding="2">
            <tr>
                <td><?php _e('Jobs sent email to', 'wp-jobs'); ?></td>
                <td><input type="text" name="send_mail" id="send_mail" value="<?php echo $wpjobs_send_mail; ?>" /></td>
            </tr>
            <tr>
                <td width="250"><?php _e('Jobs listing page', 'wp-jobs'); ?></td>
                <td width="339">
                    <select name="adv_page" id="adv_page">
                        <?php
                        $args_pages = array(
                            'posts_per_page' => -1,
                            'orderby' => 'post_date',
                            'order' => 'DESC',
                            'post_type' => 'page',
                            'post_status' => 'publish');

                        $myposts = get_posts($args_pages);
                        foreach ($myposts as $post) :
                            ?>
                            <option value="<?php echo $post->post_name; ?>" <?php if ($post->ID == $wpjobs_pg_pro_list) { ?> selected="selected"<?php } ?>><?php echo $post->post_title; ?></option>
                        <?php endforeach; ?>
                    </select></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="button" id="wpjobs_submit" value="Save Options" class="button-primary">
                    <img src="<?php echo admin_url('/images/wpspin_light.gif'); ?>" class="waiting" style="display:none;" id="wpjobs_loading" />
                </td>
            </tr>
        </table>
    </form>
</div>
