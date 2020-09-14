<?php
/*
  Plugin Name: WP Jobs
  Plugin URI: https://draftpress.com/products
  Description: Post jobs on your WordPress site. User can apply and attach resume/CV for the jobs.
  Author: 99 Robots
  Version: 2.3.1
  Author URI: https://99robots.com/
  Text Domain: wp-jobs
  Domain Path: /languages
 */
$wpjobs_PluginName = 'WPJobs';
$wpjobs_upload_dir = wp_upload_dir();
define('wp_jobs_path', plugin_dir_path(__FILE__));
define('wp_jobs_url', plugin_dir_url(__FILE__));
define('wp_jobs_currency', get_option('wp_jobs_currency'));

add_action('wp_enqueue_scripts', 'wp_jobs_scripts_with_jquery');

//Load language files
function wp_jobs_load_plugin_textdomain() {
    load_plugin_textdomain('wp-jobs', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

add_action('init', 'wp_jobs_load_plugin_textdomain');

function wp_jobs_scripts_with_jquery() {
// create array of all scripts
    $scripts = array(
        'custom-script1' => plugins_url('/js/bootstrap.min.js', __FILE__)
    );
    foreach ($scripts as $key => $sc) {
        wp_register_script($key, $sc, array('jquery'));
        wp_enqueue_script($key);
    }
}

function wp_jobs_activation() {
    add_option('wp_jobs_currency', '$');
    add_option('wp_jobs_listing', '5');
    add_option('wpjobs_wg_bg_color', '#ccc');
    add_option('wp_jobs_list_sidebar', 1);
    add_option('wp_jobs_detail_sidebar', 1);

    wp_jobs_Adduser_tbl(); //create table on activation

    flush_rewrite_rules(); // flushing permalinks
}

register_activation_hook(__FILE__, 'wp_jobs_activation');

function wp_jobs_admin_style() {
    wp_register_style('wp_jobs_bootstrap_css', plugins_url('css/bootstrap.min.css', __FILE__), false);
    wp_register_style('wp_jobs_bootstrap_responsive_css', plugins_url('css/bootstrap-responsive.min.css', __FILE__), false);
    wp_register_style('wp_jobs_admin_css', plugins_url('css/styles.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('wp_jobs_bootstrap_css');
    wp_enqueue_style('wp_jobs_bootstrap_responsive_css');
    wp_enqueue_style('wp_jobs_admin_css');
}

add_action('wp_enqueue_scripts', 'wp_jobs_admin_style');

function wp_jobs_custom_init() {

    $labels = array(
        'name' => 'Jobs',
        'singular_name' => 'Job',
        'add_new' => __('Add New', 'wp-jobs'),
        'add_new_item' => __('Add New Job', 'wp-jobs'),
        'edit_item' => __('Edit Job', 'wp-jobs'),
        'new_item' => __('New Job', 'wp-jobs'),
        'all_items' => __('All Jobs', 'wp-jobs'),
        'view_item' => __('View Job', 'wp-jobs'),
        'search_items' => __('Search Jobs', 'wp-jobs'),
        'not_found' => __('No jobs found', 'wp-jobs'),
        'not_found_in_trash' => __('No job found in Trash', 'wp-jobs'),
        'parent_item_colon' => '',
        'menu_name' => 'Jobs'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );
    register_post_type('job', $args);
    add_role('Applicant', 'Applicant');
}

#add_action('init', 'wp_jobs_Adduser_tbl');
function wp_jobs_Adduser_tbl() {

    global $wpdb;
    $tbl = $wpdb->prefix;
    $table_name = $tbl . "app_user_info";
    $sql = "select * from $table_name";
    $out = $wpdb->get_results($sql);
    if ($out) {
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(130) NOT NULL,
  `app_job_id` int(11) NOT NULL,
  `app_email` varchar(130) NOT NULL,
  `app_phn` varchar(130) NOT NULL,
  `app_cv` text NOT NULL,
  PRIMARY KEY (`app_id`)
);";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }
}

add_action('init', 'wp_jobs_custom_init');

// Adding A settings link for the plugin on the Settings Page
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wpjobs_add_plugin_page_settings_link');
function wpjobs_add_plugin_page_settings_link( $links ) {
	$links = array_merge(array('<a href="' .
		admin_url( 'admin.php?page=WPJobsHome' ) .
		'">' . __('Settings') . '</a>'), $links);
	return $links;
}

// define the wp_mail_failed callback
function action_wp_mail_failed($wp_error)
{
    return error_log(print_r($wp_error, true));
}

// add the action
add_action('wp_mail_failed', 'action_wp_mail_failed', 10, 1);

// Register Custom Taxonomy
function wp_jobs_taxonomy() {
    $labels = array(
        'name' => _x('Departments', 'Taxonomy General Name', 'wp-jobs'),
        'singular_name' => _x('Department', 'Taxonomy Singular Name', 'wp-jobs'),
        'menu_name' => __('Department', 'wp-jobs'),
        'all_items' => __('All Departments', 'wp-jobs'),
        'parent_item' => __('Parent Department', 'wp-jobs'),
        'parent_item_colon' => __('Parent Department:', 'wp-jobs'),
        'new_item_name' => __('New Department Name', 'wp-jobs'),
        'add_new_item' => __('Add New Department', 'wp-jobs'),
        'edit_item' => __('Edit Department', 'wp-jobs'),
        'update_item' => __('Update Department', 'wp-jobs'),
        'separate_items_with_commas' => __('Separate departments with commas', 'wp-jobs'),
        'search_items' => __('Search department', 'wp-jobs'),
        'add_or_remove_items' => __('Add or remove departments', 'wp-jobs'),
        'choose_from_most_used' => __('Choose from the most used departments', 'wp-jobs'),
    );
    $rewrite = array(
        'slug' => 'department',
        'with_front' => true,
        'hierarchical' => true,
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'rewrite' => $rewrite,
    );
    register_taxonomy('department', 'job', $args);
}

// Hook into the 'init' action
add_action('init', 'wp_jobs_taxonomy', 0);
#include wp_jobs_path.'functions.php';

function wpjobs_AdminMenu() {
    global $wpjobs_PluginDirName, $wpjobs_PluginName, $wpjobs_settings_page;
    $wpjobs_homepage = add_menu_page($wpjobs_PluginName . " Configuration", 'WP Jobs', 'edit_themes', $wpjobs_PluginName . "Home", 'wpjobs_HomeView');
    $wpjobs_settings_page = add_submenu_page("WPJobsHome", "Job Settings", 'Settings', "edit_themes", "JobSettings", 'wpjobs_SettingsView');
    $wpjobs_applications = add_submenu_page("edit.php?post_type=job", "Job Applications", "Job Applications", 'edit_themes', $wpjobs_PluginName . "Apps", 'wpjobs_ApplicationsView');
    //add_action( 'admin_print_styles-' . $submenu, 'admin_custom_css' );

}
add_action('admin_menu', 'wpjobs_AdminMenu');

//-------------
function wpjobs_HomeView() {

    global $wpjobs_PluginName, $wpdb;
    include 'wpjobs_home.php';
}

function wpjobs_SettingsView() {
    global $wpjobs_PluginName, $wpdb;
    include 'wpjobs_settings.php';

}

function wpjobs_ApplicationsView() {
    global $wpjobs_PluginName, $wpdb;
    include 'wpjobs_applications.php';
}

add_action('add_meta_boxes', 'wp_jobs_cust_box');

function wp_jobs_cust_box() {
    add_meta_box(
            'myplugin_sectionid', __('Job Details', 'wp-jobs'), 'wp_jobs_custom_fields', 'job', 'side', 'high'
    );
}

//Custom box for Properties
/* Prints the box content */
function wp_jobs_custom_fields($post) {

    $mypostid = $post->ID;
    $wp_jobs_designation = stripslashes(get_post_meta($mypostid, 'wp_jobs_designation', true));
    $wp_jobs_application_email = stripslashes(get_post_meta($mypostid, 'wp_jobs_application_email', true));
    $wp_jobs_date_start = stripslashes(get_post_meta($mypostid, 'wp_jobs_date_start', true));
    $wp_jobs_date_close = stripslashes(get_post_meta($mypostid, 'wp_jobs_date_close', true));
    $wp_jobs_location = stripslashes(get_post_meta($mypostid, 'wp_jobs_location', true));
    $wp_jobs_salary = stripslashes(get_post_meta($mypostid, 'wp_jobs_salary', true));
    $wp_jobs_type = stripslashes(get_post_meta($mypostid, 'wp_jobs_type', true));
    $wp_jobs_frm = stripslashes(get_post_meta($mypostid, 'wp_jobs_frm', true));
    ?>
    <div class="AdmfrmLabel">
        <label for="wp_jobs_designation"><?php _e('Designation / Title', 'wp-jobs'); ?></label>
    </div>
    <div class="AdmfrmFld">
        <input name="wp_jobs_designation" type="text" id="wp_jobs_designation" value="<?php echo esc_html($wp_jobs_designation); ?>" />
    </div>
    <br style="clear:both;" />

    <div class="AdmfrmLabel">
        <label for="wp_jobs_application_email"><?php _e('Application Email', 'wp-jobs'); ?></label>
    </div>
    <div class="AdmfrmFld">
        <input name="wp_jobs_application_email" type="text" id="wp_jobs_application_email" value="<?php echo esc_html($wp_jobs_application_email); ?>" />
    </div>
    <br style="clear:both;" />
    <div class="AdmfrmLabel">
        <label for="wp_jobs_date_start"><?php _e('Date Start', 'wp-jobs'); ?></label>
    </div>
    <div class="AdmfrmFld">
        <input name="wp_jobs_date_start" type="text" id="wp_jobs_date_start" value="<?php echo esc_html($wp_jobs_date_start); ?>" />
    </div>
    <br style="clear:both;" />
    <div class="AdmfrmLabel">
        <label for="wp_jobs_date_close"><?php _e('Date Close', 'wp-jobs'); ?></label>
    </div>
    <div class="AdmfrmFld">
        <input name="wp_jobs_date_close" type="text" id="wp_jobs_date_close" value="<?php echo esc_html($wp_jobs_date_close); ?>" />
    </div>
    <br style="clear:both;" />
    <div class="AdmfrmLabel">
        <label for="et_er_adtype"><?php _e('Location', 'wp-jobs'); ?></label>
    </div>
    <div class="AdmfrmFld">
        <input name="wp_jobs_location" type="text" id="wp_jobs_location" value="<?php echo esc_html($wp_jobs_location); ?>" />
    </div>
    <br style="clear:both;" />
    <div class="AdmfrmLabel">
        <label for="et_er_adtype"><?php _e('Salary', 'wp-jobs'); ?></label>
    </div>
    <div class="AdmfrmFld">
        <input name="wp_jobs_salary" type="text" id="wp_jobs_salary" value="<?php echo esc_html($wp_jobs_salary); ?>" />
    </div>
    <br style="clear:both;" />
    <div class="AdmfrmLabel">
        <label for="et_er_adtype"><?php _e('Type (Full time, Part time, Contract)', 'wp-jobs'); ?></label>
    </div>
    <div class="AdmfrmFld">
        <input name="wp_jobs_type" type="text" id="wp_jobs_type" value="<?php echo esc_html($wp_jobs_type); ?>" />
    </div>
    <br style="clear:both;" />
    <div class="AdmfrmLabel">
        <label for="et_er_adtype"><?php _e('Form Shortcode', 'wp-jobs'); ?></label>
    </div>
    <div class="AdmfrmFld">
        <input name="wp_jobs_frm" type="text" id="wp_jobs_frm" value="<?php echo esc_html($wp_jobs_frm); ?>" /><br />
        <?php _e('You can add Contact Form 7 shortcode here. This will replace the existing job application form and use the one with this shortcode. Any form shortcode will work.', 'wp-jobs'); ?>
    </div>
    <br style="clear:both;" />
    <?php
}

function wp_jobs_qualification_editor($post) {

    $mypostid = $post->ID;
    $wp_jobs_editor_content = stripslashes(get_post_meta($mypostid, 'wpjobseditorqualification', true));
    $wp_jobs_editor_id = 'wpjobseditorqualification';
    $wp_jobs_editor_settings = array('editor_class' => 'editorbg');

    wp_editor($wp_jobs_editor_content, $wp_jobs_editor_id, $wp_jobs_editor_settings);
}

add_action('add_meta_boxes', 'wp_jobs_qualification_box');

function wp_jobs_qualification_box() {
    add_meta_box(
            'wp_jobs_qualification_section', __('Job Qualification', 'wp-jobs'), 'wp_jobs_qualification_editor', 'job', 'advanced', 'high'
    );
}

add_action('save_post', 'wpjobs_save_info');

function wpjobs_save_info($postID) {
    global $wpdb;
// called after a post or page is saved
    if ($parent_id = wp_is_post_revision($postID)) {
        $postID = $parent_id;
    }
    if (isset($_POST['wp_jobs_designation'])){ update_post_meta($postID, 'wp_jobs_designation', sanitize_text_field($_POST['wp_jobs_designation']));}
    if (isset($_POST['wp_jobs_application_email'])){ update_post_meta($postID, 'wp_jobs_application_email', sanitize_email($_POST['wp_jobs_application_email']));}
    if (isset($_POST['wp_jobs_date_start'])){ update_post_meta($postID, 'wp_jobs_date_start', sanitize_text_field($_POST['wp_jobs_date_start']));}
    if (isset($_POST['wp_jobs_date_close'])){ update_post_meta($postID, 'wp_jobs_date_close', sanitize_text_field($_POST['wp_jobs_date_close']));}
    if (isset($_POST['wp_jobs_location'])){ update_post_meta($postID, 'wp_jobs_location', sanitize_text_field($_POST['wp_jobs_location']));}
    if (isset($_POST['wp_jobs_salary'])){ update_post_meta($postID, 'wp_jobs_salary', sanitize_text_field($_POST['wp_jobs_salary']));}
    if (isset($_POST['wp_jobs_type'])){ update_post_meta($postID, 'wp_jobs_type', sanitize_text_field($_POST['wp_jobs_type']));}
    if (isset($_POST['wp_jobs_frm'])){ update_post_meta($postID, 'wp_jobs_frm', sanitize_text_field($_POST['wp_jobs_frm']));}

    $qlf_html = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'img' => array(
            'src' => array(),
            'title' => array(),
            'alt' => array(),
        ),
        'br' => array(),
        'p' => array(),
        'em' => array(),
        'strong' => array(),
        'ul' => array(),
        'ol' => array(),
        'li' => array(),
        'blockquote' => array(),
        'span' => array(
            'style' => array(),
            'title' => array()
        ),
    );
    if(isset($_POST['wpjobseditorqualification'])) {update_post_meta($postID, 'wpjobseditorqualification', wp_kses($_POST['wpjobseditorqualification'], $qlf_html));}
}

function wp_jobs_shortcode_joblisting() {
    $output = include(plugin_dir_path(__FILE__) . '/template-files/joblisting.php');
    exit();
}

add_filter('template_redirect', 'wp_jobs_applicationformtemp');

function wp_jobs_applicationformtemp() {
    global $post;
    if ('job' === get_post_type()) {
        $outputjob = include(plugin_dir_path(__FILE__) . 'template-files/applicationform.php');
        exit;
    }
}

add_filter('template_redirect', 'wp_jobs_joblisting');

function wp_jobs_joblisting() {
    global $post;
    $wpjobs_pg_pro_list = get_option('wpjobs_pg_pro_list');

    if (get_the_id() == $wpjobs_pg_pro_list) {
        include(plugin_dir_path(__FILE__) . '/template-files/joblisting.php');
        exit;
    }
}

function wp_jobs_get_page_ID_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

function wpjobs_load_scripts($hook) {
    global $PluginDirName, $PluginName, $wpjobs_settings_page;

    /* if ( $hook != $wpjobs_settings_page )
      return; */

    wp_enqueue_script('wpjobs_ajax', plugin_dir_url(__FILE__) . 'js/wpjobs_ajax.js', array('jquery'));
    wp_localize_script('wpjobs_ajax', 'wpjobs_vars', array(
        'wpjobs_nonce' => wp_create_nonce('wpjobs_nonce')
    ));
}

add_action('admin_enqueue_scripts', 'wpjobs_load_scripts');

function wpjobs_ajax_process() {

    if (!isset($_POST['wpjobs_nonce']) || !wp_verify_nonce(($_POST['wpjobs_nonce']), 'wpjobs_nonce'))
        die('Permission denied...');

    $do = sanitize_text_field($_POST['do']);

    if ($do == 'update_wpjobs_options') {
        $pg_id_adv = wp_jobs_get_page_ID_by_slug($_REQUEST['adv_page']);
        update_option('wpjobs_pg_pro_list', sanitize_key($pg_id_adv));
        update_option('wpjobs_send_mail', sanitize_email($_REQUEST['send_mail']));
        echo '<p><strong>' . __('Options saved.', 'wp-jobs') . '</strong></p>';
    }

    die();
}

add_action('wp_ajax_update_wpjobs_options', 'wpjobs_ajax_process');

function wp_jobs_list_shortcode($atts) {
    $wpj_args = shortcode_atts(array(
        'num' => 0,
        'dept' => 0,
            ), $atts);
    /*
     */
    if ($wpj_args['dept'] > 0) {
        $myquery = array(
            'post_type' => 'job',
            'posts_per_page' => $wpj_args['num'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'department',
                    'field' => 'id',
                    'terms' => $wpj_args['dept'],
                ),
            ),
        );
        /*
          $myquery['tax_query'] = array(
          array(
          'taxonomy' => 'department',
          'terms' => $wpj_args['dept'],
          'field' => 'id',
          'post_type' => 'job',
          'post_status' => 'publish',
          )); */
    } else {
        $myquery = array(
            'posts_per_page' => $wpj_args['num'],
            'post_type' => 'job',
            'post_status' => 'publish'
        );
    }

    $string = '';
    $query = new WP_Query($myquery);
    if ($query->have_posts()) {
        $string .= '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            $string .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
        }
        $string .= '</ul>';
    }
    wp_reset_postdata();
    return $string;
}

add_shortcode("job_listing", "wp_jobs_list_shortcode");
