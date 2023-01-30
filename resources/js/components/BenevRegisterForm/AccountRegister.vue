<template>
  <v-card flat class="pa-4">
    <v-card-text>
      <v-row>
        <!--v-text-field>
          readonly
          v-model="email"
        </v-text-field-->
        {{email}}
      </v-row>
      <v-row>
        <v-col cols="12" sm="6">

        </v-col>
        <v-col cols="12" sm="6">

        </v-col>
      </v-row>
    </v-card-text>

    <v-card-actions>
      <v-btn
        color="primary"
        @click="$emit('continue')"
      >
        Continue
      </v-btn>
      <v-btn text>
        Cancel
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import {useRegisterStore} from "../../stores/Register";

export default {
  name: "AccountRegister",

  data: () => ({
    email: null,
  }),

  methods: {
    init () {
      const register = useRegisterStore();
      this.email = register.email;
      window.stores = { register };
    },
  },
}
</script>

<style scoped>

</style>