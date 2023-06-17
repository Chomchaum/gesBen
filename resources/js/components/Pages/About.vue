<template>
  <v-container>
    <v-card color="#333" class="py-2">
      <v-card
        v-for="personne in staff"
        :key="personne.nom"
        class="ma-5"
        color="#555"
      >
        <v-card-title>{{ personne.nom }}</v-card-title>
        <v-card-subtitle>{{ personne.role }}</v-card-subtitle>
        <v-card-text>{{ personne.commentaire }}</v-card-text>
      </v-card>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "About",

  data: () => ({
    staff: [
      {
        nom: 'Chomchaum',
        role: 'Développeur du site',
        commentaire: "J'aime bien quand les choses marchent. Du coup j'essaye de faire des trucs efficaces pour remplacer des outils vieillissants"
      },
      {
        nom: 'Ralsifal',
        role: 'Conceptrice',
        commentaire: "Lorem ipsum"
      },
      {
        nom: 'Arkadynn',
        role: 'Mentor',
        commentaire: "Tant pis pour mes royalties"
      },
    ],
  })
}
</script>

<style scoped>

</style>