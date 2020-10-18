import { ApiClient } from '../../utils/consumer/api'
import { ApiResourceParser } from '../../utils/parsers/api-resource'
import { ApiBodyParser } from '../../utils/parsers/api-body'

const state = () => {
    return {
        list: [],
        pagination: {
            page: 1,
            per_page: 10,
            total: 1,
            sort: [],
        },
    }
}

const getters = {
    getList: ({ list }) => list,
    getPagination: ({ pagination }) => pagination,
}

const mutations = {
    setList(state, { list, page, total, per_page, sort }) {
        state.list = list
        state.pagination = {
            page,
            total,
            per_page,
            sort,
        }
    },
}

const actions = {
    paginate({ commit, state }, { page, perPage, sort: sortBy } = {}) {
        let page_number = page || state.pagination.page
        let per_page = perPage || state.pagination.per_page
        let sort = sortBy || state.pagination.sort

        return ApiClient()
            .get('/immobile', {
                params: {
                    page: page_number,
                    per_page,
                    sort,
                },
            })
            .then((response) => {
                const list = ApiResourceParser(response)
                const { current_page: page, total, per_page } = ApiBodyParser(
                    response
                ).meta

                commit('setList', { list, page, total, per_page, sort })
            })
    },
}

export default {
    state,
    getters,
    mutations,
    actions,
    namespaced: true,
}
