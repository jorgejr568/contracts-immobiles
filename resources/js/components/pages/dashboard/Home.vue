<template>
    <environments-layout>
        <v-container>
            <atoms-page-title>Welcome, {{ user.name }}!</atoms-page-title>
        </v-container>
    </environments-layout>
</template>

<script>
    import { mapGetters } from 'vuex'
    import EnvironmentsLayout from '../../environments/Layout'
    import AtomsPageTitle from '../../atoms/PageTitle'

    export default {
        name: 'PagesDashboardHome',
        components: {
            AtomsPageTitle,
            EnvironmentsLayout,
        },
        computed: {
            ...mapGetters({
                user: 'user/getUser',
            }),
        },
    }
</script>

<style scoped></style>
