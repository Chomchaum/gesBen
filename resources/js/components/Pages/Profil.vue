<template>
  <v-container>
    <v-card width="80%" class="ma-auto">
      <v-card-title class="ma-2">
        <h2>Mon profil</h2>
      </v-card-title>
      <v-card-subtitle class="ma-2">
        <h2 class="success--text text--darken-1" style="text-decoration: underline dotted">Mes informations</h2>
      </v-card-subtitle>
      <v-card-text>
        <v-row style="align-items: center; text-align: center">
          <v-col lg="4">
            <v-avatar color="indigo" size="140" @click="showEditPP">
              <span class="white--text text-h2 text-xl-h1">
                {{ user.firstname.charAt(0) + user.lastname.charAt(0) }}
              </span>
            </v-avatar>
            <v-btn small text class="mt-2" @click="showEditPP">Ajouter une photo</v-btn>
          </v-col>
          <v-col lg="7">
            <v-text-field
              label="Identifiant / Adresse email"
              :value="user.email"
              disabled
            />
            <v-text-field
              label="Prénom"
              :value="user.firstname"
              readonly
            />
            <v-text-field
              label="Nom de famille"
              :value="user.lastname"
              readonly
            />
          </v-col>
        </v-row>
      </v-card-text>
      <v-divider class="mx-4"/>
      <v-card-subtitle class="ma-2">
        <h2 class="success--text text--darken-1" style="text-decoration: underline dotted">
          Changer mon mot de passe
        </h2>
      </v-card-subtitle>
      <v-card-text>
        <v-row style="align-items: center; text-align: center">
          <v-col lg="4" offset-lg="1">
            <v-text-field
              label="Mot de passe"
              v-model="password"
            />
          </v-col>
          <v-col lg="4" offset-lg="1">
            <v-text-field
              label="Confirmation de mot de passe"
              v-model="rePassword"
            />
          </v-col>
        </v-row>
      </v-card-text>
      <v-divider class="mx-4"/>
      <v-card-subtitle class="ma-2">
        <h2 class="success--text text--darken-1" style="text-decoration: underline dotted">Mes coordonnées</h2>
      </v-card-subtitle>
      <v-card-text>
        <v-row style="align-items: center; text-align: center">
          <v-col lg="10" offset-lg="1">
            <v-text-field
              label="Adresse postale"
              v-model="adresse"
            />
          </v-col>
          <v-col lg="10" offset-lg="1">
            <v-radio-group
              v-model="user.contact_fav"
              label="Moyen de communication préféré"
              mandatory
            >
              <v-text-field
                label="Adresse email"
                :value="user.email"
                readonly
              >
                <template v-slot:prepend>
                  <v-radio
                    label=""
                    value="email"
                  />
                </template>
              </v-text-field>
              <v-text-field
                label="Téléphone"
                v-model="telephone"
              >
                <template v-slot:prepend>
                  <v-radio
                    label=""
                    value="telephone"
                  />
                </template>
              </v-text-field>
            </v-radio-group>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import {useUserStore} from "../../stores/User";

export default {
  name: "Profil",

  setup() {
    const userStore = useUserStore();
    return {userStore}
  },

  data: () => ({
    password: null,
    rePassword: null,
    fav_comm: null,
    adresse: null,
    telephone: null,
  }),

  computed: {
    user() {
      return this.userStore.auth_user
    }
  },

  methods: {
    showEditPP() {
      /// todo Fonction d'ajout de PP + toggle texte bouton
      console.log('editPP')
    }
  }
}
</script>

<style scoped>

</style>