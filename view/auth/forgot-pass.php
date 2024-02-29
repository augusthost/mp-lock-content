<div class="w-full my-2">
	<div class="lg:p-12 max-w-[500px] lg:my-0 mx-auto p-6 space-y-">
		<form id="forget-password-form" action="#" method="post" class="p-6 lg:p-10 lg:py-[5rem] space-y-3 relative bg-white shadow-lg rounded">
			<h1 class="text-center font-bold lg:text-4xl text-2xl text-[#f7b134] uppercase"> Forget Password </h1>
			<p class="text-[1.2rem] text-center">You will receive a link to create a new password via email.</p>
            <div class="top-error text-[1.2rem] text-red-500 p-4 rounded bg-red-50" style="display:none"></div>
            <div class="forgot-success text-[1.2rem] text-green-500 p-4 rounded bg-green-50" style="display:none"></div>
			<div class="input-group">
				<label class="mb-0"> Username or Email Address </label>
				<input type="text" name="user-login" class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
                <div class="error-message text-[1.2rem] text-red-500"></div>
			</div>
			<div class="input-group">
				<button type="submit" class="block border-0 w-full bg-[#f7b134] rounded text-white py-2 mt-4 mb-2"> Submit </button>
				<p class="py-3 text-center !mb-0">
                <a class="text-gray-400" href="<?= home_url('/login'); ?>">
						<small>Login</small>
					</a>
                    <span class="text-gray-400">|</span>
                    <a class="text-gray-400" href="<?= home_url('/sign-up'); ?>">
						<small>Create account</small>
					</a>
				</p>
                <div class="mp-loading" style="display:none;"><span class="loader"></span></div>
			</div>
		</form>
	</div>
</div>