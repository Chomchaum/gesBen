import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    auth_user: null,
  }),
  getters: {
    id: (state) => { if (state.auth_user === undefined || state.auth_user === null) return null; else state.auth_user.id; },
    // doubleCount: (state) => state.count * 2,
  },
  actions: {
    /*    increment() {
          this.count++
        },*/
  },
  persist: {
    storage: sessionStorage,
  },
})