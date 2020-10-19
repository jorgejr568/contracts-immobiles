<template>
    <v-avatar :color="color" class="font-weight-bold" size="44">
        {{ user_initials }}
    </v-avatar>
</template>

<script>
    export default {
        name: 'AtomsInitialsAvatar',
        props: {
            name: {
                type: String,
                required: true,
            },
            color: {
                type: String,
                required: false,
                default: 'primary',
            },
        },
        computed: {
            user_initials() {
                const { name } = this
                if (!name) return ''

                const singleNames = name.split(' ')
                return singleNames
                    .map((singleName) => singleName.charAt(0).toUpperCase())
                    .slice(0, 2)
                    .join('')
            },
        },
    }
</script>

<style scoped></style>
