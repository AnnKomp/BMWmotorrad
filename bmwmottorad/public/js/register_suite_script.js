const accounttype = document.querySelector('#accounttype');
var selectedOption = accounttype.value;
var inputFieldWrapper = document.querySelector('#companynamediv');

if (selectedOption == 'professionnal') {
    inputFieldWrapper.style.display = 'block';
    inputFieldWrapper.require = true;
} else {
    inputFieldWrapper.style.display = 'none';
    inputFieldWrapper.require = false;
}

accounttype.addEventListener('change', function () {
    var selectedOption = accounttype.value;
    if (selectedOption == 'professionnal') {
        inputFieldWrapper.style.display = 'block';
        inputFieldWrapper.require = true;
    } else {
        inputFieldWrapper.style.display = 'none';
        inputFieldWrapper.require = false;
    }
});
