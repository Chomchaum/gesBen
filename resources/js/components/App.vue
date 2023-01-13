<template>
  <div class="myapp">
    <nav-drawer :nav-items="navItems"></nav-drawer>

    <v-app-bar app clipped-left>
      <h1>Mes Supers Bénévoles</h1>
    </v-app-bar>

    <v-main>
      <debug :is_debug="app_debug"></debug>

      <ben-reg-form></ben-reg-form>

    </v-main>

    <v-footer app>
      <v-spacer></v-spacer>
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
import BenRegForm from "./BenevReg/BenRegForm.vue";

export default {
  name: "App",
  components: {
    BenRegForm,
    NavDrawer,
    Debug,
  },
  computed: {
    app_debug() {
      return process.env.APP_DEBUG;
    }
  },
  data() {
    return {
      navItems: [
        {title: 'Dashboard', icon: 'mdi-view-dashboard'},
        {title: 'BenevReg', icon: 'mdi-account-plus'},
        {title: 'Planning', icon: 'mdi-timeline-text'},
        {title: 'À propos', icon: 'mdi-help-box'},
      ],
      selectedNavItem: [],
      right: null,
    }
  }
}
</script>

<style>
html {
  overflow-y: auto;
}

.myapp {
  width: 90%;
  align-self: center;
}

.v-icon {
  bottom: 1px;
}
</style>