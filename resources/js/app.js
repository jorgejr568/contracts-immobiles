import Vue from 'vue'
import router from './routes'
import vuetify from './plugins/vuetify'
import store from './store'
import App from './App'

require('./bootstrap')

new Vue({
    router,
    store,
    vuetify,
    render: (h) => h(App),
}).$mount('#app')
