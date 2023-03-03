<template>
  <v-navigation-drawer
    app
    clipped
    bottom
  >
    <v-list-item v-if="loggedIn" class="px-2" link>
      <v-list-item-avatar color="indigo" class="my-4">
        <v-icon dark>mdi-account</v-icon>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title class="text-h6">
          {{ $t('prnom') }}
        </v-list-item-title>
        <v-list-item-subtitle>
          {{ $t('monCompte') }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-divider v-if="loggedIn"></v-divider>

    <v-list
      :dense="false"
      flatflat
      nav
    >
      <v-list-item-group
        v-model="locCurPage"
        color="primary"
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
      </v-list-item-group>
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
  props: [
    'curPage',
    'navItems',
  ],

  data: () => ({
    locCurPage: 2,
    loggedIn: false,
  }),

  computed: {
  },
}
</script>

<style scoped>
</style>