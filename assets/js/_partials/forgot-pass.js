import { disableFormSubmit, enableFormSubmit, loading, resetForm, showErrorMessage } from "../helper";

/* ------------------------------- *
 * 
 * Login Ajax
 * 
 --------------------------------- */
jQuery(function ($) {

    /* ------------------------------- *
    * 
    * Forgot password ajax
    * 
    --------------------------------- */
    const forgetPasswordFormId = '#forget-password-form';
    const user_login = $(forgetPasswordFormId).find('input[name="user-login"]');

    $(forgetPasswordFormId).submit(function (e) {
        e.preventDefault();
        const data = {
            'action': 'lostpassword',
            'user_login': user_login.val()
        };

        resetForm(forgetPasswordFormId);
        loading(forgetPasswordFormId, true);

        $.ajax({
            type: 'POST',
			url: '/wp-admin/admin-ajax.php',
            data: data,
            success: function (response) {
                if (!response.success) {
                    $('.top-error').html(response.data.message).show();
                    loading(forgetPasswordFormId, false);
                    return;
                }

                const success_message = `<strong>Password reset link sent</strong>
                <p><small>Please click on the confirmation link that was just sent to your email address.</small></p>`;

                $('.forgot-success').html(success_message).show();
                loading(forgetPasswordFormId, false);
            }
        });
    });


    /* ------------------------------- *
    * 
    * Forgot password Validation
    * 
    --------------------------------- */
    // on blur validate login input text
    user_login.on('blur', function () {

        const username = $(this).val();
        if (!username) {
            showErrorMessage($(this), 'Username or Email field is required');
            disableFormSubmit(forgetPasswordFormId);
            return;
        }

        // validate email
        if (username.includes('@')) {
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/.test(username)) {
                showErrorMessage($(this), 'Email address is invalid.');
                disableFormSubmit(forgetPasswordFormId);
                return;
            }
        }


        if (!/^[a-zA-Z0-9@.]+$/.test(username)) {
            showErrorMessage($(this), 'Username must be alphanumeric characters.');
            disableFormSubmit(forgetPasswordFormId);
            return;
        }

        resetForm(forgetPasswordFormId);
        $(this).closest('.input-group').removeClass('error');
        $(this).closest('.input-group').find('.error-message').html('');
        enableFormSubmit(forgetPasswordFormId);
    })

})