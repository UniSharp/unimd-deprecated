
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { codemirror, CodeMirror } from 'vue-codemirror'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('codemirror', codemirror);

Vue.component('example', require('./components/Example.vue'));
Vue.component('actionbar', require('./components/ActionBar.vue'));
Vue.component('editor', require('./components/Editor.vue'));
Vue.component('configbar', require('./components/ConfigBar.vue'));

const app = new Vue({
    el: '#main'
});
