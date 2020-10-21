import { ApiClient } from '../../utils/consumer/api'
import { ApiBodyParser } from '../../utils/parsers/api-body'
import { ApiResourceParser } from '../../utils/parsers/api-resource'
import { USER_ACCESS_TOKEN_LOCALSTORAGE } from '../hydrate/user'

const REFRESH_TOKEN_INTERVAL_MS = 10 * 60 * 1000 // 10 minutes

const state = () => {
    return {
        token: null,
        user: {},
    }
}

const getters = {
    getToken: ({ token }) => token,
    getAuthorization: ({ token }) =>
        token ? `${token.token_type} ${token.access_token}` : null,
    isLoggedIn: ({ user }) => !!user?.id,
    getUser: ({ user }) => user,
}

const mutations = {
    setToken(state, token) {
        localStorage.setItem(
            USER_ACCESS_TOKEN_LOCALSTORAGE,
            JSON.stringify(token)
        )
        state.token = token
    },
    setUser(state, user) {
        state.user = user
    },
}

const actions = {
    async setToken({ commit, state, dispatch }, token) {
        commit('setToken', token)
        await dispatch('userFromToken')
        setTimeout(async () => {
            await dispatch('refreshToken')
        }, REFRESH_TOKEN_INTERVAL_MS)
    },
    refreshToken({ commit, dispatch }) {
        ApiClient()
            .post('/auth/refresh')
            .then(async (response) => {
                const token = ApiBodyParser(response)
                await dispatch('setToken', token)
            })
            .catch(() => commit('setUser', {}))
    },
    userFromToken({ commit }) {
        return ApiClient()
            .get('/auth')
            .then(async (response) => {
                const user = ApiResourceParser(response)
                commit('setUser', user)
            })
            .catch(() => commit('setUser', {}))
    },
}

export default {
    state,
    getters,
    mutations,
    actions,
    namespaced: true,
}
