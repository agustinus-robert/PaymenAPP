<script>
    window.showToast = function(message, type = 'success', duration = 3000) {
        let background = "#22c55e";
        let title = "Berhasil";
        let icon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px; height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;

        if (type === 'error' || type === 'danger') {
            background = "#ef4444";
            title = "Gagal";
            icon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px; height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
        } else if (type === 'warning') {
            background = "#f59e0b";
            title = "Peringatan";
            icon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px; height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`;
        } else if (type === 'info') {
            background = "#3b82f6";
            title = "Informasi";
            icon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px; height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
        }

        let textToShow = message;
        if (!textToShow || textToShow === 'undefined' || typeof textToShow === 'object') {
            textToShow = "Terjadi kesalahan sistem.";
        }

        let htmlContent = `
            <div style="display: flex; align-items: flex-start; gap: 10px; color: #ffffff; font-family: sans-serif;">
                <div style="margin-top: 2px; flex-shrink: 0;">${icon}</div>
                <div style="display: flex; flex-direction: column; gap: 2px;">
                    <span style="font-weight: 700; font-size: 14px; line-height: 1.2;">${title}</span>
                    <span style="font-size: 13px; font-weight: 400; line-height: 1.4; opacity: 0.95;">${textToShow}</span>
                </div>
            </div>
        `;

        Toastify({
            text: htmlContent,
            escapeMarkup: false,
            duration: duration,
            gravity: "top",
            position: "right",
            style: {
                background: background,
                borderRadius: "8px",
                boxShadow: "0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)",
                padding: "12px 16px",
                maxWidth: "350px"
            },
            stopOnFocus: true,
        }).showToast();
    };

    if (typeof vSelect !== 'undefined') {
        Vue.component('v-select', vSelect.VueSelect);
    }

  const vueElements = document.querySelectorAll('.vue-init');
    vueElements.forEach(function (element) {
        const elementId = element.getAttribute('id');

        if (!elementId) return;
        const rawOptions = element.getAttribute('data-options');
        let parsedOptions = [];

        if (rawOptions) {
            try {
                parsedOptions = JSON.parse(rawOptions);
            } catch (e) {
                console.error("Gagal melakukan parse data-options pada ID: " + elementId, e);
            }
        }

        new Vue({
            el: '#' + elementId,
            components: {
                'v-select': vSelect.VueSelect
            },
            data() {
                return {
                    form: {
                        recipient: '',
                        amount: 0,
                        note: ''
                    },
                    options: parsedOptions,
                    isLoading: false,
                    wasValidated: false
                };
            },
            methods: {
                handleFormSubmit() {}
            }
        });
    });
</script>
@stack('scripts')
