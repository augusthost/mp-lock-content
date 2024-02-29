<div id="mp-signup-form" class="w-full my-2">
	<div class="lg:p-12 max-w-[560px] lg:my-0 mx-auto p-6 space-y-">
		<form action="<?php echo esc_url( site_url( 'wp-login.php', 'login' ) ); ?>" method="post" class="p-6 lg:p-10 lg:py-[5rem] space-y-3 relative bg-white shadow-lg rounded">
			<h1 class="text-center font-bold lg:text-4xl text-2xl text-[#f7b134] uppercase"> Sign Up </h1>
            <div class="top-error text-[1.2rem] text-red-500 p-4 rounded bg-red-50" style="display:none"></div>
            <div class="signup-success text-[1.2rem] text-green-500 p-4 rounded bg-green-50" style="display:none"></div>
			<div class="flex gap-4">
				<div class="input-group">
					<label class="mb-0"> First Name <span class="text-red-500 text-base inline-flex items-center">*</span></label>
					<input type="text" name="first_name"  class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
					<div class="error-message text-[1.2rem] text-red-500"></div>
				</div>
				<div class="input-group">
					<label class="mb-0"> Last Name <span class="text-red-500 text-base inline-flex items-center">*</span></label>
					<input type="text" name="last_name"  class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
					<div class="error-message text-[1.2rem] text-red-500"></div>
				</div>
			</div>
			<div class="input-group">
				<label class="mb-0"> Email Address <span class="text-red-500 text-base inline-flex items-center">*</span></label>
				<input type="email" name="log"  class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
                <div class="error-message text-[1.2rem] text-red-500"></div>
				<div class="text-[1.2rem] text-gray-600">Please provide your work email instead of personal email.</div>
			</div>
			<div class="input-group">
				<label class="mb-0"> Phone Number </label>
				<input type="text" name="phone"  class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
                <div class="error-message text-[1.2rem] text-red-500"></div>
			</div>
			<div class="input-group">
				<label class="mb-0"> Organization Name <span class="text-red-500 text-base inline-flex items-center">*</span></label>
				<input type="text" name="organization"  class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
                <div class="error-message text-[1.2rem] text-red-500"></div>
			</div>
			<div class="input-group">
				<label class="mb-0"> Password <span class="text-red-500 text-base inline-flex items-center">*</span></label>
				<input type="password" name="pwd"  class="h-[45px] mt-2 border border-gray-300 focus:outline-none !focus:border-[#f7b134] focus:border !px-3 !rounded w-full">
                <div class="error-message text-[1.2rem] text-red-500"></div>
			</div>
            <div class="input-group">
				<label class="mb-0"> Confirm Password <span class="text-red-500 text-base inline-flex items-center">*</span></label>
				<input type="password" name="confirm_pwd"  class="h-[45px] mt-2 border border-gray-300 focus:outline-none !focus:border-[#f7b134] focus:border !px-3 !rounded w-full">
                <div class="error-message text-[1.2rem] text-red-500"></div>
			</div>
			<div class="input-group">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('mp_signup_nonce'); ?>">
				<button type="submit" class="block border-0 w-full bg-[#f7b134] rounded text-white py-2 mt-4 mb-2"> Signup </button>
				<p class="py-3 text-center !mb-0">
					<span class="text-gray-400">
						<small>Has account?</small>
					</span>
                    <a class="text-gray-400" href="<?= home_url('/login'); ?>">
						<small>Login Here</small>
					</a>
				</p>
			</div>
			<div class="mp-loading" style="display:none;"><span class="loader"></span></div>
		</form>
	</div>
</div>