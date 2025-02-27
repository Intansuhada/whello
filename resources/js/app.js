    //dropdown
document.addEventListener('DOMContentLoaded', function () {
    const settingsLink = document.querySelector('.sidebar-link.setting');
    const submenu = document.querySelector('.submenu');

    // Cek status submenu di localStorage
    const isSubmenuOpen = localStorage.getItem('submenuOpen') === 'true';

    if (isSubmenuOpen) {
        submenu?.classList.add('active'); // Tampilkan submenu jika sebelumnya terbuka
    }

    settingsLink?.addEventListener('click', function (event) {
        event.preventDefault(); // Mencegah tindakan default dari link

        const isCurrentlyActive = submenu?.classList.toggle('active'); // Toggle kelas 'active'

        // Simpan status submenu ke localStorage
        localStorage.setItem('submenuOpen', isCurrentlyActive);
    });

    // Cek apakah ada menu yang aktif disimpan di localStorage
    const activeMenu = localStorage.getItem('activeMenu');

    if (activeMenu) {
        // Tambahkan class 'active' ke submenu yang sesuai
        const activeLink = document.querySelector(`.submenu-link[data-menu="${activeMenu}"]`);
        if (activeLink) {
            const parentLi = activeLink?.parentElement; // Dapatkan elemen <li> dari <a>
            parentLi.classList.add('active'); // Tambahkan class 'active' ke <li>
        }
    }

    // Tambahkan event listener ke semua submenu-link
    document.querySelectorAll('.submenu-link').forEach(link => {
        link.addEventListener('click', function (event) {
            // Hapus class 'active' dari semua <li>
            document.querySelectorAll('.submenu li').forEach(el => el.classList.remove('active'));

            const parentLi = this.parentElement;
            parentLi.classList.add('active'); // Tambahkan class 'active' ke <li> yang dipilih

            const menuName = this.getAttribute('data-menu');
            localStorage.setItem('activeMenu', menuName);
        });
    });
});


// password reveal
const eyeicon = document.getElementById("eyeicon");
const password = document.getElementById("password");
eyeicon?.addEventListener('click', () => {
    if (password.type == "password") {
        password.type = "text"
        eyeicon.src = "/images/eye.svg"
    } else {
        password.type = "password"
        eyeicon.src = "/images/eye-slash.svg"
    }
})

const inviteBtn = document.getElementById('invite-btn')
const invitePopup = document.getElementById('invite-popup')
inviteBtn?.addEventListener('click', () => {
    invitePopup.style.display = 'block'
})

const popupCloseBtn = document.getElementById('popup-close-btn')
popupCloseBtn?.addEventListener('click', () => {
    invitePopup.style.display = 'none'
})

// Get the popup element
const popup = document.getElementById('notify-popup');

// Get the button that opens the popup
const openPopupButton = document.getElementById('openPopup');

// Get the <span> element that closes the popup
const closePopupButton = document.getElementById('closePopup');

// When the user clicks the button, open the popup
openPopupButton?.addEventListener('click', () => {
    popup.style.display = 'block';
});

// When the user clicks on <span> (x), close the popup
closePopupButton?.addEventListener('click', () => {
    popup.style.display = 'none';
});

// When the user clicks anywhere outside of the popup, close it
window.addEventListener('click', event => {
    if (event.target === popup) {
        popup.style.display = 'none';
    }
});

const observer = new MutationObserver((mutationsList, observer) => {
    for (const mutation of mutationsList) {
        if (mutation.type === 'childList') {
            const notifyInvite = document.querySelector('.notify-invite'); // Replace with appropriate selector
            const okeClose = document.querySelector('#oke-close'); // Replace with appropriate selector

            if (notifyInvite !== null && okeClose !== null) {
                okeClose.addEventListener('click', () => {
                    notifyInvite.style.display = 'none';
                });

                observer.disconnect(); // Stop observing once the element is found and event listener is attached
            }
        }
    }
});

// Start observing changes to the body or the element wrapping notifyInvite
observer.observe(document.body, { childList: true, subtree: true });

const prevBtns = document.querySelectorAll('.btn-prev');
const nextBtns = document.querySelectorAll('.btn-next');
const formSteps = document.querySelectorAll('.form-step');

