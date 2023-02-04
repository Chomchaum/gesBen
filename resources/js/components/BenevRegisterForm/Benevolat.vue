<template>
  <v-card flat class="pa-4">
    <v-dialog
      v-model="noChoiceDialog"
      max-width="480"
    >
      <v-card>
        <v-card-title>
          Pas de préférences ?
        </v-card-title>
        <v-card-text>
          <p class="mb-1">Vous avez validé le formulaire sans fournir de poste préférentiel.</p>
          <p>Voulez-vous vraiment continuer ?</p>
          <h3 class="success--text">Merci pour votre flexibilité</h3>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error darken-1"
            text
            @click="noChoiceDialog = false"
          >
            Annuler
          </v-btn>
          <v-btn
            color="primary"
            @click="noChoiceDialog = false; submit();"
          >
            Continuer
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-form
      ref="benevolat"
      v-model="valid"
      lazy-validation
    >
      <v-card-text><!--  Formulaire ancien bénévole  -->
        <v-card color='#333' class="pa-2 pb-0 mb-3">
          <v-card-title>Avez-vous déjà été bénévole pour le festival ?</v-card-title>
          <v-card-subtitle>
            <v-radio-group
              v-model="ancienBenevole"
              mandatory
              class="ml-4"
              row
            >
              <v-radio
                label="Non, pas encore"
                :value="false"
              ></v-radio>
              <v-radio
                label="Oui"
                :value="true"
              ></v-radio>
            </v-radio-group>
          </v-card-subtitle>

          <v-card-text>
            <h3 class="mb-2">À quel(s) poste(s) ?</h3>
            <my-combobox
              :disabled="!ancienBenevole"
              v-model="anciensPostesChips"
              :items="examplesAnciensPostes"
              label="Ajoutez vos anciens postes"
              hint="Maximum 2 postes"
            />
          </v-card-text>
        </v-card>

        <!--  Formulaire choix de poste  -->
        <v-card color='#333' class="pa-2 pb-0 mb-3">
          <v-card-title>Quel poste préféreriez-vous occuper pour cette édition ?</v-card-title>
          <v-card-subtitle><span class="warning--text text--lighten-2">Le choix de votre poste n'est pas garanti en raison de contraintes organisationnelles.</span>
          </v-card-subtitle>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="4" v-for="choixPoste in choixPostes"
                     v-bind:key="choixPoste.numChoix">
                <select-poste
                  :num-choix="choixPoste.numChoix"
                  :liste-postes="listePostes"
                  :other-choices="otherChoices(choixPoste.numChoix)"
                  v-model="choixPoste.value"
                >
                </select-poste>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>

    <!--  Input de commentaire  -->
        <v-card color="#333" class="pa-2 pb-0 mb-3">
          <v-card-title class="pb-0">
            Informations complémentaires
          </v-card-title>
          <v-card-text class="pt-0">
            <v-textarea
              v-model="comment"
              rows="3"
              label="Si vous souhaitez porter un élément à notre connaissance"
            />
          </v-card-text>

        </v-card>
      </v-card-text>

      <v-card-actions>
        <v-btn
          :disabled="!valid"
          color="success"
          class="mr-4"
          @click="confirmSubmit"
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
    </v-form>
  </v-card>
</template>

<script>
import SelectPoste from "./SelectPoste.vue";
import MyCombobox from "../MyCombobox.vue";
import {useRegisterStore} from "../../stores/Register";

export default {
  name: "Benevolat",
  components: {
    SelectPoste,
    MyCombobox,
  },

  data: () => ({
    valid: true,

    ancienBenevole: false,
    choixPostes: [
      {numChoix: 1, value: null},
      {numChoix: 2, value: null},
      {numChoix: 3, value: null},
    ],
    noChoiceDialog: false,
    anciensPostesChips: [],

    ///todo Utiliser la liste des postes pour les exemples
    examplesAnciensPostes: [
      {header: 'Vous pouvez indiquer des postes non suggérés et valider avec Entrée'},
      {text: 'Accueil', color: 'blue',},
      {text: 'Bar', color: 'red',},
      {text: 'Montage/Démontage', color: 'green',},
      {text: 'Parking', color: 'purple',},
    ],

    ///todo Pour teamSize et Candidats, ne pas utiliser une donnée globale mais le min des plages horaires
    listePostes: [
      {text: 'Montage/Démontage', value: 'Montage/Démontage', teamSize: 8, candidats: 16},
      {text: 'Brigade Verte', value: 'Brigade Verte', teamSize: 12, candidats: 20},
      {text: 'Bar', value: 'Bar', teamSize: 12, candidats: 5},
      {text: 'Accueil', value: 'Accueil', teamSize: 6, candidats: 0},
      {text: 'Merchandising', value: 'Merchandising', teamSize: 12, candidats: 7},
      {text: 'Parking', value: 'Parking', teamSize: 4, candidats: 3},
      {text: 'Loges', value: 'Loges', teamSize: 12, candidats: 11},
      {text: 'Catering', value: 'Catering', teamSize: 12, candidats: 12},
    ],

    comment: null,
  }),

  computed: {
    anciensPostes() {
      return this.anciensPostesChips.map(a => a.text)
    },
  },

  methods: {
    log(value) {
      console.log(value)
    },

    otherChoices(currChoiceId) {
      return this.choixPostes.filter((elem) => {
        return elem.numChoix !== currChoiceId;
      }).map((elem) => {
        return elem.value;
      });
    },

    validate() {
      this.$refs.benevolat.validate()
    },

    clear() {
      this.$refs.benevolat.reset()
      this.ancienBenevole = false;
      this.anciensPostesChips = [];
      this.choixPostes = [
        {numChoix: 1, value: null},
        {numChoix: 2, value: null},
        {numChoix: 3, value: null},
      ];
    },

    confirmSubmit() {
      if (this.choixPostes.every((elem) => elem.value === null)) {
        this.noChoiceDialog = true;
      } else {
        this.submit()
      }
    },

    submit() {
      const store = useRegisterStore();
      store.$patch({
        exOffices: this.anciensPostes,
        chosenOffices: this.choixPostes,
        comment: this.comment,
      });

      this.$emit('continue');
    }
  },
}
</script>

<style scoped>

</style>