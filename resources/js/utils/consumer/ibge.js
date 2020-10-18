import axios from 'axios'

const client = axios.create({
    baseURL: 'https://servicodados.ibge.gov.br/api/v1/localidades',
})

export default class IBGEClient {
    static states() {
        return client.get('/estados')
    }
    static state(UF) {
        return client.get(`/estados/${UF.toUpperCase()}`)
    }
    static cities(UF) {
        return client.get(`/estados/${UF.toUpperCase()}/distritos`)
    }
}
