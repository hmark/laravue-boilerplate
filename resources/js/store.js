import { createStore } from 'vuex'

export default createStore({
    state: {
        isLoggedIn: !!localStorage.getItem('user.name'),
        user: {
            name: localStorage.getItem('user.name')
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
            localStorage.setItem('user.name', name);
            state.isLoggedIn = true;
            state.user.name = name;
        },

        unauthenticate(state) {
            localStorage.removeItem('user.name');
            state.isLoggedIn = false;
            state.user.name = null;
        },
    },
    actions: {
        authenticate: ({ commit }, { name }) => commit('authenticate', { name }),
        unauthenticate: ({ commit }) => commit('unauthenticate'),
    }
});
