// Keep the filters selection while reloading
window.onload = function () {
    var form = document.getElementById('filterForm');
    var inputs = form.getElementsByTagName('select');
    var checkbox = document.getElementsByName('tendencies')[0];

    for (var i = 0; i < inputs.length; i++) {
        var name = inputs[i].name;
        var value = localStorage.getItem(name);

        if (value !== null) {
            inputs[i].value = value;
        }
    }

    var checkboxValue = localStorage.getItem('tendencies');

    if (checkboxValue !== null) {
        checkbox.checked = checkboxValue === 'true';
    }
};

document.getElementById('filterForm').addEventListener('submit', function () {
    var inputs = this.getElementsByTagName('select');
    var checkbox = document.getElementsByName('tendencies')[0];

    for (var i = 0; i < inputs.length; i++) {
        localStorage.setItem(inputs[i].name, inputs[i].value);
    }

    localStorage.setItem('tendencies', checkbox.checked);
});
