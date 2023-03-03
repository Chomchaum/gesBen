<template>
  <v-card flat class="pa-4">
    <v-dialog
      v-model="noChoiceDialog"
      max-width="480"
    >
      <v-card>
        <v-card-title>
          {{ $t('noPrefQuestion') }}
        </v-card-title>
        <v-card-text>
          <p class="mb-1">{{ $t('regExpeBenevoleDialogText') }}</p>
          <p>{{ $t('confirmationQuestion') }}</p>
          <h3 class="success--text">{{ $t('merciFlex') }}</h3>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error darken-1"
            text
            @click="noChoiceDialog = false"
          >
            {{ $t('annuler') }}
          </v-btn>
          <v-btn
            color="primary"
            @click="noChoiceDialog = false; submit();"
          >
            {{ $t('continuer') }}
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
          <v-card-title>{{ $t('ancienBenevoleQuestion') }}</v-card-title>
          <v-card-subtitle>
            <v-radio-group
              v-model="ancienBenevole"
              class="ml-4"
              hide-details
              row
            >
              <v-radio
                :label="$t('nonPasEncore')"
                :value="false"
              ></v-radio>
              <v-radio
                :label="$t('oui')"
                :value="true"
              ></v-radio>
            </v-radio-group>
          </v-card-subtitle>

          <v-card-text class="pb-1">
            <my-combobox
              :disabled="!ancienBenevole"
              v-model="anciensPostesChips"
              :items="examplesAnciensPostes"
              :label="$t('ancienPosteLabel')"
              hint="Maximum 2 postes"
            />
          </v-card-text>
        </v-card>

        <!--  Formulaire choix de poste  -->
        <v-card color='#333' class="pa-2 pb-0 mb-3">
          <v-card-title>{{ $t('choixPosteQuestion') }}</v-card-title>
          <v-card-subtitle><span class="warning--text text--lighten-2">{{ $t('choixPosteNonGaranti') }}</span>
          </v-card-subtitle>
          <v-card-text class="pb-1">
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

        <!--    Disponibilités    -->
        <v-card color="#333" class="pa-2 pb-0 mb-3">
          <v-card-title>
            {{ $t('vosDispos') }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col class="premcol"></v-col>
              <v-col class="autrecol">Matin</v-col>
              <v-col class="autrecol">Après-midi</v-col>
              <v-col class="autrecol">Soirée</v-col>
            </v-row>
            <div v-for="jour in dispos" :key="jour.date">
              <v-divider class="my-2"/>
              <v-row>
              <v-col class="premcol">{{ jour.date }}</v-col>
              <v-col v-for="creneau in jour.periodes" :key="creneau.label" class="autrecol">
                <v-simple-checkbox v-model="creneau.value" :disabled="creneau.disabled"></v-simple-checkbox>
              </v-col>
              </v-row>
            </div>
          </v-card-text>
        </v-card>

        <!--  Input de commentaire  -->
        <v-card color="#333" class="pa-2 pb-0 mb-3">
          <v-card-text>
            <v-textarea
              v-model="comment"
              rows="3"
              :label="$t('commentLabel')"
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
          :loading="loading"
        >
          {{ $t('continuer') }}
        </v-btn>

        <v-btn
          color="error"
          class="mr-4"
          @click="clear"
        >
          {{ $t('effacer') }}
        </v-btn>

        <v-btn
          color="warning"
          @click="$emit('continue')"
        >
          {{ $t('annuler') }}
        </v-btn>

      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
import SelectPoste from "./SelectPoste.vue";
import MyCombobox from "./MyCombobox.vue";
import {useRegisterStore} from "../stores/Register";

export default {
  name: "Benevolat",
  components: {
    SelectPoste,
    MyCombobox,
  },

  data: () => ({
    valid: true,

    ancienBenevole: true,
    choixPostes: [
      {numChoix: 1, value: 'Brigade Verte'},
      {numChoix: 2, value: 'Bar'},
      {numChoix: 3, value: null},
    ],

    ///todo Récupérer les dates en DB
    dispos: [
      {
        date: 'Vendredi 8 juillet', periodes: [
          {label: 'matin', value: false, disabled: true},
          {label: 'après-midi', value: false, disabled: false},
          {label: 'soirée', value: false, disabled: false},
        ]
      },
      {
        date: 'Jour 2', periodes: [
          {label: 'matin', value: false, disabled: false},
          {label: 'après-midi', value: false, disabled: false},
          {label: 'soirée', value: false, disabled: false},
        ]
      },
      {
        date: 'Jour 3', periodes: [
          {label: 'matin', value: false, disabled: false},
          {label: 'après-midi', value: false, disabled: false},
          {label: 'soirée', value: false, disabled: false},
        ]
      },
      {
        date: 'Jour 4', periodes: [
          {label: 'matin', value: false, disabled: false},
          {label: 'après-midi', value: false, disabled: true},
          {label: 'soirée', value: false, disabled: true},
        ]
      },
    ],
    noChoiceDialog: false,
    anciensPostesChips: [{text: 'Bar', color: 'red',}, {text: 'Parking', color: 'purple',}],

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

    comment: "plop",
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
        exPostes: this.anciensPostes,
        choixPostes: this.choixPostes,
        comment: this.comment,
      });

      this.$emit('submit');
    }
  },
}
</script>

<style scoped>
.premcol {
  flex-grow: 2;
}
.autrecol {
  flex-grow: 3;
  text-align: center;
}
</style>