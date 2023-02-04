<template>
  <v-card flat class="pa-4">
    <v-form
      ref="infosPerso"
      v-model="infosPerso.valid"
      lazy-validation
    >
      <v-card-text>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="infosPerso.values.firstname"
              :rules="infosPerso.firstnameRules"
              label="Prénom"
              required
            ></v-text-field>
          </v-col>

          <v-col cols="12" sm="6">
            <v-text-field
              v-model="infosPerso.values.name"
              :counter="24"
              :rules="infosPerso.nameRules"
              label="Nom"
              required
            ></v-text-field>
          </v-col>
        </v-row>

        <v-text-field
          v-model="infosPerso.values.email"
          :rules="infosPerso.emailRules"
          label="E-mail"
          type="email"
          required
        ></v-text-field>

        <v-row>
          <v-col cols="12" sm="4">
            <v-text-field
              v-model="infosPerso.values.phone"
              label="Téléphone"
            ></v-text-field>
          </v-col>

          <v-col cols="12" sm="4">
            <v-menu
              ref="menu"
              v-model="menu"
              :close-on-content-click="false"
              :open-on-click="true"
              transition="scale-transition"
              offset-y
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="infosPerso.values.birthdate"
                  :rules="infosPerso.birthdateRules"
                  prepend-icon="mdi-calendar"
                  label="Date de naissance"
                  required

                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="infosPerso.values.birthdate"
                :active-picker.sync="activePicker"
                header-color="primary"
                color="accent"
                locale="fr-fr"
                reactive
                :landscape="isLandscape"
                :max="(new Date(Date.now())).toISOString().substr(0, 10)"
                min="1900-01-01"
                @change="save"
              ></v-date-picker>
            </v-menu>
          </v-col>

          <v-col cols="12" sm="4">
            <v-select
              v-model="infosPerso.values.taille"
              prepend-icon="mdi-tshirt-crew-outline"
              :items="infosPerso.tailles"
              :rules="[v => !!v || 'Taille requise']"
              label="Taille de T-shirt"
              required
            ></v-select>
          </v-col>
        </v-row>
      </v-card-text>

      <v-card-actions>
        <v-btn
          :disabled="!infosPerso.valid || infosPerso.values.email === null"
          color="success"
          class="mr-4"
          @click="submit"
        >
          Continuer
        </v-btn>

        <v-btn
          color="error"
          @click="reset"
        >
          Effacer
        </v-btn>
      </v-card-actions>

    </v-form>
  </v-card>
</template>

<script>
import {useRegisterStore} from "../../stores/Register";
import moment from "moment";

export default {
  name: "InfosPerso",

  data: () => ({
    infosPerso: {
      ///todo Ajouter le choix de code postal

      values: {
        name: null,
        firstname: null,
        phone: null,
        email: null,
        birthdate: null,
        taille: null,
      },
      valid: false,
      nameRules: [
        v => !!v || 'Nom requis',
        v => (v && v.length <= 24) || 'Le nom ne peut pas dépasser 24 caractères',
      ],
      firstnameRules: [
        v => !!v || 'Prénom requis'
      ],
      emailRules: [
        v => !!v || 'E-mail obligatoire',
        v => /^.+@.+\..{2,}$/.test(v) || "L'e-mail doit être valide",
      ],
      birthdateRules: [
        v => !!v || 'Date de naissance requise',
      ],
      tailles: [
        'S',
        'M',
        'L',
        'XL',
        'XXL',
      ],
    },
    activePicker: null,
    menu: false,
  }),

  setup() {
  },

  computed: {
    isLandscape () {
      switch (this.$vuetify.breakpoint.name) {
        case 'lg': return true
        case 'xl': return true
        default: return false
      }
    },
    isUnderage () {
      return moment().diff(moment(this.infosPerso.values.birthdate), 'years') < 18;
    }
  },

  watch: {
    menu(val) {
      val && setTimeout(() => (this.activePicker = 'YEAR'))
    },
  },

  methods: {
    save(date) {
      this.$refs.menu.save(date)
    },
    validate () {
      this.$refs.infosPerso.validate()
    },
    reset () {
      this.$refs.infosPerso.reset()
    },
    submit() {
      const store = useRegisterStore();
      store.$patch({
        name: this.infosPerso.values.name,
        firstname: this.infosPerso.values.firstname,
        email: this.infosPerso.values.email,
        phone: this.infosPerso.values.phone,
        birthdate: this.infosPerso.values.birthdate,
        isUnderage: this.isUnderage,
        size: this.infosPerso.values.taille,
      });

      this.$emit('continue');
    }
  }

}
</script>

<style scoped>
</style>