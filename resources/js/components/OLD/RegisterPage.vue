<template>
  <div class="myapp">
    <nav-drawer :nav-items="navItems" :cur-page="1"/>

    <v-app-bar app clipped-left>
      <h1>Mes Supers Bénévoles</h1>
    </v-app-bar>

    <v-main>
      <debug :is_debug="app_debug"/>

      <v-container class="testpage">
        <v-card class="ma-4 pa-4">
          <v-card-title>Register</v-card-title>
          <form>
            <v-text-field
              v-model="register.firstname"
              :label="$t('prnom')"
              type="text"
            ></v-text-field>
            <v-text-field
              v-model="register.lastname"
              :label="$t('nom')"
              type="text"
            ></v-text-field>
            <v-text-field
              v-model="register.useremail"
              label="E-mail"
              type="email"
            ></v-text-field>
            <v-text-field
              v-model="register.password"
              :label="$t('motDePasse')"
              type="password"
            ></v-text-field>
            <v-btn @click="submitRegister">{{ $t('envoyer') }}</v-btn>
          </form>
        </v-card>
        <v-card class="ma-4 pa-4">
          <v-card-title>{{ $t('login') }}</v-card-title>
          <form>
            <v-text-field
              v-model="login.username"
              label="E-mail"
              type="email"
            ></v-text-field>
            <v-text-field
              v-model="login.password"
              :label="$t('motDePasse')"
              type="password"
            ></v-text-field>
            <v-btn @click="submitLogin">{{ $t('envoyer') }}</v-btn>
          </form>
        </v-card>
        <v-card class="ma-4 pa-4">

          <v-btn @click="pwet">{{ $t('user') }}</v-btn>
        </v-card>
      </v-container>

    </v-main>

    <v-footer app>
      <v-spacer/>
      <h5>
        <v-icon small>mdi-copyright</v-icon>
        Chomchaum
      </h5>
    </v-footer>
  </div>
</template>

<script>
import Debug from "../Debug.vue";
import NavDrawer from "../NavDrawer.vue";
import BenRegForm from "./Register.vue";

export default {
  name: "RegisterPage",
  components: {
    BenRegForm,
    NavDrawer,
    Debug,
  },

  data: () => ({
    navItems: [
      {title: 'Accueil', icon: 'mdi-home'},
      {title: 'Participer', icon: 'mdi-account-plus'},
    ],
    selectedNavItem: 'Participer',
    right: null,
    app_debug: false,

    register: {
      firstname: null,
      lastname: null,
      useremail: null,
      password: null,
    },
    login: {
      username: 'a@a.a',
      password: 'a',
    },
  }),

  methods: {
    submitLogin() {
      axios.post('http://localhost:8000/auth/login', {
        username: this.login.username,
        password: this.login.password
      }).then((res) => {
        console.log(res);
      });
    },
    submitRegister() {
      axios.post('http://localhost:8000/auth/register', {
        name: this.register.firstname.concat(' ', this.register.lastname),
        email: this.register.useremail,
        password: this.register.password
      }).then((res) => {
        console.log(res);
      });
    },
    pwet() {
      axios.get('http://localhost:8000/api/me').then((res) => {
        console.log(res);
        alert("Bonjour " + res.data.name);
      })
    },
  }
}
</script>

<style>
html {
  overflow-y: auto;
}

.v-icon {
  bottom: 1px;
}
</style>