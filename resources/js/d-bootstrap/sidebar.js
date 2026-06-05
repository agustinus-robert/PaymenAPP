// Sidebar.js
const sidebar = document.querySelector('.sidebar');
const toggler = document.querySelector('#toggle-sidebar');
const offcanvas = new bootstrap.Offcanvas(sidebar);

toggler.addEventListener('click', (e) => {
    sidebar.classList.toggle('open');
});

const responsiveSidebar = () => {
    if (window.innerWidth < 720) {
        if (!sidebar.classList.contains('offcanvas')) {
            sidebar.classList.remove('open');
        }
        sidebar.classList.add('offcanvas', 'offcanvas-start');
        toggler.setAttribute('data-bs-toggle', 'offcanvas');
        toggler.setAttribute('data-bs-target', '.sidebar');
        sidebar.addEventListener('hidden.bs.offcanvas', (e) => {
            if(sidebar.classList.contains('offcanvas'))
                e.target.classList.remove('open');
        })
    } else {
        if (sidebar.classList.contains('offcanvas')) {
            offcanvas.hide();
        }
        toggler.removeAttribute('data-bs-toggle');
        toggler.removeAttribute('data-bs-target');
        sidebar.classList.remove('offcanvas', 'offcanvas-start');
    }
}

document.querySelector('#toggle-theme').addEventListener('change', (e) => {
    const sidebar = document.querySelector('.sidebar');
    if(e.target.checked) {
        sidebar.classList.add('bg-dark', 'text-white')
        sidebar.classList.remove('bg-white', 'text-dark')
    } else {
        sidebar.classList.remove('bg-dark', 'text-white')
        sidebar.classList.add('bg-white', 'text-dark')
    }
})

window.addEventListener('resize', responsiveSidebar);
responsiveSidebar();

document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
        element.addEventListener('click', function (e) {
            let nextEl = element.nextElementSibling;
            let parentEl  = element.parentElement;  
            if(nextEl) {
                e.preventDefault(); 
                let mycollapse = new bootstrap.Collapse(nextEl);
                if(nextEl.classList.contains('show')){
                    mycollapse.hide();
                } else {
                    mycollapse.show();
                    var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                    if(opened_submenu){
                        new bootstrap.Collapse(opened_submenu);
                    }
                }
            }
        });
        if(window.location.href.includes(element.href)) {
            if(element.closest('.collapse').classList.contains('collapse')) {
                element.closest('.collapse').classList.add('show')
            }
            element.parentElement.classList.add('active')
        }
    });
}); 