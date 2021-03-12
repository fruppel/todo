import axios from 'axios';
import PortalVue from 'portal-vue';
import Vue from 'vue';
import VueAxios from 'vue-axios';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(VueAxios, axios);

const app = document.getElementById('app');

// Global event bus
window.events = new Vue();

window.flash = function (message, level = 'success') {
    window.events.$emit('flash',  { message, level });
};

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').then(
            (registration) => {},
            (err) => {
                console.error('ServiceWorker registration failed: ', err);
            });
    });
}
