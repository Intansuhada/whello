import './bootstrap';
import 'bootstrap';

const inviteBtn = document.getElementById('invite-btn');
const invitePopup = document.getElementById('invite-popup');

inviteBtn.addEventListener('click', () => {
    invitePopup.style.display = 'block';
})

const popupCloseBtn = document.getElementById('popup-close-btn');

popupCloseBtn.addEventListener('click', () => {
    invitePopup.style.display = 'none';
})