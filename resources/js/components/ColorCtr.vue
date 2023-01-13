<template>
  <v-container class="ColorCtr">
    <slot></slot>
  </v-container>
</template>

<script>
export default {
  name: "ColorCtr"
}
</script>

<style scoped>
.ColorCtr {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
}
</style>