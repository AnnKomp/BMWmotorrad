document.querySelector('#accounttype').addEventListener('change', function () {
    var selectedOption = this.value;
    var inputFieldWrapper = document.querySelector('#companynamediv');

    if (selectedOption === 'professionnal') {
        inputFieldWrapper.style.display = 'block';
        inputFieldWrapper.require = true;
    } else {
        inputFieldWrapper.style.display = 'none';
        inputFieldWrapper.require = false;
    }
});