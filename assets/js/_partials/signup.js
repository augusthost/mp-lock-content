/* ------------------------------- *
 * 
 * Signup Form Ajax
 * 
 --------------------------------- */
jQuery(function ($) {

	/* -----------------Helper----------------- */

	const disableFormSubmit = (formId) => {
		const submitBtn = document.querySelector(`${formId} button[type='submit']`)
		submitBtn.disabled = true;
	}

	const enableFormSubmit = (formId) => {
		const form = document.querySelector(formId + ' .input-group');
		if (form.classList.contains('error')) return;
		const submitBtn = document.querySelector(formId + ' button[type="submit"]');
		submitBtn.disabled = false;
	}

	const resetForm = (formId) => {
		const signupError = document.querySelector(`${formId} .signup-error`);
		signupError.style.display = 'none';
	}

	const showErrorMessage = (ele, msg) => {
		const inputGroup = ele.closest(".input-group");
		inputGroup.addClass('error');
		inputGroup.find(".error-message").html(msg);
	}

	const loading = (currentForm, show) => {
		if (show) {
			$(`${currentForm} .mp-loading`).show();
			disableFormSubmit(currentForm)
			return;
		}
		$(`${currentForm} .mp-loading`).hide();
		enableFormSubmit(currentForm)
	}

	/* ----------------------------------------------- */


	const formId = '#mp-signup-form';

	const userInput = $(formId).find('input[name="log"]');
	const passInput = $(formId).find('input[name="pwd"]');
	const confirmPassInput = $(formId).find('input[name="confirm_pwd"]');
	const nonce = $(formId).find('input[name="nonce"]');

	// Signup Ajax
	$(formId).submit(function (e) {
		e.preventDefault();

		if (!userInput.val() || !passInput.val() || !confirmPassInput.val()) {
			$(formId).find('.signup-error').html('Please fill all fields').show();
			return;
		}

		const data = {
			'action': 'signup',
			'log': userInput.val(),
			'pwd': passInput.val(),
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
					loading(formId, false);
					return;
				}
				$(formId).find('.signup-error').html(`${response.data.message}`).show();
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
	// on blur validate login input text
	userInput.on('blur', function () {

		const email = $(this).val();
		if (!email) {
			showErrorMessage($(this), 'Email is required');
			disableFormSubmit(formId);
			return;
		}

		// validate email
		if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
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