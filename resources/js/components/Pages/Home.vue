<template>
  <v-container>
    <v-card class="text-center pa-3 mb-3" color="#333">
      <v-container>
        <h5>Bienvenue sur</h5>
        <h1>Mes Supers Bénévoles</h1>
        <h5>Votre outil de recrutement et gestion de bénévoles pour tous vos évènements</h5>
        <h5 class="success--text">Gratuit, moderne, dynamique et hautement personnalisable</h5>
      </v-container>
      <v-row>
        <v-col cols="12" sm="12">
          <v-card hover class="text-center" color="#666">
            <v-card-title style="justify-content: center">
              Organisateur ?
            </v-card-title>
            <v-card-text>
              Cliquez pour créer votre évènement
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" sm="12">
          <v-card hover class="text-center" color="#666">
            <v-card-title style="justify-content: center">
              Volontaire ?
            </v-card-title>
            <v-card-text>
              Parcourez les évènements autour de chez vous :
<!--          Formulaire    -->
              <v-row>
                <v-col cols="12" sm="7">
                  <v-autocomplete
                    v-model="epicentre"
                    :items="listeCommunes"
                    :loading="communeLoading"
                    :search-input.sync="communeSearch"
                    hide-no-data
                    hide-selected
                    item-text="nom"
                    item-value="code"
                    :label="$t('communeDeResidence')"
                    :placeholder="$t('searchCommune')"
                    prepend-icon="mdi-map-search-outline"
                    return-object
                  />
                </v-col>
                <v-col cols="12" sm="5" align-self="center">
                  <label>Distance max</label>
                  <v-slider max="3" :tick-labels="distancesList"/>
                </v-col>
              </v-row>
<!--          Résultats    -->
              <v-row>
                <v-col cols="12" sm="12">
                  <v-simple-table width="100%">
                    <template v-slot:default>
                      <thead>
                      <tr>
                        <th class="text-center">Évènement</th>
                        <th class="text-center">Catégorie</th>
                        <th class="text-center">Lieu</th>
                        <th class="text-center" colspan="2">Dates</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr
                        v-for="event in eventList"
                        :key="event.id"
                      >
                        <td>{{ event.nom }}</td>
                        <td>{{ event.categorie }}</td>
                        <td>{{ event.lieu }}</td>
                        <td>{{ event.debut }}</td>
                        <td>{{ event.fin }}</td>
                      </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "Home",

  data: () => ({
    epicentre: null,
    listeCommunes: [],
    communeLoading: false,
    communeSearch: null,
    distancesList: ['20km', '50km', '100km', '200km', '500km'],

    eventList: [
      {id: 0, nom: 'GBB 2023', categorie: 'Culture', lieu: 'Langonet', debut: '2023-06-30', fin: '2023-07-02'},
      {
        id: 1,
        nom: 'Robinson 2023',
        categorie: 'Arts de la rue',
        lieu: 'Saint-Grégoire',
        debut: '2023-06-10',
        fin: '2023-06-11'
      },
      {
        id: 2,
        nom: 'Vieilles Charrues',
        categorie: 'Musique',
        lieu: 'Carhaix-Plouguer',
        debut: '2023-07-13',
        fin: '2023-07-17'
      },
    ]
  }),

  watch: {
    communeSearch(val) {
      if (val === null) {
        this.listeCommunes = [];
        return;
      }
      if (this.communeLoading) return;

      this.communeLoading = true;

      fetch('https://geo.api.gouv.fr/communes?nom=' + val + '&fields=code,nom,centre&boost=population', {headers: {'Access-Control-Allow-Origin': 'https://geo.api.gouv.fr'}})
        .then(res => res.json())
        .then((res) => {
          console.log(res);
          this.listeCommunes = res;
        })
        .catch(err => {
          console.log(err)
        })
        .finally(() => (this.communeLoading = false))
    },
  },
}
</script>

<style scoped>

</style>