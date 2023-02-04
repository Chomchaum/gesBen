<template>
  <v-stepper-content :step="curStep">
    <slot>
      <v-container fluid>
        <v-card
          color="grey lighten-1"
          class="mb-12"
          height="200px"
        ></v-card>
        <v-btn
          color="primary"
          @click="$emit('continue')"
        >
          Continue
        </v-btn>
        <v-btn text>
          Cancel
        </v-btn>
      </v-container>
    </slot>
  </v-stepper-content>
</template>

<script>

export default {
  name: "MyStepperContent",

  props: {
    curStep: String,
  },
}
</script>

<style scoped>

</style>