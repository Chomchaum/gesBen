<template>
  <v-card flat class="pa-4">
    <v-card-text>
      <v-form
        ref="account"
        v-model="valid"
        lazy-validation
      >
        <v-row>
          <v-col cols="12" sm="12">
            <v-text-field
              readonly
              v-model="register.email"
              label="E-mail"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="password"
              :append-icon="showPw ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="passwordRules"
              :type="showPw ? 'text' : 'password'"
              label="Mot de passe"
              hint="8 caractères minimum"
              loading
              @click:append="showPw = !showPw"
              @blur="showPw = false"
            >
              <template v-slot:progress>
                <v-progress-linear
                  :value="progress"
                  :color="color"
                  absolute
                  height="5"
                ></v-progress-linear>
              </template>
            </v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="rePassword"
              :append-icon="showRePw ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="passwordRules.concat(rePasswordMatchRule)"
              :type="showRePw ? 'text' : 'password'"
              label="Confirmation de mot de passe"
              @click:append="showRePw = !showRePw"
              @blur="showRePw = false"
            />
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>

    <v-card-actions>
      <v-btn
        :disabled="!valid || password === null"
        color="success"
        class="mr-4"
        @click="submit"
      >
        Continuer
      </v-btn>

      <v-btn
        color="error"
        @click="clear"
      >
        Effacer
      </v-btn>

    </v-card-actions>
  </v-card>
</template>

<script>
import {useRegisterStore} from "../../stores/Register";

export default {
  name: "AccountRegister",

  data: () => ({
    valid: true,

    password: null,
    rePassword: null,

    showPw: false,
    showRePw: false,
    passwordRules: [
      v => !!v || 'Mot de passe obligatoire',
      v => /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])((?=.*\W)|(?=.*_))/.test(v) || "Doit contenir au moins un exemplaire de : Majuscule, Minuscule, Chiffre, Caractère spécial",
    ]
  }),

  computed: {
    progress() {
      return (this.password == null ? 0 : Math.min(100, this.password.length * 12.5))
    },
    color() {
      return (this.password == null ? 'white' : ['error', 'warning', 'success'][Math.floor(this.progress / 50)])
    },
    rePasswordMatchRule() {
      return () => (this.password === this.rePassword) || 'Les mots de passe doivent correspondre'
    }
  },

  setup() {
    const register = useRegisterStore();

    return {register}
  },

  methods: {
    clear() {
      this.$refs.account.reset();
      this.password = null;
      this.rePassword = null;

      this.$emit('continue')
    },

    submit() {
      const store = useRegisterStore();

      this.$emit('submit');
    }
  },
}
</script>

<style scoped>

</style>