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

      <v-card flat>
        <v-card-title>User</v-card-title>
        <v-card-text style="display:flex;flex-direction:row;justify-content:space-evenly">
          <v-btn @click="register">register</v-btn>
          <v-btn @click="login">login</v-btn>
          <v-btn @click="logout">logout</v-btn>
          <v-btn @click="me">me</v-btn>
        </v-card-text>
      </v-card>
      <v-card flat>
        <v-card-title>
          Event
        </v-card-title>

        <v-card-text>
          <v-text-field
            v-model="event_id"
            label="event_id"
            type="int"
            style="display: inline-block; width: 100px !important"
          >
          </v-text-field>
          <v-flex style="display:flex;flex-direction:row;justify-content:space-evenly;">
            <v-btn @click="create">create</v-btn>

            <v-btn @click="show">show</v-btn>
            <v-btn @click="update">update</v-btn>
            <v-btn @click="destroy">destroy</v-btn>
            <v-btn @click="all_events">all</v-btn>
          </v-flex>
        </v-card-text>
      </v-card>

      <v-container>
        <pre>{{ debug_data }}</pre>
      </v-container>
    </v-card>
  </div>
</template>

<script>
import ColorCtr from "./ColorCtr.vue";

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
    },
    event_id: 10,
  }),

  mounted() {
    //
  },

  methods: {
    register() {
      axios.post('http://localhost:8000/auth/register', {
        firstname: 'Chomchaum',
        lastname: 'dev',
        email: 'Chomchaum2@dev.fr',
        password: 'dev',
      })
    },

    login() {
      axios.post('http://localhost:8000/auth/login', {
        username: 'Chomchaum2@dev.fr',
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
      axios.get('http://localhost:8000/api/users').then(res => {
        this.debug_data = res.data;
      });
    },

    create() {
      axios.post('http://localhost:8000/api/evenement/create', {
        nom: 'MyFourthEvent',
        organisation: 'myasso',
        description: 'lorem ipsum',
        site_web: 'www',
        reseaux_sociaux: {twitter: '@me', instagram: '@me'},
      }, {withCredentials: true}).then(res => {
        this.debug_data = res;
      });
    },
    show() {
      axios.get('http://localhost:8000/api/evenement/' + this.event_id).then(res => {
        this.debug_data = res.data;
      });
    },
    update() {
      axios.post('http://localhost:8000/api/evenement/update/' + this.event_id, {
        id: this.event_id,
        nom: 'MyFourthEvent',
        organisation: 'yasso',
      }).then(res => {
        this.debug_data = res;
      });
    },
    destroy() {
      axios.get('http://localhost:8000/api/evenement/delete/' + this.event_id).then(res => {
        this.debug_data = res.data;
      });
    },
    all_events() {
      axios.get('http://localhost:8000/api/evenement/all').then(res => {
        this.debug_data = res.data;
      });
    },
  }
}
</script>

<style scoped>
</style>
