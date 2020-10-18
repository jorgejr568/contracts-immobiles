<template>
    <environments-layout>
        <v-container>
            <atoms-page-title>Register immobile</atoms-page-title>

            <organisms-immobile-form />
        </v-container>
    </environments-layout>
</template>

<script>
    import EnvironmentsLayout from '../../environments/Layout'
    import AtomsPageTitle from '../../atoms/PageTitle'
    import OrganismsImmobileForm from '../../organisms/ImmobileForm'
    export default {
        name: 'PagesImmobileNew',
        components: {
            OrganismsImmobileForm,
            AtomsPageTitle,
            EnvironmentsLayout,
        },
    }
</script>

<style scoped></style>
