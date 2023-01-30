<template>
  <v-card flat class="pa-4">
    <v-card-title>Ajoutez des plages pour chacune de vos disponibilités</v-card-title>
    <v-card-text>
      <v-form ref="createDispoForm">
        <v-row>
          <v-col cols="12" sm="4">
            <my-date-time
              label="Début de la plage"
              :min="eventStart"
              :max="calendarForm.end === null ? eventEnd : addHours(calendarForm.end, -2)"
              v-on:input="calendarForm.start=$event"
            />
          </v-col>
          <v-col cols="12" sm="4">
            <my-date-time
              label="Fin de la plage"
              :min="calendarForm.start === null ? eventStart : addHours(calendarForm.start, 2)"
              :max="eventEnd"
              v-on:input="calendarForm.end=$event"
            />
          </v-col>
          <v-col cols="12" sm="4" style="display: flex; align-items: center; justify-content: center">
            <v-btn
              class="mb-3"
              :disabled="(calendarForm.start == null || calendarForm.end == null)"
              @click="addDispo()"
            >
              Ajouter une plage
            </v-btn>
          </v-col>
        </v-row>
      </v-form>
      <v-calendar
        style="height: 48vh"
        color="primary"
        type="custom-daily"
        locale="br"
        :short-weekdays="false"
        :weekdays="[1,2,3,4,5,6,0]"
        :interval-format="intervalFormatter"
        start="2023-06-30"
        end="2023-07-02"
        :events="dispos"
        @click:event="clickEvent($event)"
      >
      </v-calendar>
    </v-card-text>
    <v-card-actions>
      <v-btn
        color="success"
        @click="$emit('continue')"
      >
        Continuer
      </v-btn>
      <v-btn color="error">
        Effacer
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import MyTimePicker from "../myTimePicker.vue";
import MyDateTime from "../MyDateTime.vue";
import moment from "moment";

export default {
  name: "Disponibilites",

  components: {
    MyTimePicker,
    MyDateTime,
  },

  data: () => ({
    calendarForm: {
      start: null,
      end: null,
      date: '2023-07-01',
    },

    eventStart: '2023-06-30 16:00',
    eventEnd: '2023-07-02 14:00',
    dates: [
      '2023-06-30',
      '2023-07-01',
      '2023-07-02',
    ],

    autoIncrementId: 1,
    dispos: [{"start": "2023-07-01 10:30", "end": "2023-07-01 13:00", "id": 0}],
    selectedEvent: null,
  }),

  methods: {
    log_moment() {
      return moment()
    },

    addHours(datetime, hours) {
      return moment(datetime).add(hours, 'hours').format('YYYY-MM-DD HH:mm')
    },

    addDispo() {
      // Ajoute la dispo au calendrier
      this.dispos.push({
        id: this.autoIncrementId,
        start: this.calendarForm.start,
        end: this.calendarForm.end,
      })

      ++this.autoIncrementId;

      // Reset les champs
      this.$refs.createDispoForm.reset();
      this.calendarForm.start = null;
      this.calendarForm.end = null;
    },
    ///todo Ajouter la suppression des events
    intervalFormatter(locale) {
      return locale.time
    },

    clickEvent(event) {
      console.log(event);
      return false;
    }
  }
}
</script>

<style scoped>

</style>