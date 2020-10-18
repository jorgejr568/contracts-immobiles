<template>
    <v-navigation-drawer
        permanent
        fixed
        :mini-variant="breakpoint"
        :expand-on-hover="breakpoint"
    >
        <v-list>
            <v-list-item class="px-2 d-flex justify-center">
                <v-list-item-avatar
                    color="primary"
                    class="white--text font-weight-bold"
                    size="44"
                >
                    {{ userInitials }}
                </v-list-item-avatar>
            </v-list-item>

            <v-list-item inactive>
                <v-list-item-content>
                    <v-list-item-title class="title text-center">
                        {{ user.name }}
                    </v-list-item-title>
                    <v-list-item-subtitle class="text-center">
                        {{ user.email }}
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>

        <v-divider />

        <v-list nav dense>
            <v-list-item link :to="{ name: 'dashboard.home' }" exact>
                <v-list-item-icon>
                    <v-icon>mdi-home</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Home</v-list-item-title>
            </v-list-item>
            <v-list-item link :to="{ name: 'immobile.index' }">
                <v-list-item-icon>
                    <v-icon>mdi-office-building</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Properties</v-list-item-title>
            </v-list-item>
        </v-list>

        <template v-slot:append>
            <v-list nav dense>
                <v-list-item link @click="logout" :disabled="loading">
                    <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
            </v-list>
        </template>
    </v-navigation-drawer>
</template>

<script>
    import { mapGetters } from 'vuex'
    import { ApiClient } from '../../utils/consumer/api'

    export default {
        name: 'OrganismsNavbar',
        props: {
            breakpoint: {
                required: true,
            },
        },
        data() {
            return {
                loading: false,
            }
        },
        computed: {
            ...mapGetters({
                user: 'user/getUser',
            }),
            userInitials() {
                const { name } = this.user
                if (!name) return ''

                const singleNames = name.split(' ')
                return singleNames
                    .map((singleName) => singleName.charAt(0).toUpperCase())
                    .slice(0, 2)
                    .join('')
            },
        },
        methods: {
            logout() {
                if (this.loading) return
                this.loading = true
                ApiClient()
                    .post('/auth/logout')
                    .finally(async () => {
                        await this.$store.dispatch('user/setToken', null)
                        await this.$router.push({ name: 'auth.login' })
                        this.loading = false
                    })
            },
        },
    }
</script>

<style scoped></style>
