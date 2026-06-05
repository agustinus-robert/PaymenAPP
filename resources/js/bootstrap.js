window._ = require('lodash');

/**
 * Load Axios
 */
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

/**
 * Laravel Echo & Reverb Setup
 */
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

// Inisialisasi Echo
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: 'slcmskey',
    wsHost: window.location.hostname,
    wsPort: 8080, // PAKAI 8080
    wssPort: 8080, // PAKAI 8080
    forceTLS: true, // Matikan dulu TLS buat debug
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
});

const pusher = window.Echo.connector.pusher;

pusher.connection.bind('state_change', (states) => {
    console.log('🔄 REVERB STATE:', states.previous, '➡️', states.current);
});

pusher.connection.bind('connected', () => {
    console.log('✅ Connected to Reverb via WSS!');
    console.log('📡 Socket ID:', pusher.connection.socket_id);
});

window.Echo.channel('test-channel')
    .subscribed(() => {
        console.log('✅ SUBSCRIBED test-channel');
    })
    .listen('.test.event', (data) => {
        console.log('🔥 FULL EVENT:', data);
    })
    .error((err) => {
        console.error('❌ CHANNEL ERROR:', err);
    });

pusher.connection.bind('error', (err) => {
    console.error('🔥 REVERB ERROR:', err);
});

/**
 * Listener Real-time Stok
 */
window.Echo.channel('product-stock').listen('ProductStockUpdated', (e) => {
    console.log('Update stok diterima:', e);

    let stockLabel = document.querySelector(`.stock-display[data-product-id="${e.productId}"]`);
    if (stockLabel && !e.variantCode) {
        stockLabel.innerText = e.newStock;
    }

    if (e.variantCode) {
        let variantLabels = document.querySelectorAll(
            `.variant-stock[data-code="${e.variantCode}"]`
        );
        variantLabels.forEach((label) => {
            label.innerText = e.newStock;
        });
    }
});
