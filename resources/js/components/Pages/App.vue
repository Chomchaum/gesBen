<template>
  <div class="myapp">
    <nav-drawer :nav-items="visibleNavItems" :cur-page="curPage" :user="curUser" v-on:logOut="logOut"/>

    <v-app-bar app clipped-left>
      <v-img alt="Site en accès anticipé" src="assets/beta_icon.png" max-width="50px"
             style="position: absolute; top: 0; left: 0"/>
      <h1>Mes Supers Bénévoles</h1>
      <template v-slot:extension>
        <h2 class="info--text">Aucun événement sélectionné</h2>
        <v-spacer/>
        <!--    Todo v-if à mettre si admin-->
        <v-select
          v-if="true"
          v-model="viewAs"
          :items="viewAsList"
          label="Voir en tant que"
          dense
          outlined
          style="max-width: 235px"
        >
        </v-select>

        <v-btn icon class="mt-n6 mx-2">
          <v-icon large>mdi-theme-light-dark</v-icon>
        </v-btn>

        <v-menu offset-y>
          <template v-slot:activator="{on, attrs}">
            <v-btn icon class="mt-n6">
              <v-icon large v-on="on" v-bind="attrs">mdi-translate</v-icon>
            </v-btn>
          </template>
          <v-list dense>
            <v-list-item-group
              v-model="curLang"
              color="primary"
            >
              <v-list-item
                v-for="(language) in languages"
                :key="language.shortname"
              >
                <v-list-item-icon v-if="false">
                  <v-icon v-text="language.flag"/>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title v-text="language.name"/>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-menu>
      </template>
    </v-app-bar>

    <v-main>

      <debug :is_debug="app_debug"/>
      <!--      <home/>-->
      <v-container>
        <v-row dense>
        </v-row>
      </v-container>
      <!--      <about/>-->
    </v-main>

    <v-footer app>
      <v-spacer/>
      <h4 class="ml-10 warning--text text--darken-2">
        Site en accès anticipé, des fonctionnalités sont susceptibles de dysfonctionner
      </h4>
      <v-spacer/>
      <!--suppress AllyHtmlVueInspection -->
      <h5>
        <v-icon small>mdi-copyright</v-icon>
        {{ curYear }}
        by
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
import moment from "moment";

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
      {id: 0, title: 'Accueil', icon: 'mdi-home', required: ''},
      {id: 1, title: 'Dashboard', icon: 'mdi-view-dashboard', required: 'loggedin'},
      {id: 2, title: 'Créer un compte', icon: 'mdi-account-plus', required: 'loggedout'},
      {id: 3, title: 'Participer', icon: 'mdi-account-plus', required: 'eventpicked'},
      {id: 4, title: 'Planning', icon: 'mdi-timeline-text', required: 'loggedin-eventpicked'},
      {id: 5, title: 'À propos', icon: 'mdi-help-box', required: ''},
    ],
    languages: [
      {
        shortname: 'fr',
        name: 'français',
        region: 'France',
        flag: 'https://upload.wikimedia.org/wikipedia/commons/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg'
      },
      {
        shortname: 'br',
        name: 'breton',
        region: null,
        flag: 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Flag_of_Brittany_%28Gwenn_ha_du%29.svg/320px-Flag_of_Brittany_%28Gwenn_ha_du%29.svg.png'
      },
      {
        shortname: 'en',
        name: 'anglais',
        region: 'United-Kingdom',
        flag: 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Flag_of_Brittany_%28Gwenn_ha_du%29.svg/320px-Flag_of_Brittany_%28Gwenn_ha_du%29.svg.png'
      }
    ],
    right: null,
    app_debug: false,
    curPage: 0,
    curYear: moment().year() > 2023 ? '2023 - ' + moment().year() : '2023',
    curUser: 'Me',
    curLang: 'fr',
    isLoggedIn: false,
    activeEventId: null,
    viewAsList: ['Administrateur', 'Bénévole sans compte', 'Bénévole avec compte', 'Visiteur'],
    viewAs: 'Administrateur',
  }),

  computed: {
    visibleNavItems() {
      return this.navItems.filter((elem) => {
        let showElem = true;
        if (elem.required.search('loggedin') >= 0 && !this.isLoggedIn
          || elem.required.search('loggedout') >= 0 && this.isLoggedIn
          || elem.required.search('eventpicked') >= 0 && this.activeEventId === null)
          showElem = false
        return showElem
      });
    },
  },

  methods: {
    log(val) {
      console.log(val)
    },
    logOut() {
      this.curUser = null
    }
  },
}
</script>

<style>
html {
  overflow-y: auto;
}
</style>
