import { createStore } from 'vuex'

export default createStore({
    state: {
        isLoggedIn: null,
        user: {
            name: null
        }
    },
    getters: {
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        user(state) {
            return state.user;
        }
    },
    mutations: {
        authenticate(state, { name }) {
            state.isLoggedIn = true;
            state.user.name = name;
        },

        unauthenticate(state) {
            state.isLoggedIn = false;
            state.user.name = null;
        },
    },
    actions: {
        authenticate: ({ commit }, { name }) => commit('authenticate', { name }),
        unauthenticate: ({ commit }) => commit('unauthenticate'),
    }
});
