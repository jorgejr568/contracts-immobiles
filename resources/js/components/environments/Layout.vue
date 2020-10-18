<template>
    <v-main>
        <organisms-navbar :breakpoint="breakpoint" />

        <v-container>
            <v-row>
                <v-col :offset="breakpoint ? 1 : 3" :cols="breakpoint ? 11 : 9">
                    <slot />
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
    import OrganismsNavbar from '../organisms/Navbar'

    export default {
        name: 'EnvironmentsLayout',
        components: { OrganismsNavbar },
        computed: {
            breakpoint() {
                return this.$vuetify.breakpoint.mdAndDown
            },
        },
    }
</script>

<style scoped></style>
