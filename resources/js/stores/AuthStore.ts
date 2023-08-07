import { defineStore } from 'pinia'

type State = {
    isLoggedIn: boolean
    user: {
        id: string | null,
        name: string | null,
        isAdmin: boolean
    }
}

export const useAuthStore = defineStore('auth', {
    state: (): State => ({
        isLoggedIn: false,
        user: {
            id: null,
            name: null,
            isAdmin: false
        }
    }),
    actions: {
        authenticate(id: string, name: string, isAdmin: boolean) {
            this.isLoggedIn = true
            this.user.id = id
            this.user.name = name
            this.user.isAdmin = isAdmin
        },

        unauthenticate() {
            this.isLoggedIn = false
            this.user.id = null
            this.user.name = null
            this.user.isAdmin = false
        },
    },
})
