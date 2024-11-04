<div class="w-full my-2">
	<div class="lg:p-12 max-w-[560px] lg:my-0 mx-auto p-6 space-y-">
		<form id="mp-login-form" action="#" method="post" class="p-6 lg:p-10 lg:py-[5rem] space-y-3 relative bg-white shadow-lg rounded">
			<h1 class="text-center font-bold lg:text-4xl text-2xl text-[#f7b134] uppercase"> Login </h1>
            <div class="top-error text-[1.2rem] text-red-500 rounded p-4 bg-red-50" style="display:none"></div>
			<div class="input-group">
				<label class="mb-0"> Email Address <span class="text-red-500 text-base inline-flex items-center">*</span></label>
				<input type="text" name="log"  class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
                <div class="error-message text-[1.2rem] text-red-500"></div>
			</div>
			<div class="input-group">
				<label class="mb-0"> Password <span class="text-red-500 text-base inline-flex items-center">*</span></label>
				<input type="password" name="pwd"  class="h-[45px] mt-2 border border-gray-300 focus:outline-none !focus:border-[#f7b134] focus:border !px-3 !rounded w-full">
                <div class="error-message text-[1.2rem] text-red-500"></div>
			</div>
			<div class="input-group">
                <input type="hidden" name="redirect_to" value="<?= isset($_GET['r']) ? htmlspecialchars($_GET['r']) : ''; ?>">
				<button type="submit" class="block border-0 w-full bg-[#f7b134] rounded text-white py-2 mt-4 mb-2"> Login </button>
				<p class="py-3 text-center !mb-0">
					<a class="text-gray-400" href="/login?action=forgot_pass">
						<small>Forgot Password?</small>
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