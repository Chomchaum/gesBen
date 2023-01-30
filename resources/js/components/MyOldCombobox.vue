<template>
  <v-combobox
    v-model="model"
    :filter="filter"
    :hide-no-data="!search"
    :items="items"
    :search-input.sync="search"
    :disabled="disabled"
    cache-items
    hide-selected
    hide-no-data
    hide-details
    multiple

    label="Ajoutez vos anciens postes"
    class="ml-4"
    flat
    small-chips
    solo-inverted
  >
    <template v-slot:no-data>
      <v-list-item>
        <span class="subheading">Création</span>
        <v-chip
          :color="`${colors[nonce - 1]} lighten-2`"
          label
          small
        >
          {{ search }}
        </v-chip>
      </v-list-item>
    </template>
    <template v-slot:selection="{ attrs, item, parent, selected }">
      <v-chip
        v-if="item === Object(item)"
        v-bind="attrs"
        :color="`${item.color} ligthen-1`"
        :input-value="selected"
        label
        small
      >
          <span class="pr-2">
            {{ item.text }}
          </span>
        <v-icon
          small
          @click="parent.selectItem(item)"
        >
          $delete
        </v-icon>
      </v-chip>
    </template>
    <template v-slot:item="{ index, item }">
      <v-text-field
        v-if="editing === item"
        v-model="editing.text"
        autofocus
        flat
        background-color="transparent"
        hide-details
        solo
        @keyup.enter="edit(index, item)"
      ></v-text-field>
      <v-chip
        v-else
        :color="`${item.color} lighten-1`"
        dark
        label
        small
      >
        {{ item.text }}
      </v-chip>
    </template>
  </v-combobox>
</template>

<script>
export default {
  name: "MyOldCombobox",

  props: [
    'items',
    'model',
    'disabled',
  ],

  data: () => ({
    activator: null,
    attach: null,
    colors: ['indigo', 'cyan', 'teal', 'orange', 'blue', 'red', 'green', 'purple'],
    nonce: 1,
    menu: false,
    x: 0,
    y: 0,
    search: null,
  }),

  watch: {
    model(val, prev) {
      if (val.length === prev.length) return

      this.model = val.map(v => {
        if (typeof v === 'string') {
          v = {
            text: v,
            color: this.colors[(this.nonce - 1)%this.colors.length],
          }

          this.items.push(v)

          this.nonce++
        }

        return v
      })
    },
  },

  methods: {

    filter(item, queryText, itemText) {
      if (item.header) return false

      const hasValue = val => val != null ? val : ''

      const text = hasValue(itemText)
      const query = hasValue(queryText)

      return text.toString()
        .toLowerCase()
        .indexOf(query.toString().toLowerCase()) > -1
    },
  }
}
</script>

<style scoped>

</style>