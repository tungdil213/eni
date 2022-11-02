console.log('Start Hello-Elementor')

var acc = document.getElementsByClassName('accordion');

for (let i = 0; i < acc.length; i++) {
  acc[i].addEventListener('click', function () {
    activeElement(this);
    console.log('Riko', this);
  });
}

const activeElement = (el) => {
  el.classList.toggle('active');
  callNextPanel(el.nextElementSibling);
};

const nextElementIsPanel = (el) => {
  return el ? el.classList.contains('accordeon-panel') : null;
};

const openPanel = (panel) => {
  panel.style.maxHeight = panel.style.maxHeight
    ? null
    : panel.scrollHeight + 'px';
  callNextPanel(panel.nextElementSibling);
};

const callNextPanel = (el) => {
  nextElementIsPanel(el) && openPanel(el);
};