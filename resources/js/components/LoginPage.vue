<template>
  <div class="myapp">
    <v-card class="ma-4 pa-4">
      <v-card-title>Register</v-card-title>
      <form>
        <v-text-field
          v-model="register.firstname"
          label="Prénom"
          type="text"
        ></v-text-field>
        <v-text-field
          v-model="register.lastname"
          label="Nom"
          type="text"
        ></v-text-field>
        <v-text-field
          v-model="register.useremail"
          label="E-mail"
          type="email"
        ></v-text-field>
        <v-text-field
          v-model="register.password"
          label="Mot de passe"
          type="password"
        ></v-text-field>
        <v-btn @click="submitRegister">Envoyer</v-btn>
      </form>
    </v-card>
    <v-card class="ma-4 pa-4">
      <v-card-title>Login</v-card-title>
      <form>
        <v-text-field
          v-model="login.username"
          label="E-mail"
          type="email"
        ></v-text-field>
        <v-text-field
          v-model="login.password"
          label="Mot de passe"
          type="password"
        ></v-text-field>
        <v-btn @click="submitLogin">Envoyer</v-btn>
      </form>
    </v-card>
    <v-btn @click="pwet">User</v-btn>
  </div>
</template>

<script>

export default {
  name: "LoginPage",

  data() {
    return {
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
    }
  },

  setup() {
     axios.get('http://localhost:8000/sanctum/csrf-cookie')
  },

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
      axios.get('http://localhost:8000/api/user').then((res) => {
        console.log(res);
      })
    },
  }
}
</script>

<style>
.myapp {
  width: 90%;
  align-self: center;
}
</style>