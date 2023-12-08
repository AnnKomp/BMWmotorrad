// Keep the filters selection while reloading
window.onload = function () {
    var form = document.getElementById('filterForm');
    var inputs = form.getElementsByTagName('select');
    var checkbox = document.getElementsByName('tendencies')[0];
    var fromSlider = document.getElementById('fromSlider');
    var toSlider = document.getElementById('toSlider');
    var fromInput = document.getElementById('fromInput');
    var toInput = document.getElementById('toInput');

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

    var fromSliderValue = localStorage.getItem('fromSlider');
    var toSliderValue = localStorage.getItem('toSlider');

    if (fromSliderValue !== null) {
        fromSlider.value = fromSliderValue;
        fromInput.value = fromSliderValue;
    }

    if (toSliderValue !== null) {
        toSlider.value = toSliderValue;
        toInput.value = toSliderValue;
    }
};

document.getElementById('filterForm').addEventListener('submit', function () {
    var inputs = this.getElementsByTagName('select');
    var checkbox = document.getElementsByName('tendencies')[0];
    var fromSlider = document.getElementById('fromSlider');
    var toSlider = document.getElementById('toSlider');

    for (var i = 0; i < inputs.length; i++) {
        localStorage.setItem(inputs[i].name, inputs[i].value);
    }

    localStorage.setItem('tendencies', checkbox.checked);
    localStorage.setItem('fromSlider', fromSlider.value);
    localStorage.setItem('toSlider', toSlider.value);
});


// Double bar

function controlFromInput(fromSlider, fromInput, toInput, controlSlider) {
    const [from, to] = getParsed(fromInput, toInput);
    fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
    if (from > to) {
        fromSlider.value = to;
        fromInput.value = to;
    } else {
        fromSlider.value = from;
    }
}

function controlToInput(toSlider, fromInput, toInput, controlSlider) {
    const [from, to] = getParsed(fromInput, toInput);
    fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
    setToggleAccessible(toInput);
    if (from <= to) {
        toSlider.value = to;
        toInput.value = to;
    } else {
        toInput.value = from;
    }
}

function controlFromSlider(fromSlider, toSlider, fromInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
  if (from > to) {
    fromSlider.value = to;
    fromInput.value = to;
  } else {
    fromInput.value = from;
  }
}

function controlToSlider(fromSlider, toSlider, toInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
  setToggleAccessible(toSlider);
  if (from <= to) {
    toSlider.value = to;
    toInput.value = to;
  } else {
    toInput.value = from;
    toSlider.value = from;
  }
}

function getParsed(currentFrom, currentTo) {
  const from = parseInt(currentFrom.value, 10);
  const to = parseInt(currentTo.value, 10);
  return [from, to];
}

function fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
    const rangeDistance = to.max-to.min;
    const fromPosition = from.value - to.min;
    const toPosition = to.value - to.min;
    controlSlider.style.background = `linear-gradient(
      to right,
      ${sliderColor} 0%,
      ${sliderColor} ${(fromPosition)/(rangeDistance)*100}%,
      ${rangeColor} ${((fromPosition)/(rangeDistance))*100}%,
      ${rangeColor} ${(toPosition)/(rangeDistance)*100}%,
      ${sliderColor} ${(toPosition)/(rangeDistance)*100}%,
      ${sliderColor} 100%)`;
}

function setToggleAccessible(currentTarget) {
  const toSlider = document.querySelector('#toSlider');
  if (Number(currentTarget.value) <= 0 ) {
    toSlider.style.zIndex = 2;
  } else {
    toSlider.style.zIndex = 0;
  }
}

const fromSlider = document.querySelector('#fromSlider');
const toSlider = document.querySelector('#toSlider');
const fromInput = document.querySelector('#fromInput');
const toInput = document.querySelector('#toInput');
fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
setToggleAccessible(toSlider);

fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);
fromInput.oninput = () => controlFromInput(fromSlider, fromInput, toInput, toSlider);
toInput.oninput = () => controlToInput(toSlider, fromInput, toInput, toSlider);
