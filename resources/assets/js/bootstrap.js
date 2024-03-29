
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// import Echo from "laravel-echo"
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'adaa734ec4ce7b21a7ae',
//     encrypted: true
// });
