<template>
  <v-navigation-drawer
    app
    clipped
    left
    v-model="drawer"
    width=226
  >
    <v-list
      :dense="false"
      nav
    >
      <v-list-item-group
        :value="curItem"
        color="primary"
        mandatory
      >
        <v-list-item
          v-for="item in navItems"
          @click="$emit('changePage', item.id)"
          v-if="item.id > 0"
          v-show="item.show"
          :key="item.id"
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
        src="images/default_poster.png"
      ></v-img>
    </template>
  </v-navigation-drawer>
</template>

<script>
export default {
  name: "NavDrawer",
  props: [
    'navItems',
    'drawer',
  ],

  data: () => ({
    curItem: null
  }),
}
</script>

<style scoped>
</style>