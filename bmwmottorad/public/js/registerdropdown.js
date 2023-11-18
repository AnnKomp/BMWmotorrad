document.querySelector('#typedropdown').addEventListener('change', function () {
    var selectedOption = this.value;
    var inputFieldWrapper = document.querySelector('#companynamediv');

    if (selectedOption === 'professionnal') {
        inputFieldWrapper.style.display = 'block';
    } else {
        inputFieldWrapper.style.display = 'none';
    }
});