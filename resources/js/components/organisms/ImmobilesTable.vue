<template>
    <v-data-table
        :headers="headers"
        :items="immobiles"
        :server-items-length="pagination.total"
        class="elevation-1"
        :options.sync="options"
        @update:page="onPageChange"
        @update:items-per-page="onPerPageChange"
        @update:sort-by="onSortByChange"
        @update:sort-desc="onSortByChange"
        :loading="loading"
        :items-per-page="perPage"
        :footer-props="{ itemsPerPageOptions: [10, 20, 50, 100] }"
    >
        <template v-slot:item.address="{ item: property }">
            {{ property | address_line }}
        </template>

        <template v-slot:item.status="{ item: property }">
            <v-chip label :color="property.status.color" x-small>
                {{ property.status.text }}
            </v-chip>
        </template>

        <template v-slot:item.actions="{ item: property }">
            <organisms-immobile-delete-button :immobile="property" />
        </template>
    </v-data-table>
</template>

<script>
    import { mapGetters } from 'vuex'
    import OrganismsImmobileDeleteButton from './ImmobileDeleteButton'
    export default {
        name: 'OrganismsImmobilesTable',
        components: { OrganismsImmobileDeleteButton },
        filters: {
            address_line: (property) =>
                `${property.street}, ${
                    property.number ? `${property.number},` : ''
                } ${property.city}, ${property.state}`,
        },
        data() {
            return {
                page: 1,
                perPage: 10,
                sort: [],
                loading: false,
                options: {},
            }
        },
        computed: {
            headers: () => [
                {
                    text: 'Owner e-mail',
                    value: 'email',
                },
                {
                    text: 'Address',
                    value: 'address',
                    sortable: false,
                },
                {
                    text: 'Status',
                    value: 'status',
                    sortable: false,
                },
                {
                    text: '',
                    value: 'actions',
                    sortable: false,
                },
            ],
            ...mapGetters({
                pagination: 'immobiles/getPagination',
                immobiles: 'immobiles/getList',
            }),
        },
        methods: {
            async onPageChange(page) {
                this.page = page
                this.loading = true
                await this.$store.dispatch('immobiles/paginate', {
                    page,
                    perPage: this.perPage,
                    sort: this.sort,
                })
                this.loading = false
            },
            async onPerPageChange(perPage) {
                this.perPage = perPage
                await this.onPageChange(this.page)
            },
            async onSortByChange() {
                const { sortBy, sortDesc } = this.options
                const sort = []
                sortBy.forEach((column, index) =>
                    sort.push({
                        column,
                        desc: sortDesc[index],
                    })
                )
                this.sort = sort
                await this.onPageChange(this.page)
            },
        },
        async mounted() {
            await this.onPageChange(this.page)
        },
    }
</script>

<style scoped></style>
