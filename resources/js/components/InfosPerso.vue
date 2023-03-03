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
              :label="$t('prnom')"
              required
            ></v-text-field>
          </v-col>

          <v-col cols="12" sm="6">
            <v-text-field
              v-model="infosPerso.values.name"
              :counter="24"
              :rules="infosPerso.nameRules"
              :label="$t('nom')"
              required
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" sm="9">
            <v-text-field
              v-model="infosPerso.values.email"
              :rules="infosPerso.emailRules"
              label="E-mail"
              type="email"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="3">
            <v-text-field
              v-model="infosPerso.values.phone"
              :label="$t('phone')"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
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
                  :label="$t('dateDeNaissance')"
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

          <v-col>
            <v-autocomplete
              v-model="infosPerso.values.commune"
              :items="listeCommunes"
              :loading="communeLoading"
              :search-input.sync="communeSearch"
              hide-no-data
              hide-selected
              item-text="nom"
              item-value="code"
              :label="$t('communeDeResidence')"
              :placeholder="$t('searchCommune')"
              prepend-icon="mdi-map-search-outline"
              return-object
            >
            </v-autocomplete>
          </v-col>

          <template v-if="isUnderage">
            <v-col style="text-align: center; margin: auto;">
              <h3>
                Merci de fournir une
                <a target="_blank" href="storage/autorisationsparentales/Autorisation_Parentale.pdf">autorisation
                  parentale</a>
                pour les bénévoles mineurs
              </h3>
            </v-col>
            <v-col>
              <v-file-input
                truncate-length="50"
                :label="$t('autorisationParentale')"
                required
              />
            </v-col>
          </template>

          <v-col cols="12" sm="4" v-if="infosPerso.activeFields.taille">
            <v-select
              v-model="infosPerso.values.taille"
              prepend-icon="mdi-tshirt-crew-outline"
              :items="infosPerso.tailles"
              :label="$t('tailleTshirt')"
            ></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="infosPerso.values.password"
              :append-icon="infosPerso.showPw ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="infosPerso.passwordRules"
              :type="infosPerso.showPw ? 'text' : 'password'"
              :label="$t('motDePasse')"
              hint="8 caractères minimum"
              loading
              @click:append="infosPerso.showPw = !infosPerso.showPw"
              @blur="infosPerso.showPw = false"
            >
              <template v-slot:progress>
                <v-progress-linear
                  :value="pwProgress"
                  :color="pwColor"
                  absolute
                  height="5"
                ></v-progress-linear>
              </template>
            </v-text-field>
          </v-col>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="infosPerso.values.rePassword"
              :append-icon="infosPerso.showRePw ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="[rePasswordMatchRule]"
              :type="infosPerso.showRePw ? 'text' : 'password'"
              :label="$t('confirmationDeMotDePasse')"
              @click:append="infosPerso.showRePw = !infosPerso.showRePw"
              @blur="infosPerso.showRePw = false"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-checkbox
            v-model="infosPerso.cgu"
            required>
            <template v-slot:label>
              <div>
                En cochant cette case, je certifie avoir pris connaissance des
                <a
                  target="_blank"
                  href="#"
                  @click.stop
                >
                  CGU</a>
                 du site et les accepter
              </div>
            </template>
          </v-checkbox>
        </v-row>
      </v-card-text>

      <v-card-actions>
        <v-btn
          :disabled="!infosPerso.valid || infosPerso.values.email === null || infosPerso.values.password === null"
          color="success"
          class="mr-4"
          @click="submit"
        >
          {{ $t('continuer') }}
        </v-btn>

        <v-btn
          color="error"
          @click="reset"
        >
          {{ $t('effacer') }}
        </v-btn>
      </v-card-actions>

    </v-form>
  </v-card>
</template>

<script>
import {useRegisterStore} from "../stores/Register";

export default {
  name: "InfosPerso",

  data: () => ({
    infosPerso: {
      ///todo Ajouter le choix de code postal

      values: {
        name: "Chaumarat",
        firstname: "Quentin",
        phone: "0606060606",
        email: "a@a.aa",
        birthdate: "2002-03-01",
        taille: null,
        password: "azertY1&",
        rePassword: "azertY1&",
        commune: null,
      }, zvalues: {
        name: null,
        firstname: null,
        phone: null,
        email: null,
        birthdate: null,
        taille: null,
        password: null,
        rePassword: null,
        commune: null,
      },
      activeFields: {
        taille: false,
      },
      cgu:false,
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
      showPw: false,
      showRePw: false,
      passwordRules: [
        v => !!v || 'Mot de passe obligatoire',
        v => /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])((?=.*\W)|(?=.*_))/.test(v) || "Doit contenir au moins un exemplaire de : Majuscule, Minuscule, Chiffre, Caractère spécial",
      ]
    },
    communeLoading: false,
    communeSearch: null,
    listeCommunes: [],
    activePicker: null,
    menu: false,
  }),

  setup() {
    const register = useRegisterStore();

    return {register}
  },

  computed: {
    communes() {
      return this.listeCommunes
    },
    isLandscape() {
      switch (this.$vuetify.breakpoint.name) {
        case 'lg':
          return true
        case 'xl':
          return true
        default:
          return false
      }
    },
    isUnderage() {
      if (this.infosPerso.values.birthdate === null) {
        return false
      } else {
        // return moment().diff(moment(this.infosPerso.values.birthdate), 'years') < 18
        return false
      }
    },
    pwProgress() {
      return (this.infosPerso.values.password == null ? 0 : Math.min(100, this.infosPerso.values.password.length * 12.5))
    },
    pwColor() {
      return (this.infosPerso.values.password == null ? 'white' : ['error', 'warning', 'success'][Math.floor(this.pwProgress / 50)])
    },
    rePasswordMatchRule() {
      return () => (this.infosPerso.values.password === this.infosPerso.values.rePassword) || 'Les mots de passe doivent correspondre'
    }
  },

  watch: {
    menu(val) {
      val && setTimeout(() => (this.activePicker = 'YEAR'))
    },

    communeSearch(val) {
      if (val == null) {
        this.listeCommunes = [];
        return;
      }

      // Items have already been requested
      if (this.communeLoading) return

      this.communeLoading = true

      // Lazily load input items
      fetch('https://geo.api.gouv.fr/communes?nom=' + val + '&fields=code,nom,codesPostaux&boost=population', {headers: {'Access-Control-Allow-Origin' : 'https://geo.api.gouv.fr'}})
        .then(res => res.json())
        .then((res) => {
          console.log(res);
          this.listeCommunes = res;
        })
        .catch(err => {
          console.log(err)
        })
        .finally(() => (this.communeLoading = false))
    },
  },

  methods: {
    save(date) {
      this.$refs.menu.save(date)
    }
    ,
    validate() {
      this.$refs.infosPerso.validate()
    }
    ,
    reset() {
      this.$refs.infosPerso.reset()
    }
    ,
    submit() {
      const registerStore = useRegisterStore();
      registerStore.$patch({
        lastname: this.infosPerso.values.name,
        firstname: this.infosPerso.values.firstname,
        email: this.infosPerso.values.email,
        phone: this.infosPerso.values.phone,
        birthdate: this.infosPerso.values.birthdate,
        isUnderage: this.isUnderage,
        size: this.infosPerso.values.taille,
      });

      this.$emit('continue', this.infosPerso.values.password);
    }
  }

}
</script>

<style scoped>
</style>