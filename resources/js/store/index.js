import Vue from 'vue'
import Vuex from 'vuex'
import hydrateUser from './hydrate/user'
import userModule from './modules/user'
import immobilesModule from './modules/immobiles'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        hydrateUser,
        user: userModule,
        immobiles: immobilesModule,
    },
})
