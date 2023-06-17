<template>
  <v-card>
    <v-card-title>
      Connexion
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-text-field
          v-model="username"
          label="E-mail"
        >
        </v-text-field>
        <v-text-field
          v-model="password"
          label="Mot de passe"
        >
        </v-text-field>
      </v-form>
      <pre>{{ err }}</pre>
    </v-card-text>
    <v-spacer/>
    <v-card-actions class="pb-4 ml-1">
      <v-spacer/>
      <v-btn text small color="primary">Mot de passe oublié ?</v-btn>
      <v-btn color="success" @click="signIn">Se connecter</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import {useUserStore} from "../../stores/User";

export default {
  name: "SignIn",

  data: _ => ({
    username: 'Chomchaum2@dev.fr',
    password: 'dev',
    err: null,
  }),

  setup() {
    const userStore = useUserStore();
    return {userStore}
  },

  methods: {
    signIn() {
      axios.get('/sanctum/csrf-cookie').then(_ => {
        axios.post('http://localhost:8000/auth/login', {
          username: this.username,
          password: this.password,
        }).catch((err) => {
          if (err.response.status === 401) {
            //
          }
        }).then(res => {
          this.userStore.auth_user = res.data.success;
        }).finally(_ => {
          this.$emit('closeDialog');
        });
      })
    }
  }
}
</script>

<style scoped>

</style>