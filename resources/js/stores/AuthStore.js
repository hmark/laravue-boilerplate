import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isLoggedIn: false,
        user: {
            name: null,
            isAdmin: false
        }
    }),
    actions: {
        authenticate(name, isAdmin) {
            this.isLoggedIn = true
            this.user.name = name
            this.user.isAdmin = isAdmin
        },

        unauthenticate() {
            this.isLoggedIn = false
            this.user.name = null
        },
    },
})
