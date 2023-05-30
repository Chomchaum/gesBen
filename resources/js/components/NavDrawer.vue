<template>
  <v-navigation-drawer
    app
    clipped
    bottom
  >
    <v-list-item v-if="user !== null" class="px-2" link>
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
      <v-tooltip bottom color="error lighten-1" content-class="px-2 py-1">
        <template v-slot:activator="{on, attrs}">
          <v-icon v-bind="attrs" v-on="on" v-on:click="clog" dark class="mt-n3">mdi-logout</v-icon>
        </template>
        <span>Déconnexion</span>
      </v-tooltip>
    </v-list-item>

    <v-divider v-if="user !== null"></v-divider>

    <v-list
      :dense="false"
      flatflat
      nav
    >
      <v-list-item-group
        v-model="curPage"
        color="primary"
      >
        <v-list-item
          v-for="(item, index) in navItems"
          @click="$emit('changePage', this.curNavItem)"
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
        src="https://www.millenaire3.com/var/m3/storage/images/0/2/9/9/19920-3-fre-FR/A_qui_profite_le_don.png"
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
    'user',
  ],

  data: () => ({
    curNavItem: 2,
  }),

  computed: {},

  methods: {
    clog() {
      this.$emit('logOut')
    }
  }
}
</script>

<style scoped>
</style>