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
        {{ $t('infosPerso') }}
        <small>{{ $t('infosPersoSub') }}</small>
      </v-stepper-step>
      <my-stepper-content cur-step="1">
        <infos-perso v-on:continue="getPwAndContinue($event)"></infos-perso>
      </my-stepper-content>

      <v-stepper-step
        :complete="formStep > 2"
        step="2"
      >
        {{ $t('expBenevole') }}
      </v-stepper-step>
      <my-stepper-content cur-step="2">
        <benevolat v-on:continue="formStep = 1" v-on:submit="submitReg" :loading="loading"></benevolat>
      </my-stepper-content>

<!--      <v-stepper-step
        :complete="formStep > 3"
        step="3"
      >
        {{ $t('vosDispos') }}
      </v-stepper-step>
      <my-stepper-content cur-step="3">
        <disponibilites v-on:continue="formStep = 1" v-on:submit="submitReg" :loading="loading"></disponibilites>
      </my-stepper-content>-->

      <!--      <v-stepper-step
              :complete="formStep > 4"
              step="4"
            >
              {{ $t('creerCompte') }}
              <small>{{ $t('visualisezVotrePlanningToutMoment') }}</small>
            </v-stepper-step>
            <my-stepper-content cur-step="4">
              <account-register v-on:continue="formStep = 1" v-on:submit="submitReg" ref="account_register"></account-register>
            </my-stepper-content>-->

    </v-stepper>
  </v-container>
</template>

<script>
import InfosPerso from "../InfosPerso.vue";
import Benevolat from "../Benevolat.vue";
import Disponibilites from "../Disponibilites.vue";
import MyStepperContent from "../MyStepperContent.vue";
import {useRegisterStore} from "../../stores/Register";

const delay = ms => new Promise(res => setTimeout(res, ms));

export default {
  name: "Register",

  components: {
    Disponibilites,
    Benevolat,
    InfosPerso,
    MyStepperContent,
  },

  data: () => ({
    formStep: 2,
    user_id: null,
    password: null,
    loading: false,
  }),

  setup() {
    const register = useRegisterStore();

    return {register}
  },

  methods: {
    stepUp(n = 1) {
      if (this.formStep === 3) {
      }

      this.formStep += n
      return this.formStep
    },

    getPwAndContinue(val) {
      this.password = val;
      this.stepUp(1)
    },

    submitReg() {
      this.loading = true;
      axios.post('http://localhost:8000/auth/register', {
        name: this.register.firstname + ' ' + this.register.lastname,
        email: this.register.email,
        password: this.password,
      }).then((res) => {
        console.log(res);
        this.user_id = res.data.user_id;
        axios.post('http://localhost:8000/benevole/create', {
          user_id: this.user_id,
          lastname: this.register.lastname,
          firstname: this.register.firstname,
          birthdate: this.register.birthdate,
          isUnderage: this.register.isUnderage,
          phone: this.register.phone,
          size: this.register.size,
        }).then((res) => {
          console.log(res);
        }).catch((err) => {
          console.log(err);
        }).finally(_ => {
          this.loading = false;
        });
      }).catch((err) => {
        console.log(err);
        this.loading = false;
      });
    },
  }
}
</script>

<style scoped>

</style>