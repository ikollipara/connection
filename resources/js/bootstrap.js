// window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// import("axios").then(({ default: axios }) => {
//     window.axios = axios;
//     window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// });
// window.axios = require('axios');

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

import editor from "./editor";
import slimSelect from "./slim-select";
import Alpine from 'alpinejs'
import addToCollection from "./add-to-collection";
// import * as Turbo from "@hotwired/turbo";

// window.Turbo = Turbo;
window.Alpine = Alpine;
Alpine.data("editor", editor);
Alpine.data("slimSelect", slimSelect);
Alpine.data("add-to-collection", addToCollection);

Alpine.start()

// import("bulma-toast")
// .then(({ toast }) => {
//     window.toast = toast;
//     window.success = (message) => {
//         toast({
//             message: message,
//             type: 'is-success',
//             dismissible: true,
//             duration: 3000,
//             animate: {in: 'fadeIn', out: 'fadeOut'},
//         });
//     };
//     window.error = (message) => {
//         toast({
//             message: message,
//             type: 'is-danger',
//             dismissible: true,
//             duration: 3000,
//             animate: {in: 'fadeIn', out: 'fadeOut'},
//         });
//     }
//
//     document.addEventListener('success', event => {
//         window.success(event.detail.message)
//     });
//     document.addEventListener('error', event => {
//         window.error(event.detail.message)
//     });
// })

document.addEventListener('content-removed', (event) => {
    event.target.classList.add('animate__animated', 'animate__fadeOut');
    setTimeout(() => {
        event.target.remove();
    }, 1000);
})
