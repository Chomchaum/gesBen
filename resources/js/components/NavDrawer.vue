<template>
  <v-navigation-drawer app clipped>
    <v-list-item class="px-2">
      <v-list-item-avatar color="indigo" class="my-4">
        <v-icon dark>mdi-account</v-icon>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title class="text-h6">
          Prénom
        </v-list-item-title>
        <v-list-item-subtitle>
          Mon Compte
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-divider></v-divider>

    <v-list
      :dense="false"
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
    <template v-slot:append>
        <v-img
          :max-height="220"
          contain
          eager
          src="https://p.calameoassets.com/190513145100-e426154fc616d70b07ea3fc25b7fe9ef/p1.jpg"
        ></v-img>
    </template>
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