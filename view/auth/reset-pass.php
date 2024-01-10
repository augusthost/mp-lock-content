<div class="w-full my-2">
	<div class="lg:p-12 max-w-[500px] lg:my-0 mx-auto p-6 space-y-">
		<form id="reset-password-form" action="#" method="post" class="p-6 lg:p-10 lg:py-[5rem] space-y-3 relative bg-white shadow-lg rounded">
			<h1 class="text-center font-bold lg:text-4xl text-2xl text-[#f7b134] uppercase"> Reset Password </h1>
            <div class="reset-error text-base text-red-500 p-4 rounded bg-red-50" style="display:none"></div>
            <div class="reset-success text-base text-green-500 p-4 rounded bg-green-50" style="display:none"></div>
			<div class="input-group">
				<label class="mb-0"> New Password </label>
				<input type="password" name="pwd" class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
                <div class="error-message text-base text-red-500"></div>
			</div>
            <div class="input-group">
				<label class="mb-0"> Confirm New Password </label>
				<input type="password" name="confirm_pwd" class="h-[45px] mt-2 !border border-gray-300 focus:outline-none focus:border-[#f7b134] focus:border px-3 rounded w-full">
                <div class="error-message text-base text-red-500"></div>
			</div>
			<div class="input-group">
			<input type="hidden" name="key" value="<?= $_GET['key'] ?? ''; ?>">
			<input type="hidden" name="login" value="<?= $_GET['login'] ?? ''; ?>">
				<button type="submit" class="block border-0 w-full bg-[#f7b134] rounded text-white"> Reset </button>
				<div class="mp-loading my-2" style="display:none; margin-top:20px;"><span class="loader"></span></div>
			</div>
		</form>
	</div>
</div>