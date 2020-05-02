<?php
/**
 * Template Name: Applications Form
 */
get_header();

if (get_option('wpjobs_send_mail') <> '') {
    $wpjobs_send_mail = get_option('wpjobs_send_mail');
}

if (isset($_POST['btnsubform'])) {
    $fname = sanitize_text_field($_POST['user_fname']);
    $lname = sanitize_text_field($_POST['user_lname']);
    $email = sanitize_email($_POST['user_email']);
    $phone = sanitize_text_field($_POST['user_phn']);
}
?>
<div class="wpjbs_dtailmain">
    <?php
    global $post;
    $post_data = get_post($post->ID);
    ?>
    <div  id="jbst" class="wpjbs_dtailleft">
        <div id="msg"></div>
        <div class="wpjbs_dsections">
            <h1 class="wpjbs_dtitle"><?php
                the_title();
                $title = esc_html($post_data->post_title);
                ?></h1>
            <div class="wpjbs_dinfo">
                <?php if (get_post_meta($post_data->ID, 'wp_jobs_designation', true)) { ?>
                    <p class="wpjbs_ddin"><?php _e('Designation', 'wp-jobs'); ?>: <?php echo get_post_meta($post_data->ID, 'wp_jobs_designation', true); ?> </p>
                <?php } ?>
                <?php if (get_post_meta($post_data->ID, 'wp_jobs_location', true)) { ?>
                    <p class="wpjbs_dlcnt"><?php _e('Location', 'wp-jobs'); ?>: <?php echo get_post_meta($post_data->ID, 'wp_jobs_location', true); ?> </p>
                <?php } ?>
                <?php if (get_post_meta($post_data->ID, 'wp_jobs_salary', true)) { ?>
                    <p class="wpjbs_dslry"><?php _e('Salary', 'wp-jobs'); ?>: <?php echo get_post_meta($post_data->ID, 'wp_jobs_salary', true); ?> </p>
                <?php } ?>
                <?php if (get_post_meta($post_data->ID, 'wp_jobs_type', true)) { ?>
                    <p class="wpjbs_dperiod"><?php echo get_post_meta($post_data->ID, 'wp_jobs_type', true); ?></p>
                <?php } ?>
                <p class="wpjbs_dsate"><?php echo get_the_date(); ?></p>
            </div>
        </div>

        <div class="wpjbs_dsections">
            <h2 class="sctheading"><?php _e('Description', 'wp-jobs'); ?></h2>
            <p><?php echo apply_filters('the_content', $post_data->post_content); ?></p>
        </div>

        <div class="wpjbs_dsections">
            <h2 class="sctheading"><?php _e('Qualification / Requirements', 'wp-jobs'); ?></h2>
            <p><?php
                // display qualification and requirements data
                if (null != get_post_meta($post_data->ID, 'wpjobseditorqualification', true)) {
                    $wpj_req_text = get_post_meta($post_data->ID, 'wpjobseditorqualification', true);
                    echo apply_filters('get_the_content', $wpj_req_text);
                }
                ?></p>

        </div>

        <div class="wpjbs_dsections" >
            <?php
            $frm_code = get_post_meta($post_data->ID, 'wp_jobs_frm', true);
            if (!empty($frm_code)) {

                echo do_shortcode('[contact-form-7 id="107" title="Contact form 1"]');
            } else {
                ?>

                <h2 class="sctheading"><?php _e('Apply for this job', 'wp-jobs'); ?></h2>
                <form method="post" id="frmInquiry" class="wpjbs_applicationfrm" action="" enctype="multipart/form-data">

                    <label><?php _e('First name', 'wp-jobs'); ?> <span style="color:red;">*</span></label>
                    <input id="user_fname" type="text" value="<?php
                    if (!empty($fname)) {
                        echo $fname;
                    } else {

                    }
                    ?>" name="user_fname"/>
                    <label><?php _e('Last name', 'wp-jobs'); ?></label>
                    <input type="text" id="user_lname" value="<?php
                    if (!empty($lname)) {
                        echo $lname;
                    } else {

                    }
                    ?>" name="user_lname"/>

                    <label><?php _e('Phone Number', 'wp-jobs'); ?><span style="color:red;">*</span></label>
                    <input type="text" value="<?php
                    if (!empty($phone)) {
                        echo $phone;
                    } else {

                    }
                    ?>" name="user_phn" id="user_phn"/>

                    <label><?php _e('Email Address', 'wp-jobs'); ?> <span style="color:red;">*</span></label>
                    <input type="email" value="<?php
                    if (!empty($email)) {
                        echo $email;
                    } else {

                    }
                    ?>" name="user_email" id="user_email"/>

                    <label><?php _e('Attach Resume', 'wp-jobs'); ?> <span style="color:red;">*</span></label>
                    <input type="file" name="myfile" id="myfile" class="wpjbs_fileatt">
                    <span class="wpjbs_help-block">( .doc,.docx,.pdf )</span>
                    <div class="clear"></div>
                    <input type="submit"  name="btnsubform" id="btnsubform" class="wpjbs_btnfrm" value="<?php _e('Submit Application', 'wp-jobs'); ?>" />

                </form>
                <?php
                if (isset($_POST['btnsubform'])) {

                    if (!empty($phone)) {
                        if (!empty($fname)) {
                            global $wpdb;
                            $allowed = array('pdf', 'doc', 'docx');
                            $filename = $_FILES['myfile']['name'];
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);

                            //this is extention if strart
                            if (!in_array($ext, $allowed)) {
                                ?>
                                <script type="text/javascript">
                                    var msgbox = document.getElementById('msg');
                                    msgbox.innerHTML = "<div class='alert alert-error'><a class='close' data-dismiss='alert'>×</a><strong>Error! </strong>File type or file empty </div>";
                                </script>
                                <?php
                            } else {

                                //Email check if applied already
                                $tbl = $wpdb->prefix;
                                $emailchkqry = "select app_email from " . $tbl . "app_user_info where app_job_id='" . $post->ID . "' and app_email='" . $email . "'";

                                $checkEmail = $wpdb->get_results($emailchkqry);
                                $userreccount = count($checkEmail);
                                if ($userreccount > 0) {
                                    ?>
                                    <script type="text/javascript">
                                        var msgbox = document.getElementById('msg');
                                        msgbox.innerHTML = "<div class='alert alert-info'><a class='close' data-dismiss='alert'>×</a><?php _e('You have already applied for ', 'wp-jobs'); ?> <?php echo $title; ?></div>";
                                    </script>

                                    <?php
                                } else {
                                    if (!function_exists('wp_handle_upload')) {
                                        require_once( ABSPATH . 'wp-admin/includes/file.php');
                                    }
                                    $uploadedfile = $_FILES['myfile'];
                                    $upload_overrides = array('test_form' => false);
                                    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
                                    if ($movefile) {
                                        $wp_filetype = $movefile['type'];
                                        $filename = $movefile['file'];
                                        $wp_upload_dir = wp_upload_dir();
                                        $attachment = array(
                                            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
                                            'post_mime_type' => $wp_filetype,
                                            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                                            'post_content' => ''
                                        );
                                        $attach_id = wp_insert_attachment($attachment, $filename);
                                        if ($attach_id) {
                                            //this is an insert user section start
                                            $tbl = $wpdb->prefix;

                                            $wpdb->insert($tbl . 'app_user_info', array(
                                                'app_name' => $fname . "-" . $lname,
                                                'app_job_id' => $post_data->ID,
                                                'app_email' => $email,
                                                'app_phn' => $phone,
                                                'app_cv' => $wp_upload_dir['url'] . '/' . basename($filename),
                                                    ), array(
                                                '%s', '%s', '%s', '%s', '%s'
                                                    )
                                            );
                                            //this is an insert user section end
                                            //This is Email Section	Start
                                            $tbl = $wpdb->prefix;
                                            $emailattqry = "select app_cv from " . $tbl . "app_user_info where app_job_id='" . $post->ID . "' and app_email='" . $email . "'";

                                            $getattachEmail = $wpdb->get_var($emailattqry);
                                            $docmain = pathinfo(WP_CONTENT_DIR);
                                            $docpath = $docmain['dirname'];
                                            $attachpath = wp_make_link_relative($getattachEmail);
                                            $finalpath = $docpath . $attachpath;

                                            $usrheadersrpt[] = "Content-type: text/html";
                                            $adm_attachments = array($finalpath);
                                            $usrheadersrpt[] = 'From: <' . get_option("wpjobs_send_mail") . '>';
                                            $usr_admin_headersrpt[] = "Content-type: text/html";
                                            $usr_admin_headersrpt[] = 'From:' . $email;
                                            $adm_messagerpt = "<table><tr><td colspan='4'><h3>Thank you " . $fname . "</h3></td></tr>
  <tr><td colspan='4'>Applying for the post of " . $title . "</td></tr></table>";
                                            $adm_messagerpt = "Thank you " . $fname . " for applying for the job " . $title;
                                            //$admin_messagerpt = "<table><tr><td colspan='4'><h3>New Application By: " . $fname . "</h3></td></tr><tr><td colspan='4'>Applying for the post of " . $title . "</td></tr><p>DB: ".print_r($getattachEmail)."</p><p>Attachment ".print_r($adm_attachments)."</p></table>";
                                            $admin_messagerpt = "New Application by " . $fname . " for the job: " . $title ." <p>Attached is the resume</p> ";

                                            wp_mail($email, __('Job submission confirmation', 'wp-jobs'), $adm_messagerpt, $usrheadersrpt);
                                            wp_mail($wpjobs_send_mail, __('Job submission confirmation', 'wp-jobs'), $admin_messagerpt, $usr_admin_headersrpt, $adm_attachments);
                                            //This is Email Section	End
                                            ?>
                                            <script type="text/javascript">
                                                var msgbox = document.getElementById('msg');
                                                msgbox.innerHTML = "<div class='alert alert-info'><a class='close' data-dismiss='alert'>×</a>Thank You <?php echo ucwords($fname); ?> For Applying For The Job <?php echo $title; ?></div>";

                                                document.getElementById('user_fname').value = ""
                                                document.getElementById('user_lname').value = "";
                                                document.getElementById('user_email').value = "";
                                                document.getElementById('user_phn').value = "";

                                            </script>
                                            <?php
                                        } else {
                                            echo "attach !";
                                        }
                                    } else {
                                        echo "move";
                                    }
                                }
                                //this chek for checking email for appling job end
                            }
                        } else {
                            ?>
                            <script type="text/javascript">
                                var msgbox = document.getElementById('msg');
                                msgbox.innerHTML = "<div class='alert alert-error'><a class='close' data-dismiss='alert'>×</a><?php _e('Enter Name', 'wp-jobs'); ?></div>";
                            </script>
                            <?php
                        }
                    } else {
                        ?>
                        <script type="text/javascript">
                            var msgbox = document.getElementById('msg');
                            msgbox.innerHTML = "<div class='alert alert-error'><a class='close' data-dismiss='alert'>×</a><?php _e('Enter Phone Number', 'wp-jobs'); ?></div>";
                        </script>
                        <?php
                    }
                    //here extension check end
                }
            }
            ?>

        </div>

    </div>
    <!--
    <div class="wpjbs_dtailright">
        <?php //get_sidebar(); ?>
    </div>-->
    <div class="clear"></div>
</div><!-- #content -->

</div><!-- #primary -->

<?php get_footer(); ?>
