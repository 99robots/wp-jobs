<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly                    ?>
<script type="text/javascript">
    function MM_jumpMenu(targ, selObj, restore) { //v3.0
        eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
        if (restore)
            selObj.selectedIndex = 0;
    }
</script>
<h1>WP Jobs - <?php _e('Applications', 'wp-jobs'); ?></h1>
<?php
$job_id = isset($_REQUEST['jobid']) ? sanitize_key($_REQUEST['jobid']) : null;
$jb_args = array(
    'posts_per_page' => -1,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'job',
    'post_status' => 'publish',
    'suppress_filters' => true);

$jobs = get_posts($jb_args);
?>
<form autocomplete="off" name="form" id="form">
    <?php _e('Filter by Job', 'wp-jobs'); ?> <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent', this, 0)">
        <option value="edit.php?post_type=job&page=WPJobsApps"><?php _e('All Applications', 'wp-jobs'); ?></option>
        <?php foreach ($jobs as $job_info) : setup_postdata($jobs); ?>
            <option <?php
            if ($job_info->ID == $job_id) {
                echo 'selected="selected"';
            }
            ?> value="edit.php?post_type=job&page=WPJobsApps&jobid=<?php echo $job_info->ID; ?>"><?php echo $job_info->post_title; ?></option>
                <?php
            endforeach;
            wp_reset_postdata();
            ?>
    </select>
</form>
<style>
    .dctrprt tr th, .dctrprt tr td {
        font-family:Arial, Helvetica, sans-serif;
        font-size:13px;
    }
</style>
<table class="widefat dctrprt">
    <tr>
        <th><strong><?php _e('S. No', 'wp-jobs'); ?></strong></th>
        <th><strong><?php _e('Job Title', 'wp-jobs'); ?></strong></th>
        <th><strong><?php _e('Full Name', 'wp-jobs'); ?></strong></th>
        <th><strong><?php _e('Email', 'wp-jobs'); ?></strong></th>
        <th><strong><?php _e('Phone Number', 'wp-jobs'); ?></strong></th>
        <th><strong><?php _e('Download Resume', 'wp-jobs'); ?></strong></th>
    </tr>

    <?php
    $column_name = "app_id";
    $tbl = $wpdb->prefix;
	  $tablename = $tbl . "app_user_info";
    if (null !== $job_id) {

        $users = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $tablename . " WHERE app_job_id = %d ORDER BY %s DESC ", $job_id, $column_name));

        //$qry = "SELECT * FROM " . $wpdb->prefix . "app_user_info WHERE app_job_id = %d ";
    } else {
        $users = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". $tablename ." ORDER BY %s DESC ", $column_name));
    }
    //$qry .= " ORDER BY `app_id` DESC ";
    //$users = $wpdb->get_results($wpdb->prepare($qry, $job_id));
    $i = 1;

    foreach ($users as $user) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo esc_html(get_the_title($user->app_job_id)); ?></td>
            <td><?php echo esc_html($user->app_name); ?></td>
            <td><?php echo esc_html($user->app_email); ?></td>
            <td><?php echo esc_html($user->app_phn); ?></td>
            <td>
                <?php
                $userCv = $user->app_cv;
                if (!empty($userCv)) {
                    ?>
                    <a download href=" <?php echo $user->app_cv; ?>"><?php _e('Download', 'wp-jobs'); ?></a></td>
                <?php
            } else {
                _e('No resume was attached.', 'wp-jobs');
            }
            ?>
            </td>
        </tr>

        <?php
        $i++;
    }
    ?>
</table>
