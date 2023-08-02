import { defineStore } from 'pinia'

type State = {
    isLoggedIn: boolean
    user: {
        name: string | null,
        isAdmin: boolean
    }
}

export const useAuthStore = defineStore('auth', {
    state: (): State => ({
        isLoggedIn: false,
        user: {
            name: null,
            isAdmin: false
        }
    }),
    actions: {
        authenticate(name: string, isAdmin: boolean) {
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
