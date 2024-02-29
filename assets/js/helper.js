export const disableFormSubmit = (formId) => {
    const submitBtn = document.querySelector(`${formId} button[type='submit']`)
    submitBtn.disabled = true;
}

export const enableFormSubmit = (formId) => {
    const form = document.querySelector(formId + ' .input-group');
    if (form.classList.contains('error')) return;
    const submitBtn = document.querySelector(formId + ' button[type="submit"]');
    submitBtn.disabled = false;
}

export const resetForm = (formId) => {
    const topError = document.querySelector(`${formId} .top-error`);
    topError.style.display = 'none';
}

export const showErrorMessage = (ele, msg) => {
    const inputGroup = ele.closest(".input-group");
    inputGroup.addClass('error');
    inputGroup.find(".error-message").html(msg);
}

export const loading = (formId, show) => {
    if (show) {
        jQuery(`${formId} .mp-loading`).show();
        disableFormSubmit(formId)
        return;
    }
    jQuery(`${formId} .mp-loading`).hide();
    enableFormSubmit(formId)
}


export const validatePhone = (input) => {
    const isNum = /^\d+$/.test(input);
    if(!isNum) return false;
    return input.length >= 5 && input.length <= 14;
}
