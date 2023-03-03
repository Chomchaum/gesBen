require('./bootstrap');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const moment = require('moment')
require('moment/locale/br')
moment.updateLocale('br', {
  meridiem: function (hour, minute, isLower) {
    var str = hour < 12 ? ('a.m.') : 'g.m.';
    return isLower ? str : str.toUpperCase();
  },
})
require('moment/locale/fr')
moment.locale('fr')
// Vue.use(require('vue-moment'), {
//   moment
// });

import Vue from "vue";
import vuetify from './vuetify';
import {createPinia, PiniaVuePlugin} from "pinia";

import App from "./components/Pages/App.vue";
import RegisterPage from "./components/Pages/RegisterPage.vue";

import VueI18n from "vue-i18n";
import en from '../lang/en/messages.json';
import fr from '../lang/fr/messages.json';
import br from '../lang/br/messages.json';

Vue.use(PiniaVuePlugin);
Vue.use(VueI18n)

const pinia = createPinia();
const i18n = new VueI18n({
  locale: 'fr',
  fallbackLocale: 'fr',
  messages: {
    en, fr, br
  }
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  vuetify,
  pinia,
  i18n,
  components: {
    App,
    RegisterPage,
  }
});
