import { disableFormSubmit, enableFormSubmit, loading, resetForm, showErrorMessage } from "../helper";

(function($) {
    $(document).ready(function() {

    const formId = '#reset-password-form';
    const passInput = $(formId).find('input[name="pwd"]');
    const confirmPassInput = $(formId).find('input[name="confirm_pwd"]');

      // AJAX request on form submission
      $(formId).on('submit', function(e) {
        e.preventDefault();
  
        // Get form data
        const form = $(this);
        const key = form.find('input[name="key"]').val();
        const login = form.find('input[name="login"]').val();
      

        loading(formId,true);

        // AJAX request
        $.ajax({
          url: '/wp-admin/admin-ajax.php', // The AJAX URL provided by WordPress
          type: 'POST',
          data: {
            action: 'resetpassword', // The AJAX action defined in your PHP code
            key: key,
            login: login,
            password: passInput.val()
          },
          beforeSend: function() {
            // Show loading spinner or any other pre-request actions
          },
          success: function(response) {
            if (!response.success) {
                $('.top-error').html(response.data.message).show();
                loading(formId, false);
                return;
            }

            const success_message = `<strong>Your password is reset.</strong>
            <p><small><a href="/login">Click here</a> login with your new password.</small></p>`;

            $('.reset-success').html(success_message).show();
            loading(formId, false);
          },
          error: function() {
            // Handle error response
            console.log('AJAX request failed');
          },
          complete: function() {
            // Perform any actions after the request completes
          }
        });


      });


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

    

    });
  })(jQuery);