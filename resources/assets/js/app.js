require('./bootstrap');

Vue.component('flash', require('./components/Flash').default);
Vue.component('tasks', require('./components/Tasks').default);

new Vue({
    el: '#app'
});
