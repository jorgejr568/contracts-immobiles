<template>
    <v-chip label :color="immobile.status.color" x-small>
        {{ immobile.status.text }}
    </v-chip>
</template>

<script>
    export default {
        name: 'AtomsImmobileStatusBadge',
        props: {
            immobile: {
                type: Object,
                required: true,
            },
        },
    }
</script>

<style scoped></style>
