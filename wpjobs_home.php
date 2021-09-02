<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly
?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

<div class="wrap">
  <h1>Dashboard</h1>
  <div id="welcome-panel" class="welcome-panel">
    <div class="welcome-panel-content">
      <h1 class="text-center mb"><?php _e('Welcome to', 'wp-jobs');?> WP Jobs!</h1>
      <p class="about-description">Here are some details to get you started:</p>
      <div class="welcome-panel-column-container">
        <div class="welcome-panel-column">
          <h3>Get Started - The Jobs Custom Post Type (CPT)</h3>
          <a class="button button-primary button-hero" href="<?php echo admin_url('edit.php?post_type=job');?>">Create A Job</a>
        </div>
        <div class="welcome-panel-column">
          <h3>Next Steps</h3>
          <ul>
            <li class="dflex"> <i class="fas fa-wallet mr10 pt3"></i><a style="list-style:disc" href="<?php echo admin_url('admin.php?page=JobSettings');?>">Navigate to the Settings page and setup your Email Notifications for Jobs and your Jobs Listing Page</a> </li>
            <li class="dflex"> <i class="fas fa-code mr10 pt3"></i><a href="#shortcodes">Alternatively, you can choose the type of jobs you want to display on a page using our Shortcodes, explained below.</a> </li>
          </ul>
        </div>
        <div class="welcome-panel-column welcome-panel-last">
          <h3>Support</h3>
          <ul>
            <li><?php
                _e('Thank you for choosing WP Jobs plugin. We hope you will like the plugin and enjoy using it. Please leave us a review if you like our plugin.', 'wp-jobs');
                ?>
            </li>
            <li><?php _e('If you have any support or sales related queries, please feel free to send an email to ', 'wp-jobs')?> <a href="mailto:support@99robots.com">support@99robots.com</a></li>
            <li><?php _e('You can also visit our ', 'wp-jobs'); ?><a href="http://support.intensewp.com/" target="_blank"><?php _e('Support Help Desk by clicking here', 'wp-jobs'); ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="wrap">
  <div class="whatsnew info-box pull-left">
    <h3><?php _e('What\'s new?', 'wp-jobs'); ?></h3>

    <ul style="list-style: disc inside none;">
        <li><?php _e('<span class="text-green fs16">[NEW]</span> You can use Contact Form 7 or any other form plugin and place its shortcode for CV/Resume application and replace the default application form', 'wp-jobs'); ?></li>
        <li><?php _e('<span class="text-green fs16">[NEW]</span> Redesigned job listing and job detail pages. Make sure you update the permalinks for post in Settings > Permalinks to avoid getting a Page Not Found error.', 'wp-jobs'); ?></li>
        <li><a href="admin.php?page=JobSettings"><?php _e('Set up your custom page to call job listings', 'wp-jobs'); ?></a></li>
        <li><?php _e('List jobs by shortcode', 'wp-jobs'); ?></li>
        <li><?php _e('Custom job types and departments', 'wp-jobs'); ?></li>
        <li><?php _e('Application email notification', 'wp-jobs'); ?></li>
        <li><?php _e('More features coming soon', 'wp-jobs'); ?></li>
    </ul>
  </div>
  <div id="shortcodes" class="shortcode info-box pull-right">
    <h3><?php _e('How to use Shortcode?', 'wp-jobs'); ?></h3>
    <ul style="list-style: disc inside none;">
        <li><?php _e('Use shortcode to display job listing [job_listing num=2]. Remove num parameter to show all jobs, change num to limit number of jobs listing.', 'wp-jobs'); ?></li>
        <li><?php _e('To display job listing by department only, use [job_listing dept=2]. Replace 2 with the actual department ID in your site.', 'wp-jobs'); ?></li>
        <li><?php _e('Example: Using [job_listing num=3 dept=2] will show 3 jobs from the Department ID 2.', 'wp-jobs'); ?></li>
    </ul>
    <p class="fs16"><strong>Note:</strong> To easily get the IDs of posts, pages, custom posts, you can use our plugin - <a href="https://wordpress.org/plugins/wpsite-show-ids/">Show IDs by 99 Robots</a></p>
  </div>
</div>
<div class="clearfix">
</div>
