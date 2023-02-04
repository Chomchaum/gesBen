import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: undefined,
  }),
  getters: {
    id: (state) => { if (state.user === undefined || state.user === null) return null; else state.user.id; },
    // doubleCount: (state) => state.count * 2,
  },
  actions: {
    /*    increment() {
          this.count++
        },*/
  },
})