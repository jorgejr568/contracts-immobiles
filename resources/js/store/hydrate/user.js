export const USER_ACCESS_TOKEN_LOCALSTORAGE = 'USER_ACCESS_TOKEN'
import store from '../'

const actions = {
    async setTokenFromLocalStorage() {
        const token = JSON.parse(
            localStorage.getItem(USER_ACCESS_TOKEN_LOCALSTORAGE)
        )
        if (token) {
            await store.dispatch('user/setToken', token)

            setTimeout(async () => {
                if (store.getters['user/isLoggedIn'])
                    await store.dispatch('user/refreshToken')
            }, 10000)
        }
    },
}

export default {
    actions,
    namespaced: true,
}
