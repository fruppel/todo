require('./bootstrap');

Vue.component('flash', require('./components/Flash'));
Vue.component('tasks', require('./components/Tasks'));

const app = new Vue({
    el: '#app'
});