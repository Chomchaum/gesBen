<template>
  <v-dialog
    ref="dialog"
    v-model="timeDialog"
    :return-value.sync="time"
    width="290px"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        v-model="time"
        :label="label"
        :disabled="disabled"
        prepend-icon="mdi-clock-time-four-outline"
        readonly
        v-bind="attrs"
        v-on="on"
      ></v-text-field>
    </template>
    <v-time-picker
      format="24hr"
      :max="max"
      :min="min"
      v-if="timeDialog"
      v-model="time"
      full-width
    >
      <v-spacer></v-spacer>
      <v-btn
        text
        color="primary"
        @click="timeDialog = false"
      >
        Cancel
      </v-btn>
      <v-btn
        text
        color="primary"
        @click="() => { $refs.dialog.save(time); $emit('input', time)}"
      >
        OK
      </v-btn>
    </v-time-picker>
  </v-dialog>
</template>

<script>
export default {
  name: "myTimePicker",

  props: [
    'label',
    'max',
    'min',
    'disabled',
  ],

  data: () => ({
    time: null,
    timeDialog: false,
  })
}
</script>

<style scoped>

</style>