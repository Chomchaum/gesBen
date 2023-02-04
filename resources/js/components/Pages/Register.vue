<template>
  <v-container>
    <v-stepper class="pb-4 ben-reg-form"
               v-model="formStep"
               vertical
    >
      <v-stepper-step
        :complete="formStep > 1"
        step="1"
      >
        {{ $t('informationsPersonnelles') }}
        <small>{{ $t('quelquesInformationsPourMieuxVousConnatre') }}</small>
      </v-stepper-step>
      <my-stepper-content cur-step="1">
        <infos-perso v-on:continue="stepUp(1)"></infos-perso>
      </my-stepper-content>

      <v-stepper-step
        :complete="formStep > 2"
        step="2"
      >
        {{ $t('votreExprienceEnTantQueBnvole') }}
      </v-stepper-step>
      <my-stepper-content cur-step="2">
        <benevolat v-on:continue="formStep += 1"></benevolat>
      </my-stepper-content>

      <v-stepper-step
        :complete="formStep > 3"
        step="3"
      >
        {{ $t('vosDisponibilits') }}
      </v-stepper-step>
      <my-stepper-content cur-step="3">
        <disponibilites v-on:continue="formStep += 1"></disponibilites>
      </my-stepper-content>

      <v-stepper-step
        :complete="formStep > 4"
        step="4"
      >
        {{ $t('creerCompte') }}
        <small>{{ $t('visualisezVotrePlanningToutMoment') }}</small>
      </v-stepper-step>
      <my-stepper-content cur-step="4">
        <account-register v-on:continue="formStep = 1" v-on:submit="submitReg" ref="account_register"></account-register>
      </my-stepper-content>

    </v-stepper>
  </v-container>
</template>

<script>
import InfosPerso from "../InfosPerso.vue";
import Benevolat from "../Benevolat.vue";
import Disponibilites from "../Disponibilites.vue";
import AccountRegister from "../AccountRegister.vue";
import MyStepperContent from "../MyStepperContent.vue";
import {useRegisterStore} from "../../stores/Register";

export default {
  name: "Register",

  components: {
    AccountRegister,
    Disponibilites,
    Benevolat,
    InfosPerso,
    MyStepperContent,
  },

  data: () => ({
    formStep: 3,
  }),

  setup() {
    useRegisterStore();
  },

  methods: {
    stepUp(n = 1) {
      if (this.formStep === 3) {
      }

      this.formStep += n
      return this.formStep
    },

    submitReg() {
      return true
    },
  }
}
</script>

<style scoped>

</style>