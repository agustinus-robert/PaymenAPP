@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const userId = "{{ auth()->id() }}";

    const waitEcho = setInterval(() => {
        if (!window.Echo) return;
        clearInterval(waitEcho);

        window.Echo.private(`Modules.Account.Models.User.${userId}`)
            .listen('.notification.received', (data) => {
                showFbNotification(data);
                updateNotificationBadge();
                updateNotificationDropdown(data);
            });

    }, 100);
});

document.addEventListener('DOMContentLoaded', () => {
    window.updateNotificationBadge = function() {
        const badges = document.querySelectorAll('#notif-count-data');
        badges.forEach(badge => {
            let count = parseInt(badge.innerText.replace(/\D/g, '')) || 0;
            badge.innerText = count + 1;
            badge.classList.remove('d-none');
            badge.style.display = 'inline-block';
        });
    };

    document.body.addEventListener('click', function (e) {
        const notifBtn = e.target.closest('#page-header-notifications-dropdown');

        if (notifBtn) {
            const badges = document.querySelectorAll('#notif-count-data');
            let hasUnread = false;

            badges.forEach(b => {
                if (parseInt(b.innerText) > 0) hasUnread = true;
            });

            if (hasUnread) {
                fetch("{{ route('account::notifications.read-all') }}", {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(() => {
                    badges.forEach(badge => {
                        badge.innerText = '0';
                        badge.classList.add('d-none');
                    });

                    document.querySelectorAll('#notification-list .bg-light').forEach(item => {
                        item.classList.replace('bg-light', 'bg-white');
                        const pulse = item.querySelector('.pulse-danger');
                        if (pulse) pulse.remove();
                    });
                })
                .catch(err => console.error('Mark read failed:', err));
            }
        }
    });
});

const MAX_NOTIF = 5;

function getContainer() {
    let container = document.getElementById('fb-notif-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'fb-notif-container';
        container.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column-reverse;
            gap: 12px;
            z-index: 2147483647;
            width: 350px;
            pointer-events: none;
        `;
        document.body.appendChild(container);
    }
    return container;
}

function showFbNotification(data) {
    const container = getContainer();
    const notif = document.createElement('div');

    const colors = {
        primary: '#1877f2',
        success: '#42b72a',
        warning: '#f7b928',
        danger: '#fa3e3e'
    };
    const activeColor = colors[data.color] || colors.primary;

    notif.className = 'fb-toast';
    notif.style.cssText = `
        background: #ffffff;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
        position: relative;
        opacity: 0;
        transform: translateX(120%);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        pointer-events: auto;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 10px;
        width: 100%;
        border: 1px solid #ddd;
    `;

    notif.innerHTML = `
        <div style="flex-shrink: 0;">
            <div style="position: relative;">
                <img src="${data.sender_image}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 1px solid #eee;">
                <div style="
                    position: absolute;
                    bottom: -2px;
                    right: -2px;
                    background: ${activeColor};
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border: 2px solid #fff;
                    color: #fff;
                    font-size: 10px;
                ">
                    <i class="${data.icon || 'bx bx-bell'}"></i>
                </div>
            </div>
        </div>
        <div style="flex: 1; display: flex; flex-direction: column;">
            <div style="font-weight: 700; font-size: 14px; color: #050505; margin-bottom: 2px;">
                ${data.sender_name}
            </div>
            <div style="font-size: 13px; color: #65676b; line-height: 1.2; margin-bottom: 4px;">
                ${data.action}
            </div>
            <div style="font-size: 13px; color: #050505; font-weight: 500; line-height: 1.3;">
                ${data.message}
            </div>
        </div>
        <button style="position: absolute; top: 8px; right: 8px; border: none; background: transparent; color: #999; font-size: 18px; cursor: pointer;">×</button>
    `;

    notif.onclick = () => { if (data.link && data.link !== '#') window.location.href = data.link; };
    notif.querySelector('button').onclick = (e) => { e.stopPropagation(); removeNotif(notif); };

    container.prepend(notif);
    requestAnimationFrame(() => { notif.style.transform = 'translateX(0)'; notif.style.opacity = '1'; });
    setTimeout(() => removeNotif(notif), 8000);
    enforceLimit(container);
}

function removeNotif(el) {
    if (!el) return;
    el.style.transform = 'translateX(120%)';
    el.style.opacity = '0';
    setTimeout(() => el.remove(), 400);
}

function enforceLimit(container) {
    const items = container.querySelectorAll('.fb-toast');
    if (items.length > MAX_NOTIF) {
        for (let i = MAX_NOTIF; i < items.length; i++) { removeNotif(items[i]); }
    }
}

function updateNotificationBadge() {
    const badges = document.querySelectorAll('#notif-count-data');

    if (badges.length > 0) {
        badges.forEach(badge => {
            let currentText = badge.innerText.replace(/\D/g, '');
            let count = parseInt(currentText) || 0;
            let newCount = count + 1;

            badge.innerText = newCount;
            badge.style.setProperty('display', 'inline-block', 'important');
            badge.classList.remove('d-none');

            console.log('Badge updated:', newCount);
        });
    } else {
        const backupBadge = document.querySelector('.noti-icon .badge');
        if (backupBadge) {
            let count = parseInt(backupBadge.innerText.replace(/\D/g, '')) || 0;
            backupBadge.innerText = count + 1;
            backupBadge.style.display = 'inline-block';
        } else {
            console.error('CRITICAL: Badge notfound even with backup selector');
        }
    }
}

function updateNotificationDropdown(data) {
    const listContainer = document.getElementById('nav-dropdown-notifications');
    const listWrapper = listContainer ? listContainer.querySelector('.p-3').nextElementSibling : null;

    const emptyMsg = listContainer ? listContainer.querySelector('.dropdown-item.py-2') : null;
    if (emptyMsg && emptyMsg.innerText.includes('Tidak ada')) {
        emptyMsg.remove();
    }

    if (listContainer) {
        const newLink = document.createElement('a');
        newLink.className = 'dropdown-item d-flex align-items-center bg-light py-3';
        newLink.href = data.link || 'javascript:;';

        newLink.innerHTML = `
            <div class="me-3">
                <span class="float-end ms-n3 bg-danger pulse-danger rounded-circle border" style="width: 12px; height: 12px;"></span>
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-${data.color || 'primary'}" style="width: 2.5rem; height: 2.5rem;">
                    <i class="${data.icon || 'bx bx-bell'} m-0 text-white"></i>
                </div>
            </div>
            <div>
                <div class="text-wrap" style="font-size: 13px;"><strong>${data.sender_name}</strong>: ${data.message}</div>
                <div class="small text-muted">Baru saja</div>
            </div>
        `;

        // Masukkan ke posisi paling atas setelah header judul
        const header = listContainer.querySelector('.p-3');
        header.insertAdjacentElement('afterend', newLink);

        // Batasi list dropdown maksimal 4 (agar sesuai dengan .take(4) di Blade)
        const allItems = listContainer.querySelectorAll('.dropdown-item');
        if (allItems.length > 4) {
            allItems[allItems.length - 1].remove();
        }
    }
}
</script>
@endpush
