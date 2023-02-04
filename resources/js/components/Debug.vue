<template>
  <div v-if="is_debug">
    <v-card class="mx-auto px-4 py-2"
            max-width="80%"
            outline>
      <color-ctr class="align-center">
        <v-switch v-model="isDarkTheme" :label="((isDarkTheme) ? 'Dark' : 'White') + ' Theme'"></v-switch>
        <v-btn color="primary">
          {{ $t('primary') }}
        </v-btn>
        <v-btn color="secondary">
          {{ $t('secondary') }}
        </v-btn>
        <v-btn color="accent"
               :class="(()=>{if(isDarkTheme) return {'theme--dark':true}; return {'theme--light':true};})()">
          {{ $t('accent') }}
        </v-btn>
        <v-btn color="error">
          {{ $t('error') }}
        </v-btn>
        <v-btn color="info">
          {{ $t('info') }}
        </v-btn>
        <v-btn color="success">
          {{ $t('success') }}
        </v-btn>
        <v-btn color="warning">
          {{ $t('warning') }}
        </v-btn>
      </color-ctr>
    </v-card>
  </div>
</template>

<script>
import ColorCtr from "./ColorCtr.vue";

export default {
  name: "Colors",
  components: {
    ColorCtr,
  },
  props: ["is_debug"],
  data() {
    return {
      isDarkTheme: false,
    }
  }
}
</script>

<style scoped>

</style>