<template>
    <environments-layout>
        <v-container>
            <atoms-page-title>Register contract</atoms-page-title>

            <organisms-contract-form />
        </v-container>
    </environments-layout>
</template>

<script>
    import EnvironmentsLayout from '../../environments/Layout'
    import AtomsPageTitle from '../../atoms/PageTitle'
    import OrganismsImmobileForm from '../../organisms/ImmobileForm'
    import OrganismsContractForm from '../../organisms/ContractForm'
    export default {
        name: 'PagesContractNew',
        components: {
            OrganismsContractForm,
            OrganismsImmobileForm,
            AtomsPageTitle,
            EnvironmentsLayout,
        },
    }
</script>

<style scoped></style>
