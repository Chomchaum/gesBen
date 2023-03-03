<template>
  <v-card flat class="pa-4">
    <!--  Dialog de confirmation  -->
    <v-dialog
      v-model="delDialog"
      max-width="390"
    >
      <v-card>
        <v-card-title>
          {{ $t('retirerCetteDispo') }}
        </v-card-title>
        <v-card-text>
          {{ $t('dispoDelDialogText') }}
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error darken-1"
            text
            @click="delDialog = false"
          >
            {{ $t('annuler') }}
          </v-btn>
          <v-btn
            color="primary"
            @click="delDispo"
          >
            {{ $t('supprimer') }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-card-title>{{ $t('ajoutezPlagesDispo') }}</v-card-title>
    <v-card-text>
      <v-form ref="createDispoForm">
        <v-row>
          <v-col cols="12" sm="4">
            <my-date-time
              :label="$t('debutDeLaPlage')"
              :min="calendar.start"
              :max="dispoForm.end === null ? calendar.end : addHours(dispoForm.end, -2)"
              v-on:input="dispoForm.start=$event"
            />
          </v-col>
          <v-col cols="12" sm="4">
            <my-date-time
              :label="$t('finDeLaPlage')"
              :min="dispoForm.start === null ? calendar.start : addHours(dispoForm.start, 2)"
              :max="calendar.end"
              v-on:input="dispoForm.end=$event"
            />
          </v-col>
          <v-col cols="12" sm="4" style="display: flex; align-items: center; justify-content: center">
            <v-btn
              class="mb-3"
              :disabled="(dispoForm.start == null || dispoForm.end == null)"
              @click="addDispo()"
            >
              {{ $t('ajouterUnePlage') }}
            </v-btn>
          </v-col>
        </v-row>
      </v-form>

      <v-calendar
        style="height: 48vh"
        color="primary"
        type="custom-daily"
        locale="fr"
        :short-weekdays="false"
        :weekdays="[1,2,3,4,5,6,0]"
        :interval-format="intervalFormatter"
        :weekday-format="weekdayFormatter"
        :start="calendar.start"
        :end="calendar.end"
        :events="dispos"
        @click:event="clickEvent($event)"
      >
        <template v-slot:event="{ event }"
        >
          <v-container
            color="primary"
          >
            <v-row>
              <v-col cols="12" sm="11">
                {{ event.horaires }}
              </v-col>
              <v-col cols="12" sm="1">
                <v-icon
                >
                  mdi-close-thick
                </v-icon>
              </v-col>
            </v-row>
          </v-container>
        </template>
      </v-calendar>
    </v-card-text>

    <v-card-actions>
      <v-btn
        color="success"
        class="mr-4"
        @click="submit"
        :loading="loading"
      >
        {{ $t('continuer') }}
      </v-btn>

      <v-btn
        color="error"
        @click="$emit('continue')"
      >
        {{ $t('effacer') }}
      </v-btn>

    </v-card-actions>
  </v-card>
</template>

<script>
import MyTimePicker from "./MyTimePicker.vue";
import MyDateTime from "./MyDateTime.vue";
import moment from "moment";
import {useRegisterStore} from "../stores/Register";

export default {
  name: "Disponibilites",

  props: ['loading'],

  components: {
    MyTimePicker,
    MyDateTime,
  },

  data: () => ({
    dispoForm: {
      start: null,
      end: null,
    },
    autoIncrementId: 3,
    dispos: [
      {
        "id": 3,
        "start": "2023-06-30 16:00",
        "end": "2023-06-30 22:00",
        "horaires": "16:00 - 22:00"
      },
      {
        "id": 4,
        "start": "2023-06-30 18:00",
        "end": "2023-06-30 20:00",
        "horaires": "18:00 - 20:00"
      },
      {
        "id": 5,
        "start": "2023-07-01 13:00",
        "end": "2023-07-01 17:00",
        "horaires": "13:00 - 17:00"
      },
      {
        "id": 6,
        "start": "2023-07-01 15:00",
        "end": "2023-07-01 19:00",
        "horaires": "15:00 - 19:00"
      },
      {
        "id": 7,
        "start": "2023-07-01 16:00",
        "end": "2023-07-01 20:00",
        "horaires": "16:00 - 20:00"
      },
      {
        "id": 8,
        "start": "2023-07-02 09:00",
        "end": "2023-07-02 11:00",
        "horaires": "09:00 - 11:00"
      },
      {
        "id": 9,
        "start": "2023-07-02 12:00",
        "end": "2023-07-02 14:00",
        "horaires": "12:00 - 14:00"
      },
      {
        "id": 10,
        "start": "2023-07-01 23:00",
        "end": "2023-07-02 06:00",
        "horaires": "23:00 - 06:00"
      },
      {
        "id": 11,
        "start": "2023-07-02 03:00",
        "end": "2023-07-02 07:00",
        "horaires": "03:00 - 07:00"
      }
    ],

    calendar: {
      start: '2023-06-30 16:00',
      end: '2023-07-02 14:00',
      selectedDispoId: null,
    },
    delDialog: false,
  }),

  setup() {
  },

  methods: {
    log_moment(timestamp, format) {
      return moment(timestamp).format(format)
    },

    addHours(datetime, hours) {
      return moment(datetime).add(hours, 'hours').format('YYYY-MM-DD HH:mm')
    },

    addDispo() {
      // Ajoute la dispo au calendrier
      this.dispos.push({
        id: this.autoIncrementId,
        start: this.dispoForm.start,
        end: this.dispoForm.end,
        horaires: moment(this.dispoForm.start).format('LT') + ' - ' + moment(this.dispoForm.end).format('LT'),
      })

      ++this.autoIncrementId;

      // Reset les champs
      this.$refs.createDispoForm.reset();
      this.dispoForm.start = null;
      this.dispoForm.end = null;
    },

    ///todo Ajouter la suppression des events
    delDispo() {
      const id = this.calendar.selectedDispoId;
      const dispoIndex = this.dispos.findIndex((dispo) => dispo.id === id);

      if (dispoIndex > -1) {
        this.dispos.splice(dispoIndex, 1);
        this.calendar.selectedDispoId = null;
        this.delDialog = false;
      }
    },

    intervalFormatter(timestamp) {
      return moment(timestamp).format('HH:mm')
    },
    weekdayFormatter(timestamp) {
      return moment(timestamp.date).format('dddd')
    },

    clickEvent(event) {
      this.calendar.selectedDispoId = event.event.id
      this.delDialog = true;
    },

    clear() {
      this.$refs.createDispoForm.reset()
      this.dispos = [];

      this.$emit('continue')
    },

    submit() {
      const store = useRegisterStore();
      store.$patch({
        plagesDispo: this.dispos,
      });

      this.$emit('submit');
    },
  }
}
</script>

<style scoped>

</style>