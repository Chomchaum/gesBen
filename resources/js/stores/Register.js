import { defineStore } from 'pinia'

export const useRegisterStore = defineStore('register', {
  state: () => ({
    lastname: undefined,
    firstname: undefined,
    phone: undefined,
    email: undefined,
    birthdate: undefined,
    isUnderage: undefined,
    size: undefined,
    exPostes: [],
    choixPostes: [],
    comment: undefined,
    plagesDispo: [],
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