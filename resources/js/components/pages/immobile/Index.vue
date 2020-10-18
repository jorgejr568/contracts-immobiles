<template>
    <environments-layout>
        <v-container>
            <atoms-page-title>
                Registered properties: {{ total }}
            </atoms-page-title>
            <v-row>
                <v-col>
                    <organisms-immobiles-table class="mt-5" />
                </v-col>
            </v-row>
            <v-btn
                color="success"
                link
                fab
                fixed
                bottom
                right
                :to="{ name: 'immobile.new' }"
            >
                <v-icon large>mdi-plus</v-icon>
            </v-btn>
        </v-container>
    </environments-layout>
</template>

<script>
    import EnvironmentsLayout from '../../environments/Layout'
    import AtomsPageTitle from '../../atoms/PageTitle'
    import OrganismsImmobilesTable from '../../organisms/ImmobilesTable'
    export default {
        name: 'PagesImmobileIndex',
        components: {
            OrganismsImmobilesTable,
            AtomsPageTitle,
            EnvironmentsLayout,
        },
        computed: {
            total() {
                return this.$store.getters['immobiles/getPagination'].total
            },
        },
    }
</script>
