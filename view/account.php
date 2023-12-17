<?php
$current_user_id   = get_current_user_id(); // Get the current user's ID
$user_data         = get_userdata($current_user_id); // Get the user data based on the ID
?>
<div class="account mx-auto max-w-[600px] my-8 rounded shadow bg-white p-8">
<h2>Profile</h2>
<p><?php echo $user_data->first_name . ' ' . $user_data->last_name; ?></p>
<p><?php echo $user_data->user_login; ?></p>
<p><?php echo $user_data->user_email; ?></p>
<hr />
<p><a href="<?php echo wp_logout_url('/redirect/url/goes/here') ?>">Log out</a></p>
</div>