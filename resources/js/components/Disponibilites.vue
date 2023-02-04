<template>
  <v-card flat class="pa-4">
    <!--  Dialog de confirmation  -->
    <v-dialog
      v-model="delDialog"
      max-width="390"
    >
      <v-card>
        <v-card-title>
          {{ $t('retirerCetteDisponibilit') }}
        </v-card-title>
        <v-card-text>
          {{ $t('pourModifierVotreDisponibilitVousPouvezSupprimerCe') }}
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
              :label="$t('debutDeLaPlageHoraire')"
              :min="calendar.start"
              :max="dispoForm.end === null ? calendar.end : addHours(dispoForm.end, -2)"
              v-on:input="dispoForm.start=$event"
            />
          </v-col>
          <v-col cols="12" sm="4">
            <my-date-time
              :label="$t('finDeLaPlageHoraire')"
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
      >
        {{ $t('continuer') }}
      </v-btn>

      <v-btn
        color="error"
        @click="clear"
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

  components: {
    MyTimePicker,
    MyDateTime,
  },

  data: () => ({
    dispoForm: {
      start: null,
      end: null,
      date: '2023-07-01',
    },
    autoIncrementId: 3,
    dispos: [
      {"start": "2023-07-01 10:30", "end": "2023-07-01 13:00", "id": 0, "horaires": "10:30 - 13:00"},
      {"start": "2023-06-30 10:30", "end": "2023-06-30 13:00", "id": 1, "horaires": "10:30 - 13:00"},
      {"start": "2023-07-02 10:30", "end": "2023-07-02 13:00", "id": 2, "horaires": "10:30 - 13:00"},
    ],

    calendar: {
      start: '2023-06-30 16:00',
      end: '2023-07-02 14:00',
      selectedDispoId: null,
    },
    delDialog: false,
  }),

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
    },

    submit() {
      const store = useRegisterStore();
      store.$patch({
        availRanges: this.dispos,
      });

      this.$emit('continue');
    }
  }
}
</script>

<style scoped>

</style>