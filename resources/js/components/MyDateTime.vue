<template>
  <v-dialog
    ref="dialog"
    v-model="dialog"
    transition="scale-transition"
    width="350px"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        v-model="datetime"
        :label="label"
        :disabled="disabled"
        prepend-icon="mdi-calendar-clock"
        mask="YYYY-MM-DD HH:mm"
        :min="(min == null ? undefined : min.split(' ')[0])"
        :max="(max == null ? undefined : max.split(' ')[0])"
        v-bind="attrs"
        v-on="on"
      ></v-text-field>
    </template>
    <v-date-picker
      v-model="date"
      full-width
      first-day-of-week="1"
      locale="fr"
      :active-picker.sync="activeDatePicker"
      :weekday-format="weekdayFormatter"
      :title-date-format="titleDateFormatter"
      :header-date-format="headerDateFormatter"
      :month-format="monthFormatter"
      :min="(min == null ? undefined : min.split(' ')[0])"
      :max="(max == null ? undefined : max.split(' ')[0])"
      v-if="datePick"
      @change="datePick=false;"
    />
    <v-time-picker
      v-model="time"
      full-width
      format="24hr"
      :min="minTime"
      :max="maxTime"
      v-else
      @change="save"
    />
  </v-dialog>
</template>

<script>
import moment from "moment/moment";

export default {
  name: "myDateTime",

  props: [
    'label',
    'min',
    'max',
    'disabled',
  ],

  data: () => ({
    activeDatePicker: null,
    datePick: true,
    date: null,
    time: null,
    dialog: false,
  }),

  computed: {
    datetime: {
      get: function () {
        if (this.date == null) {
          return null
        } else if (this.time == null) {
          return this.date
        } else {
          return this.date + ' ' + this.time
        }
      },
      set: function (newValue) {
        if (newValue == null) {
          this.date = null
          this.time = null
        } else {
          let newValues = newValue.split(' ')
          this.date = newValues[0]
          this.time = newValues[1]
        }
      }
    },
    minTime: function () {
      return ((this.min == null || this.date > this.min.split(' ')[0]) ? undefined : this.min.split(' ')[1])
    },
    maxTime: function () {
      return ((this.max == null || this.date < this.max.split(' ')[0]) ? undefined : this.max.split(' ')[1])
    }
  },

  watch: {
    dialog(val) {
      val && setTimeout(() => (this.activeDatePicker = 'YEAR'))
    },
  },

  methods: {
    weekdayFormatter(timestamp){
      return moment(timestamp).format('dd')[0].toUpperCase()
    },
    monthFormatter(timestamp){
      return moment(timestamp).format('MMM')
    },
    titleDateFormatter(timestamp){
      console.log(timestamp)
      return moment(timestamp).format('dddd D MMM')
    },
    headerDateFormatter(timestamp){
      return moment(timestamp).format('YYYY')
    },

    save(time) {
      this.$refs.dialog.save(time);
      this.datePick=true;
      this.$emit('input', this.datetime)
    }
  }
}
</script>

<style scoped>

</style>