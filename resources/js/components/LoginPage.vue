<template>
  <div class="myapp">
    <v-card class="ma-4 pa-4">
      <v-card-title>Register</v-card-title>
      <form>
        <v-text-field
          v-model="register.name"
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
        name: null,
        useremail: null,
        password: null,
      },
      login: {
        username: null,
        password: null,
      },
    }
  },

  methods: {
    getCookie(name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(';').shift();
    },
    submitLogin() {
      axios.get('sanctum/csrf-cookie').then((cookie) => {
        axios.post('api/auth/login', {
          username: this.login.username,
          password: this.login.password
        }).then((res) => {
          console.log(res);
        });
      })
    },
    submitRegister() {
      axios.post('api/auth/register', {
        name: this.register.name,
        email: this.register.useremail,
        password: this.register.password
      }).then((res) => {
        console.log(res);
      });
    },
    pwet() {
      axios.get('api/user').then((res) => {
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