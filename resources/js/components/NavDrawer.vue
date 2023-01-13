<template>
  <v-navigation-drawer app clipped width="10%">
    <v-list
      :dense="(this.$vuetify.breakpoint.name!='xl')"
      nav
    >
      <v-list-item
        v-for="(item, index) in navItems"
        :key="index"
        link
      >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  name: "NavDrawer",
  props: {
    navItems: Array,
  },
}
</script>

<style scoped>

</style>