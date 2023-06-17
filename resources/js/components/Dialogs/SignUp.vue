<template>
  <v-card flat>
    <v-card-title>
      Créer mon compte MSB
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="firstname"
              label="Prénom"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="lastname"
              label="Nom de famille"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-text-field
          v-model="email"
          label="E-mail"
        >
        </v-text-field>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="password"
              label="Mot de passe"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="rePassword"
              label="Confirmation de mot de passe"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
    <v-card-actions class="pb-4 ml-1">
      <v-spacer/>
      <v-btn color="primary" @click="signUp">S'enregistrer</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: "SignUp",

  data: () => ({
    firstname: null,
    lastname: null,
    email: null,
    password: null,
    rePassword: null,
  }),

  methods: {
    signUp() {
      axios.post('http://localhost:8000/auth/registerFake', {
        firstname: this.firstname,
        lastname: this.lastname,
        email: this.email,
        password: this.password,
      }).then(res => {
        this.$emit('closeDialog')
      })
    }
  }
}
</script>

<style scoped>

</style>