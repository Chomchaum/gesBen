<template>
  <v-container fluid>
    <v-combobox
      class="customedLabel"
      v-model="model"
      :items="items"
      :search-input.sync="search"
      :disabled="disabled"
      filled
      hide-selected
      flat
      :label="label"
      :hint="hint"
      persistent-hint
      multiple
      small-chips
      @input="$emit('input', $event)"
    >
      <template v-slot:no-data>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>
              {{ $t('ancienPosteAjoutTipstart') }}
              <v-chip :color="`${colors[nonce - 1]} lighten-2`"
                      label
                      small>{{ search }}
              </v-chip>
              <span v-html="$t('createOnKbdInputTip', ['<kbd class=\'mb-1\'>', '</kbd>' ])"></span>
            </v-list-item-title>
          </v-list-item-content>
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
      <template v-slot:item="{ item }">
        <v-chip
          :color="`${item.color} lighten-1`"
          dark
          label
          small
        >
          {{ item.text }}
        </v-chip>
      </template>
    </v-combobox>
  </v-container>
</template>

<script>
export default {
  name: "MyCombobox",

  props: [
    'items',
    'disabled',
    'label',
    'hint',
  ],

  data: () => ({
    colors: ['indigo', 'cyan', 'teal', 'orange'],
    nonce: 1,
    menu: false,
    x: 0,
    y: 0,
    search: null,
    model: [],
  }),

  watch: {
    model(val, prev) {
      if (val.length === prev.length) return

      this.model = val.map(v => {
        if (typeof v === 'string') {
          v = {
            text: v,
            color: this.colors[(this.nonce - 1) % this.colors.length],
          }

          this.items.push(v)
          this.model.push(v)

          this.nonce++
        }

        return v
      })

      if (val.length > 3) {
        this.$nextTick(() => this.model.pop())
      }
    },
  },

  methods: {
  }
}
</script>

<style scoped>

</style>