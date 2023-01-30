import { defineStore } from 'pinia'

export const useRegisterStore = defineStore('register', {
  state: () => ({
    name: null,
    firstname: null,
    phone: null,
    email: null,
    birthdate: null,
    taille: null,
  }),
  getters: {
    // doubleCount: (state) => state.count * 2,
  },
  actions: {
/*    increment() {
      this.count++
    },*/
  },
})