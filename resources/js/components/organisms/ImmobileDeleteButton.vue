<template>
    <div>
        <v-btn x-small color="error" @click="confirm">
            <v-icon small>mdi-trash-can</v-icon>
        </v-btn>
        <molecules-confirmation-dialog ref="dialog" />
    </div>
</template>

<script>
    import MoleculesConfirmationDialog from '../molecules/ConfirmationDialog'
    import { ApiClient } from '../../utils/consumer/api'

    export default {
        name: 'OrganismsImmobileDeleteButton',
        components: { MoleculesConfirmationDialog },
        props: {
            immobile: {
                type: Object,
                required: true,
            },
        },
        methods: {
            confirm() {
                this.$refs.dialog
                    .open(
                        `Delete - ${this.immobile.uuid}`,
                        'Are you sure about deleting this immobile?',
                        { color: 'error' }
                    )
                    .then((confirm) => {
                        if (confirm) return this.delete()
                    })
            },
            async delete() {
                await ApiClient().delete(`/immobile/${this.immobile.uuid}`)
                await this.$store.dispatch('immobiles/paginate')
            },
        },
    }
</script>

<style scoped></style>
