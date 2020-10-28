require('./bootstrap');

Vue.component('bpp-tasks', require('./components/Tasks').default)


new Vue({
    el: '#app',
})

