import { defineStore } from 'pinia'

export const useEventStore = defineStore('event', {
  state: () => ({
    id: 0,
    name: 'Robinson 2019',
    start: '2019-06-07',
    end: '2019-06-09',
    theme: 'cyan'
  }),
  getters: {
  },
  actions: {
  },
})