// Read current mode from localStorage (default: card view)
let viewMode = localStorage.getItem('gradesView') || 'card';

const cardListSwitch = document.getElementById('cardListSwitch');

function applyViewMode() {
  if (viewMode === 'list') {
    document.body.classList.add('listmode');
    document.body.classList.remove('cardmode');
  } else {
    document.body.classList.add('cardmode');
    document.body.classList.remove('listmode');
  }
}

// Apply mode on page load
applyViewMode();

// Toggle when the icon group is clicked
cardListSwitch.addEventListener('click', () => {
  viewMode = (viewMode === 'card') ? 'list' : 'card';
  localStorage.setItem('gradesView', viewMode);
  applyViewMode();
});