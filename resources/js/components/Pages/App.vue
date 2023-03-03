<template>
  <div class="myapp">
    <nav-drawer :nav-items="navItems" :cur-page="curPage"/>

    <v-app-bar app clipped-left>
      <h1>Mes Supers Bénévoles</h1>
    </v-app-bar>

    <v-main>
      <debug :is_debug="app_debug"/>
      <register/>

    </v-main>

    <v-footer app>
      <v-spacer/>
      <h5>
        <v-icon small>mdi-copyright</v-icon>
        Chomchaum
      </h5>
    </v-footer>
  </div>
</template>

<script>
import NavDrawer from "../NavDrawer.vue";

import Debug from "../Debug.vue";

import Home from "./Home.vue";
import Dashboard from "./Dashboard.vue";
import Register from "./Register.vue";
import Planning from "./Planning.vue";
import About from "./About.vue";

export default {
  name: "App",
  components: {
    NavDrawer,
    Debug,
    Home,
    Dashboard,
    Register,
    Planning,
    About,
  },

  data: () => ({
    navItems: [
      {id: 0, title: 'Accueil', icon: 'mdi-home'},
      {id: 1, title: 'Dashboard', icon: 'mdi-view-dashboard'},
      {id: 2, title: 'Participer', icon: 'mdi-account-plus'},
      {id: 3, title: 'Planning', icon: 'mdi-timeline-text'},
      {id: 4, title: 'À propos', icon: 'mdi-help-box'},
    ],
    right: null,
    app_debug: false,
    curPage: 2,
  }),

  computed: {
  },

  methods: {
    log(val) {
      console.log(val)
    },
  },
}
</script>

<style>
html {
  overflow-y: auto;
}

.v-icon {
  bottom: 1px;
}
</style>