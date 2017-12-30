
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('editor', require('./components/Editor.vue'));

const app = new Vue({
    el: '#app'
});

import autosize from 'autosize';

autosize(document.querySelectorAll('textarea.editor'));

require('jquery-slimscroll');
require('jquery-scroll-lock');
require('jquery.appear');
require('jquery-countto');
require('js-cookie');
require('./scms');