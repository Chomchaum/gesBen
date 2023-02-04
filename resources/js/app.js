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

import { createPinia, PiniaVuePlugin} from "pinia";
Vue.use(PiniaVuePlugin);
const pinia = createPinia();

import VueI18n from "vue-i18n";
import * as en from '../lang/en/messages.json';
import * as fr from '../lang/fr/messages.json';
import * as br from '../lang/br/messages.json';
const intlMessages = {
  'en': en,
  'fr': fr,
  'br': br,
};


/**
 * Main pages components import
 */

import App from "./components/Pages/App.vue";
import RegisterPage from "./components/Pages/RegisterPage.vue";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  vuetify,
  pinia,
  components: {
    App,
    RegisterPage,
  }
});
