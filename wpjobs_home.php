<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly                      ?>
<h1>WP Jobs - <?php _e('Home', 'wp-jobs'); ?></h1>

<p><?php
    _e('Thank you for choosing WP Jobs plugin. I hope you will like the plugin and enjoy using it. '
            . 'If you have any support or sales related queries, please feel free to send an email to ', 'wp-jobs');
    ?>
    <a href="mailto:sales@intensewp.com">sales@intensewp.com</a></p>
<p><?php _e('You can also visit our ', 'wp-jobs'); ?><a href="http://support.intensewp.com/" target="_blank"><?php _e('Support Help Desk by clicking here', 'wp-jobs'); ?></a></p>
<h3><?php _e('What\'s new?', 'wp-jobs'); ?></h3>

<ul style="list-style: disc inside none;">
    <li><?php _e('[NEW] You can use Contact Form 7 or any other form plugin and place its shortcode for CV/Resume application and replace the default application form', 'wp-jobs'); ?></li>
    <li><?php _e('[NEW] Redesigned job listing and job detail pages', 'wp-jobs'); ?></li>
    <li><a href="admin.php?page=JobSettings"><?php _e('Set up your custom page to call job listings', 'wp-jobs'); ?></a></li>
    <li><?php _e('List jobs by shortcode', 'wp-jobs'); ?></li>
    <li><?php _e('Custom job types and departments', 'wp-jobs'); ?></li>
    <li><?php _e('Application email notification', 'wp-jobs'); ?></li>
    <li><?php _e('More features coming soon', 'wp-jobs'); ?></li>
</ul>
<h3><?php _e('How to use Shortcode?', 'wp-jobs'); ?></h3>
<ul style="list-style: disc inside none;">
    <li><?php _e('Use shortcode to display job listing [job_listing num=2]. Remove num parameter to show all jobs, change num to limit number of jobs listing.', 'wp-jobs'); ?></li>
    <li><?php _e('To display job listing by department only, use [job_listing dept=2]. Replace 2 with the actual department ID in your site.', 'wp-jobs'); ?></li>
    <li><?php _e('Example: Using [job_listing num=3 dept=2] will show 3 jobs from the Department ID 2.', 'wp-jobs'); ?></li>
</ul>
<hr />

<h3><?php _e('Stay Updated and get more customized features directly to your inbox', 'wp-jobs'); ?></h3>
<p>
    <!-- Begin MailChimp Signup Form -->
    <link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
    #mc_embed_signup{clear:left; font:14px Helvetica,Arial,sans-serif; }
    /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
       We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
    <form action="http://etechy101.us8.list-manage.com/subscribe/post?u=0feea2b1671b773d914b338e6&amp;id=8ca20a276b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        <?php _e('<strong>We promise, your email will not be shared or spammed ever.</strong> Leave your email below', 'wp-jobs'); ?>
        <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="<?php _e('email address', 'wp-jobs'); ?>" required>
        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        <div style="position: absolute; left: -5000px;"><input type="text" name="b_b8210f8523d1e31f37518d48e_155e3516fe" value=""></div>
        <div class="clear"><input type="submit" value="<?php _e('Join', 'wp-jobs'); ?>" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </form>
</div>
ِ<br /><br />