import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors'

Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: colors.deepPurple.lighten1,
                secondary: colors.orange.lighten2,
                accent: colors.indigo.darken2,
                error: colors.red.darken3,
                success: colors.deepPurple.lighten1, //colors.green.darken1,
            },
        },
    },
})
