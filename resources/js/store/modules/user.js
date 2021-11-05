import api from '../../services/api'
import router from '../../router'

const user = {
    namespaced: true,
    state: {
        user: null,
    },
    getters: {
        user(state) {
            return state.user
        },
        loggedIn(state) {
            return !!state.user
        }
    },
    mutations: {
        createSession(state, user) {
            state.user = user
        },
        destroySession(state) {
            state.user = null
        }
    },
    actions: {
        login({commit}, payload) {
            return api.login(payload)
                .then(response => commit('createSession', response.data.name))
        },
        logout({commit}) {
            return api.logout()
                .then(() => {
                    commit('destroySession')
                })
                .finally(() => {
                    router.push({name: 'homeIndex'})
                })
        }
    }
}

export default user