let currentStep = 0;

const toggleActiveStep = (step) => {
    formSteps.forEach(stepEl => stepEl.classList.remove('active'));
    formSteps[step].classList.add('active');
};

nextBtns.forEach(btn => btn.addEventListener('click', () => {
    currentStep = Math.min(currentStep + 1, formSteps.length - 1);
    toggleActiveStep(currentStep);
}));

prevBtns.forEach(btn => btn.addEventListener('click', () => {
    currentStep = Math.max(currentStep - 1, 0);
    toggleActiveStep(currentStep);
}));

const showUserDetail = async id => {
    try {
        const { user } = await fetch(`/users/${id}`).then(res => res.json());
        const role = user.role;
        const profile = user.profile;

        const detailName = document.getElementById('detail-name');
        const fullName = document.getElementById('full-name');
        const detailId = document.getElementById('detail-id');
        const jobTitle = document.getElementById('job-title');
        const usersRmvBtn = document.getElementById('users-rmv-btn');
        const detailAvatar = document.getElementById('detail-avatar');
        const department = document.getElementById('department');

        detailName.textContent = fullName.value = profile.name;
        detailId.textContent = `ID: ${user.id}`;
        jobTitle.value = profile.job_title  .name;
        detailAvatar.src = profile.avatar ? '/images/avatars/' + profile.avatar : '/images/change-photo.svg';
        department.value = profile.job_title.department.name;

        usersRmvBtn.disabled = role.id === 1;
        usersRmvBtn.onclick = () => removeUser(user.id);
    } catch (error) {
        console.error(error);
    }
};

const removeUser = async id => {
    if (!confirm('Are you sure you want to remove this user?')) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        await fetch(`/users/${id}/delete`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
        });

        location.reload();
    } catch (error) {
        console.error(error);
    }
};

document.querySelectorAll('.tablink').forEach(tab => {
    tab.addEventListener('click', e => {
        e.preventDefault();

        const activeTab = document.querySelector('.tablink.active');
        const activeContent = document.querySelector('.tab-detail.active');

        activeTab?.classList.remove('active');
        activeContent?.classList.remove('active');

        tab.classList.add('active');
        document.querySelector(tab.dataset.target)?.classList.add('active');
    });
});

document.querySelectorAll('.profile-link').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const { target } = link.dataset;
        const activeLink = document.querySelector(`.profile-link[data-target="${target}"]`);
        const activeContent = document.querySelector('.content-detail.active');

        if (activeLink) {
            activeContent.classList.remove('active');
            document.querySelector(target).classList.add('active');
            window.history.replaceState({}, '', window.location.pathname);
        }
    });
});

document.querySelectorAll('.system-link').forEach(link => {
    link.addEventListener('click', ({ currentTarget }) => {
        const target = currentTarget;
        const activeLink = document.querySelector(`.system-link[data-target="${target.dataset.target}"]`);
        const activeContent = document.querySelector('.content-detail.active');

        if (activeLink) {
            activeContent.classList.remove('active');
            document.querySelector(target.dataset.target).classList.add('active');
            window.history.replaceState({}, '', window.location.pathname);
        }
    });
});

document.querySelector('.sidebar-item.setting').addEventListener('click', ({ currentTarget }) => currentTarget.classList.toggle('open'));

document.querySelector('#btn-change-photo').addEventListener('click', () => document.querySelector('#photo-input').click());

document.querySelector('#photo-input').addEventListener('change', () => document.querySelector('#form-change-photo').submit());

document.querySelector('#change-email').addEventListener('click', 
    () => confirm('Are you sure you want to change your email?') && document.querySelector('#form-change-email').submit());

document.querySelector('#change-username').addEventListener('click', 
    () => confirm('Are you sure you want to change your username?') && document.querySelector('#form-change-username').submit());

document.querySelector('#change-password').addEventListener('click', 
    () => confirm('Are you sure you want to change your password?') && document.querySelector('#form-change-password').submit());

document.querySelector('#btn-delete-photo').addEventListener('click', 
    () => confirm('Are you sure you want to delete your photo?') && document.querySelector('#form-delete-photo').submit());