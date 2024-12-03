import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});


document.addEventListener('DOMContentLoaded', function () {


    window.Echo.private(`rooms.${room_id}`)
        .listen('ChatEvent', (e) => {
            streamData(e);
        });


    // window.Echo.join(`online`)
    //     .here(users => {
    //         console.log('users');
    //     })
    //     .joining(user => {
    //         console.log(' joined');
    //     })
    //     .leaving(user => {
    //         console.log(' left');
    //     })
    //     .error(error => {
    //         console.error(error);
    //     });

});


