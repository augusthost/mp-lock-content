/* ------------------------------- *
 * 
 * Login Ajax
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
		const loginError = document.querySelector(`${formId} .login-error`);
		loginError.style.display = 'none';
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

	const formId = '#mp-login-form';

	const userInput = $(formId).find('input[name="log"]');
	const passInput = $(formId).find('input[name="pwd"]');

	// Loign Ajax
	$(formId).submit(function (e) {
		e.preventDefault();
		const data = {
			'action': 'login',
			'log': userInput.val(),
			'pwd': passInput.val(),
			'rememberme': $(formId).find('#rememberme').is(':checked'),
			'redirect_to': $(formId).find('input[name="redirect_to"]').val(),
			'testcookie': $(formId).find('input[name="testcookie"]').val()
		};

		resetForm(formId);
		loading(formId, true);
		$.ajax({
			type: 'POST',
			url: '/wp-admin/admin-ajax.php',
			data: data,
			success: function (response) {
				// Overwrite message from default WP
				if (response.data.code === 'incorrect_password') {
					response.data.message =
						`<strong>Error:</strong> The password you entered for the email address <strong>${userInput.val()}</strong> is incorrect. <a href="/login?action=forgot_pass">Lost your password?</a>`;
				}

				if (response.success) {
					window.location.href = response.data.redirect_to;
					return;
				}
				$(formId).find('.login-error').html(`${response.data.message}`).show();
				loading(formId, false);
			},
			error: function (response) {
				loading(formId, false);
			}
		});
	});

	/* ------------------------------- *
	* 
	* Login Validation
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

		resetForm(formId);
		$(this).closest('.input-group').removeClass('error');
		$(this).closest('.input-group').find('.error-message').html('');
		enableFormSubmit(formId);
	})


})