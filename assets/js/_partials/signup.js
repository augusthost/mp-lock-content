import { disableFormSubmit, enableFormSubmit, loading, resetForm, showErrorMessage, validatePhone } from "../helper";

/* ------------------------------- *
 * 
 * Signup Form Ajax
 * 
 --------------------------------- */
jQuery(function ($) {

	const formId = '#mp-signup-form';

	const fnameInput  = $(formId).find('input[name="first_name"]');
	const lnameInput  = $(formId).find('input[name="last_name"]');
	const orgInput    = $(formId).find('input[name="organization"]');
	const phoneInput  = $(formId).find('input[name="phone"]');
	const userInput   = $(formId).find('input[name="log"]');
	const passInput   = $(formId).find('input[name="pwd"]');
	const confirmPassInput = $(formId).find('input[name="confirm_pwd"]');
	const nonce = $(formId).find('input[name="nonce"]');

	// Signup Ajax
	$(formId).submit(function (e) {
		e.preventDefault();

		if (!userInput.val() || !passInput.val() || !confirmPassInput.val()) {
			$(formId).find('.top-error').html('Please fill all fields').show();
			return;
		}

		const data = {
			'action': 'signup',
			'log': userInput.val(),
			'pwd': passInput.val(),
			'phone': phoneInput.val(),
			'organization': orgInput.val(),
			'first_name': fnameInput.val(),
			'last_name': lnameInput.val(),
			'nonce': nonce.val()
		};

		resetForm(formId);
		loading(formId, true);
		$.ajax({
			type: 'POST',
			url: '/wp-admin/admin-ajax.php',
			data: data,
			success: function (response) {

				if (response.success) {
					$(formId).find('.signup-success').html(`${response.data.message}`).show()
					// reset form
					userInput.val('');
					passInput.val('');
					confirmPassInput.val('');
					orgInput.val('');
					fnameInput.val('');
					lnameInput.val('');
					phoneInput.val('');
					loading(formId, false);
					$("html, body").animate({ scrollTop: 0 }, "fast");
					return;
				}
				$(formId).find('.top-error').html(`${response.data.message}`).show();
				// reset form
				userInput.val('');
				passInput.val('');
				confirmPassInput.val('');
				loading(formId, false);
			},
			error: function (response) {
				loading(formId, false);
			}
		});
	});




	/* ------------------------------- *
	* 
	* Signup Validation
	* 
	--------------------------------- */
	fnameInput.on('blur', function(){
		const fname = $(this).val();
		if (!fname) {
			showErrorMessage($(this), 'First Name is required.');
			disableFormSubmit(formId);
			return;
		}
		if (fname.length < 3) {
			showErrorMessage($(this), 'First Name is too short');
			disableFormSubmit(formId);
			return;
		}
		resetForm(formId);
		$(this).closest('.input-group').removeClass('error');
		$(this).closest('.input-group').find('.error-message').html('');
		enableFormSubmit(formId);
	})

	lnameInput.on('blur', function(){
		const lname = $(this).val();
		if (!lname) {
			showErrorMessage($(this), 'Last Name is required.');
			disableFormSubmit(formId);
			return;
		}
		if (lname.length < 3) {
			showErrorMessage($(this), 'Last Name is too short');
			disableFormSubmit(formId);
			return;
		}
		resetForm(formId);
		$(this).closest('.input-group').removeClass('error');
		$(this).closest('.input-group').find('.error-message').html('');
		enableFormSubmit(formId);
	})


	orgInput.on('blur', function(){
		const organization = $(this).val();
		if (!organization) {
			showErrorMessage($(this), 'Organization Name is required.');
			disableFormSubmit(formId);
			return;
		}
		if (organization.length < 3) {
			showErrorMessage($(this), 'Organization Name is too short');
			disableFormSubmit(formId);
			return;
		}
		resetForm(formId);
		$(this).closest('.input-group').removeClass('error');
		$(this).closest('.input-group').find('.error-message').html('');
		enableFormSubmit(formId);
	})


	phoneInput.on('blur', function(){
		const phone = $(this).val();
		if(!phone) return;
		if(!validatePhone(phone)) {
			showErrorMessage($(this), 'Phone number must be 5-8 digits.');
			disableFormSubmit(formId);
			return;
		}
		resetForm(formId);
		$(this).closest('.input-group').removeClass('error');
		$(this).closest('.input-group').find('.error-message').html('');
		enableFormSubmit(formId);
	})

	// on blur validate login input text
	userInput.on('blur', function () {

		const email = $(this).val();
		if (!email) {
			showErrorMessage($(this), 'Email is required');
			disableFormSubmit(formId);
			return;
		}

		// validate email
		if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/.test(email)) {
			showErrorMessage($(this), 'Email address is invalid.');
			disableFormSubmit(formId);
			return;
		}

		resetForm(formId);
		$(this).closest('.input-group').removeClass('error');
		$(this).closest('.input-group').find('.error-message').html('');
		enableFormSubmit(formId);
	})

	// on blur validate password input
	passInput.on('blur', function () {

		const password = $(this).val();
		if (!password) {
			showErrorMessage($(this), 'Password is required');
			disableFormSubmit(formId);
			return;

		}

		if (!password.match(/^(?=.*\d)(?=.*[a-z]).{8,}$/)) {
			showErrorMessage($(this), 'Password: min 8 chars, 1 letter, 1 number.');
			disableFormSubmit(formId);
			return;
		}

		$(this).closest('.input-group').removeClass('error');
		$(this).closest('.input-group').find('.error-message').html('');
		resetForm(formId);
		enableFormSubmit(formId);
	})


	confirmPassInput.on('blur', function () {

		if (!$(this).val()) {
			showErrorMessage($(this), 'Confirm password is required');
			disableFormSubmit(formId);
			return;

		}

		if (passInput.val() !== confirmPassInput.val()) {
			showErrorMessage($(this), 'Password does not match');
			showErrorMessage(confirmPassInput, 'Password does not match');
			disableFormSubmit(formId);
			return;
		}

		$(confirmPassInput).closest('.input-group').removeClass('error');
		$(confirmPassInput).closest('.input-group').find('.error-message').html('');
		resetForm(formId);
		enableFormSubmit(formId);
	})

})