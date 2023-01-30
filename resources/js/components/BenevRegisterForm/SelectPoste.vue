<template>
  <v-select
    filled
    single-line
    clearable
    :items="listePostes"
    :label="'Choix n°'+numChoix"
    :item-disabled="disablePoste"
    v-on:input="$emit('input', $event)"
    v-model="selectValue"
  >
    <template v-slot:item="{item, attrs, on }">
      <v-row><span class="ml-2">{{ item.text }}</span>
        <v-spacer></v-spacer>
        <!--        <span v-html="progressText(item)"/>-->
        <div class="mr-2" style="width: 40%;" v-if="showProgress">
          <v-progress-linear :value="progress(item)" :color="progressColor(item)" height="24">
            <strong class="caption" v-html="progressText(item)"></strong>
          </v-progress-linear>
        </div>
      </v-row>
    </template>
  </v-select>
</template>

<script>
export default {
  name: "SelectPoste",

  props: [
    'numChoix',
    'value',
    'listePostes',
    'otherChoices',
  ],

  data: () => ({
    selectValue: null,
    maxFillPercent: 200,
    showProgress: true,
  }),

  computed: {},

  methods: {
    /**
     * Calcule le taux de candidature sur le poste (ratio)
     * Compare le ratio au remplissage maximal souhaité (maxFillPercent) et renvoie le résultat (0-100)
     *
     * @param item
     * @returns {number}
     */
    progress(item) {
      const ratio = item.candidats / item.teamSize * 100;

      return Math.floor(ratio * (100 / this.maxFillPercent))
    },

    /**
     * Définit la couleur de la progress-bar
     *
     * @param item
     * @returns {string}
     */
    progressColor(item) {
      const progress = this.progress(item);

      if (progress <= 30) {
        return "warning"
      } else if (progress <= 75) {
        return "grey"
      } else if (progress < 100) {
        return "success"
      } else {
        return "blue-grey"
      }
    },

    /**
     * Définit le texte à afficher dans la progress-bar
     * @param item
     * @returns {string}
     */
    progressText(item) {
      const progress = this.progress(item);

      if (progress <= 30) {
        return "On manque de volontaires"
      } else if (progress <= 75) {
        return ""
      } else if (progress < 100) {
        return "Merci pour votre engouement"
      } else {
        return "Ce poste est complet"
      }
    },

    /**
     * Désactive des options de choix :
     *  - Celles ayant atteint le remplissage maximal souhaité
     *  - Celles déjà choisies par ailleurs
     *
     * @param item
     * @returns {boolean}
     */
    disablePoste(item) {
      if (item === null) {
        return false
      }

      return (this.progress(item) >= 100 || this.otherChoices.includes(item.value));
    }
  }
}
</script>

<style scoped>

</style>