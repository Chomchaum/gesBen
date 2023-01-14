import Vue from 'vue'
import VueMask from 'v-mask'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.min.css'

Vue.use(VueMask)
Vue.use(Vuetify)


export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: '#1976D2',
        secondary: '#424242',
        accent: '#9d82ff',
        error: '#ff3f3f',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#ff9c07',
      },
      dark: {
        primary: '#2196F3',
        accent: '#bd34d2',
        error: '#ff2929',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#ff9c07',
      },
      darker: {
        primary: '#ffffff',
        secondary: '#dddddd',
        accent: '#bbbbbb',
        error: '#999999',
        info: '#777777',
        success: '#555555',
        warning: '#33aa33',
      },
    },
    dark: true,
    }
})
