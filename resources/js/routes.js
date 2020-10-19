import Vue from 'vue'
import VueRouter from 'vue-router'
import PagesAuthLogin from './components/pages/auth/Login'
import PagesDashboardHome from './components/pages/dashboard/Home'
import PagesImmobileIndex from './components/pages/immobile/Index'
import PagesImmobileNew from './components/pages/immobile/New'

import store from './store'

Vue.use(VueRouter)

const isLoggedIn = () => store.getters['user/isLoggedIn']

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'auth.login',
            component: PagesAuthLogin,
            meta: {
                valid: () => !isLoggedIn(),
                title: 'Login',
            },
        },
        {
            path: '/dashboard',
            name: 'dashboard.home',
            component: PagesDashboardHome,
            meta: {
                valid: () => isLoggedIn(),
                title: 'Dashboard',
            },
        },
        {
            path: '/immobile',
            name: 'immobile.index',
            component: PagesImmobileIndex,
            meta: {
                valid: () => isLoggedIn(),
                title: 'Registered properties',
            },
        },
        {
            path: '/immobile/new',
            name: 'immobile.new',
            component: PagesImmobileNew,
            meta: {
                valid: () => isLoggedIn(),
                title: 'Register immobile',
            },
        },
        {
            path: '/contracts/new',
            name: 'contracts.new',
            component: PagesImmobileNew,
            meta: {
                valid: () => isLoggedIn(),
                title: 'Register contract',
            },
        },
    ],
})

router.beforeEach(async (to, _, next) => {
    document.title = to.meta.title
    if (!isLoggedIn())
        await store.dispatch('hydrateUser/setTokenFromLocalStorage')

    const valid = to.meta.valid
    if (typeof valid !== 'function' || !(await valid())) {
        const pathToRedirect = isLoggedIn() ? '/dashboard' : ''
        next(pathToRedirect)
    }
    next()
})
export default router
