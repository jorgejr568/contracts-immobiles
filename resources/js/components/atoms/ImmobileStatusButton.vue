<template>
    <v-btn :color="immobile.status.color" x-small v-on="on">
        {{ immobile.status.text }}
    </v-btn>
</template>

<script>
    export default {
        name: 'AtomsImmobileStatusButton',
        props: {
            immobile: {
                type: Object,
                required: true,
            },
            on: {},
        },
    }
</script>

<style scoped></style>
