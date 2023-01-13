<template>
  <v-card
    class="mb-4 pa-4"
  >
    <form>
      <v-text-field
        v-model="form.name"
        :error-messages="nameErrors"
        label="Nom"
        required
        @input="v$.form.name.$touch()"
        @blur="v$.form.name.$touch()"
      ></v-text-field>
      <v-text-field
        v-model="form.firstname"
        :error-messages="firstnameErrors"
        label="Prénom"
        required
        @input="v$.form.firstname.$touch()"
        @blur="v$.form.firstname.$touch()"
      ></v-text-field>
      <v-text-field
        v-model="form.phone"
        :error-messages="phoneErrors"
        label="Téléphone"
        required
        @input="v$.form.phone.$touch()"
        @blur="v$.form.phone.$touch()"
      ></v-text-field>
      <v-text-field
        v-model="form.email"
        :error-messages="emailErrors"
        label="E-mail"
        type="email"
        required
        @input="v$.form.email.$touch()"
        @blur="v$.form.email.$touch()"
      ></v-text-field>
      <v-select
        v-model="form.select"
        :items="form.items"
        :error-messages="selectErrors"
        label="Item"
        required
        @change="v$.form.select.$touch()"
        @blur="v$.form.select.$touch()"
      ></v-select>
      <v-checkbox
        v-model="form.checkbox"
        :error-messages="checkboxErrors"
        label="Do you agree?"
        required
        @change="v$.form.checkbox.$touch()"
        @blur="v$.form.checkbox.$touch()"
      ></v-checkbox>
    </form>
  </v-card>
</template>

<script>
import {useVuelidate} from '@vuelidate/core'
import {email, minLength, required} from '@vuelidate/validators'

export default {
  name: "InfosPerso",

  setup() {
    return {
      v$: useVuelidate()
    }
  },

  validations() {
    return {
      form: {
        name: {required, minLength: minLength(3)},
        firstname: {required, minLength: minLength(3)},
        phone: {required},
        email: {required, email},
        select: {required},
        checkbox: {
          checked(val) {
            return val
          },
        }
      }
    }
  },

  data: () => ({
    form: {
      name: null,
      firstname: null,
      phone: null,
      email: null,
      select: null,
      items: [
        'Item 1',
        'Item 2',
        'Item 3',
        'Item 4',
      ],
      checkbox: false,
    }
  }),

  computed: {
    checkboxErrors() {
      const errors = []
      if (!this.v$.form.checkbox.$dirty) return errors
      !this.v$.form.checkbox.checked && errors.push('You must agree to continue!')
      return errors
    },
    selectErrors() {
      const errors = []
      if (!this.v$.form.select.$dirty) return errors
      !this.v$.form.select.required && errors.push('Item is required')
      return errors
    },
    nameErrors() {
      const errors = []
      if (!this.v$.form.name.$dirty) return errors
      !this.v$.form.name.minLength && errors.push('Name must be at least 3 characters long')
      !this.v$.form.name.required && errors.push('Name is required.')
      return errors
    },
    firstnameErrors() {
      const errors = []
      if (!this.v$.form.name.$dirty) return errors
      !this.v$.form.name.minLength && errors.push('Name must be at least 3 characters long')
      !this.v$.form.name.required && errors.push('Name is required.')
      return errors
    },
    emailErrors() {
      const errors = []
      if (!this.v$.form.email.$dirty) return errors
      !this.v$.form.email.email && errors.push('Must be valid e-mail')
      !this.v$.form.email.required && errors.push('E-mail is required')
      return errors
    },
    phoneErrors() {
      const errors = []
      if (!this.v$.form.email.$dirty) return errors
      !this.v$.form.email.email && errors.push('Must be valid e-mail')
      !this.v$.form.email.required && errors.push('E-mail is required')
      return errors
    },
  },

  methods: {
    submit() {
      this.v$.form.$touch()
    },
    clear() {
      this.v$.form.$reset()
      this.form.name = null
      this.form.firstname = null
      this.form.phone = null
      this.form.email = null
      this.form.select = null
      this.form.checkbox = false
    },
  },
}
</script>

<style scoped>

</style>