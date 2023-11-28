const accounttype = document.querySelector('#accounttype');
var selectedOption = accounttype.value;
var inputFieldWrapper = document.querySelector('#companynamediv');

// The value of the dropdown is check once at the start of the script in case the user was redirect because an information was invalid
if (selectedOption == 'professionnal') {
    inputFieldWrapper.style.display = 'block';
    inputFieldWrapper.require = true;
} else {
    inputFieldWrapper.style.display = 'none';
    inputFieldWrapper.require = false;
}

// EventListener that manages the visibility of the inputFildWrapper depending on the chose value in accounttype
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
