<template>
  <div class="myapp">
    <v-app-bar app clipped-left flat>
      <v-app-bar-nav-icon @click="drawer = !drawer"/>
      <h2>Mes Supers Bénévoles</h2>
      <v-spacer/>
      <!--    Todo viewAs : v-if admin à intégrer-->
      <v-select v-model="viewAs"
                v-if="false"
                :items="viewAsList"
                label="Voir en tant que"
                :menu-props="{ offsetY: true }"
                dense
                outlined
                style="max-width: 175px; position: relative; top: 1em"
      >
      </v-select>
      <v-menu v-if="authUser !== null" offset-y>
        <template v-slot:activator="{on, attrs}">
          <v-list-item-avatar color="indigo" class="my-3" size="40" v-on="on" v-bind="attrs">
          <span class="white--text text-h6 text-">{{
              authUser.firstname.charAt(0) + authUser.lastname.charAt(0)
            }}</span>
          </v-list-item-avatar>
        </template>
        <v-list dense>
          <v-list-item @click="curComponent = 0">
            <v-list-item-title class="font-weight-bold">
              Mon compte
            </v-list-item-title>
          </v-list-item>
          <v-list-item @click="logOut">
            <v-list-item-title class="error--text font-weight-bold">
              Déconnexion
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <div v-if="authUser === null">
        <v-btn class="d-block mx-auto" small outlined @click="showSignIn">Connexion</v-btn>
        <v-btn class="d-block mt-1" x-small text color="primary" @click="showSignUp">Créer mon compte</v-btn>
      </div>
    </v-app-bar>

    <nav-drawer :nav-items="visibleNavItems" :drawer="drawer" @changePage="changePage"/>

    <v-main>
      <debug :is_debug="app_debug"/>
      <profil v-if="curComponent === 0"/>
      <home v-if="curComponent === 1" :user="authUser"/>
      <about v-if="curComponent === 5"/>
    </v-main>
    <v-dialog
      v-model="dialog.isActive"
      :max-width="dialog.width"
      @click:outside="dialog.isActive = false"
    >
      <sign-in v-if="dialog.type === 'signIn'" @closeDialog="dialog.isActive = false"/>
      <sign-up v-if="dialog.type === 'signUp'" @closeDialog="dialog.isActive = false"/>
    </v-dialog>

    <v-footer app>
      <v-select
        v-model="curLang"
        :items="languages"
        item-value="shortname"
        :menu-props="{ top: true, offsetY: true, closeOnContentClick: true }"
        dense
        outlined
        prepend-icon="mdi-translate"
        hide-details
        style="min-width: 180px; max-width: 180px; margin-inline: 23px;"
      >
      </v-select>
      <v-spacer/>
      <h4 class="ml-10 warning--text text-center text--darken-2">
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
import api from "../../api";
import NavDrawer from "../NavDrawer.vue";

import Debug from "../Debug.vue";

import Profil from "./Profil.vue";
import Home from "./Home.vue";
import Dashboard from "./Dashboard.vue";
import Planning from "./Planning.vue";
import About from "./About.vue";
import moment from "moment";
import SignIn from "../Dialogs/SignIn.vue";
import SignUp from "../Dialogs/SignUp.vue";

import {useUserStore} from "../../stores/User";

export default {
  name: "App",
  components: {
    SignIn,
    SignUp,
    NavDrawer,
    Debug,
    Profil,
    Home,
    Dashboard,
    Planning,
    About,
  },

  setup() {
    const userStore = useUserStore();
    return {userStore}
  },

  data: _ => ({
    navItems: [
      {id: 0, title: 'Profil', icon: 'mdi-account', required: 'loggedin', show: true},
      {id: 1, title: 'Accueil', icon: 'mdi-home', required: '', show: true},
      {id: 2, title: 'Dashboard', icon: 'mdi-view-dashboard', required: 'loggedin', show: true},
      {id: 3, title: 'Participer', icon: 'mdi-account-plus', required: 'eventpicked', show: true},
      {id: 4, title: 'Planning', icon: 'mdi-timeline-text', required: 'loggedin-eventpicked', show: true},
      {id: 5, title: 'À propos', icon: 'mdi-help-circle', required: '', show: true},
    ],
    languages: [
      {shortname: 'fr', text: 'français', region: 'France'},
      {shortname: 'br', text: 'brezhoneg', region: 'Breizh'},
      {shortname: 'en', text: 'english', region: 'United-Kingdom'}
    ],
    right: null,
    dialog: {
      width: null,
      isActive: false,
      type: null,
    },
    app_debug: false,
    curComponent: 1,
    curYear: moment().year() > 2023 ? '2023 - ' + moment().year() : '2023',
    curLang: 'fr',
    activeEventId: null,
    viewAsList: ['Administrateur', 'Bénévole', 'Visiteur'],
    viewAs: 'Administrateur',
    drawer: true,
  }),

  computed: {
    authUser() {
      return this.userStore.auth_user
    },

    visibleNavItems() {
      return this.navItems.map((elem) => {
        let showElem = true;
        if (elem.required.search('loggedin') >= 0 && this.authUser === null
          || elem.required.search('loggedout') >= 0 && this.authUser !== null
          || elem.required.search('eventpicked') >= 0 && this.activeEventId === null)
          showElem = false;
        elem.show = showElem;
        return elem;
      })
    },
  },

  methods: {
    log(val) {
      console.log(val)
    },
    changePage(event) {
      this.curComponent = event;
    },
    showSignIn() {
      this.dialog.width = "20%";
      this.dialog.isActive = true;
      this.dialog.type = 'signIn';
    },
    showSignUp() {
      this.dialog.width = "40%";
      this.dialog.isActive = true;
      this.dialog.type = 'signUp';
    },
    logOut() {
      axios.get('http://localhost:8000/api/logout').then(res => {
        this.userStore.auth_user = null;
        location.reload();
      });
    },
    toggleLog() {
      this.curUser = (this.curUser === 'Me' ? null : 'Me');
    },
  },
}
</script>

<style>
html {
  overflow-y: auto;
}
</style>
