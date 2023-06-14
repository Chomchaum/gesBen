<template>
  <div v-if="is_debug">
    <v-card class="mx-auto px-4 py-2"
            max-width="80%"
            outline>
      <color-ctr class="align-center">
        <v-switch v-model="isDarkTheme" :label="((isDarkTheme) ? 'Dark' : 'White') + ' Theme'"></v-switch>
        <v-btn color="primary">
          {{ $t('primary') }}
        </v-btn>
        <v-btn color="secondary">
          {{ $t('secondary') }}
        </v-btn>
        <v-btn color="accent"
               :class="(()=>{if(isDarkTheme) return {'theme--dark':true}; return {'theme--light':true};})()">
          {{ $t('accent') }}
        </v-btn>
        <v-btn color="error">
          {{ $t('error') }}
        </v-btn>
        <v-btn color="info">
          {{ $t('info') }}
        </v-btn>
        <v-btn color="success">
          {{ $t('success') }}
        </v-btn>
        <v-btn color="warning">
          {{ $t('warning') }}
        </v-btn>
      </color-ctr>

      <v-divider/>
      <v-container style="display: flex; flex-direction: row; justify-content: space-around">
        <span>User</span>
        <v-btn color='primary' @click="register">REGISTER</v-btn>
        <v-btn color='success' @click="login">LOGIN</v-btn>
        <v-btn color='error' @click="logout">LOGOUT</v-btn>
        <v-btn color='accent' @click="me">ME</v-btn>
      </v-container>
      <v-container style="display: flex; flex-direction: row; justify-content: space-around">
        <span>Event</span>
        <v-btn color='success' @click="create">CREATE</v-btn>
        <v-btn color='primary' @click="show">SHOW</v-btn>
        <v-btn color='warning' @click="update">UPDATE</v-btn>
        <v-btn color='error' @click="destroy">DESTROY</v-btn>
      </v-container>
      <pre>{{ debug_data }}</pre>
    </v-card>
  </div>
</template>

<script>
import ColorCtr from "./ColorCtr.vue";
import api from '../api'


export default {
  name: "Debug",

  components: {
    ColorCtr,
  },

  props: ["is_debug"],

  data: () => ({
    isDarkTheme: false,
    debug_data: null,
    user: {
      id: null
    }
  }),

  mounted() {
    this.login();
  },

  methods: {
    register() {
      axios.post('http://localhost:8000/auth/register', {
        firstname: 'Chomchaum',
        lastname: 'dev',
        email: 'Chomchaum@dev.fr',
        password: 'dev',
      })
    },

    login() {
      axios.post('http://localhost:8000/auth/login', {
        username: 'Chomchaum@dev.fr',
        password: 'dev',
      }).then(res => {
        this.user = res.data.success;
      });
    },

    logout() {
      axios.get('http://localhost:8000/api/logout').then(res => {
        this.user = res.data.success;
      });
    },

    me() {
      api.get('http://localhost:8000/api/users').then(res => {
        this.debug_data = res.data;
      });
    },

    create() {
      api.get('http://localhost:8000/api/me').then(res => {
        this.debug_data = res.data;
      });
      axios.post('http://localhost:8000/api/event/create', {
        nom: 'MyEvent',
        'organisation': 'myasso',
        'description': 'lorem ipsum',
        'site_web': 'www',
        'reseaux_sociaux': {'twitter': '@me', 'instagram': '@you'},
      }, {withCredentials: true}).then(res => {
        this.debug_data = res;
      });
    },
    show() {

    },
    update() {

    },
    destroy() {

    },
  }
}
</script>

<style scoped>

</style>
