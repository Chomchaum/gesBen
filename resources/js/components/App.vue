<template>
  <div class="myapp">
    <nav-drawer :nav-items="navItems"/>

    <v-app-bar app clipped-left>
      <h1>Mes Supers Bénévoles</h1>
    </v-app-bar>

    <v-main>
      <debug :is_debug="app_debug"/>

      <ben-reg-form/>

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
import Debug from "./Debug.vue";
import NavDrawer from "./NavDrawer.vue";
import BenRegForm from "./BenevRegisterForm/BenRegForm.vue";

export default {
  name: "App",
  components: {
    BenRegForm,
    NavDrawer,
    Debug,
  },

  data() {
    return {
      navItems: [
        {title: 'Dashboard', icon: 'mdi-view-dashboard'},
        {title: 'Participer', icon: 'mdi-account-plus'},
        {title: 'Planning', icon: 'mdi-timeline-text'},
        {title: 'À propos', icon: 'mdi-help-box'},
      ],
      selectedNavItem: [],
      right: null,
      app_debug: false,
    }
  }
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