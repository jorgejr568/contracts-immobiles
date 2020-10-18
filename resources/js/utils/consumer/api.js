import store from '../../store'

import axios from 'axios'

export const ApiClient = () =>
    axios.create({
        baseURL: process.env.MIX_API_URL,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            Authorization: store.getters['user/getAuthorization'],
        },
    })
