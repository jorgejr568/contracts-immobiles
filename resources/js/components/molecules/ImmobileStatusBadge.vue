<template>
    <div v-if="immobile.contract">
        <v-menu
            v-model="menu"
            :close-on-content-click="false"
            :nudge-width="200"
            offset-x
            left
        >
            <template v-slot:activator="{ on, attrs }">
                <atoms-immobile-status-button :immobile="immobile" :on="on" />
            </template>

            <v-card>
                <v-list>
                    <v-list-item>
                        <v-list-item-avatar>
                            <atoms-initials-avatar
                                :name="contract.receiver_name"
                                color="grey darken-1"
                                class="white--text"
                            />
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title>
                                {{ contract.receiver_name }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{ contract.receiver_email }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <v-divider></v-divider>

                <v-list>
                    <v-list-item>
                        <v-list-item-title>
                            Document type:
                            <strong>{{ contract.document_type }} </strong>
                        </v-list-item-title>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-title>
                            Document number:
                            <strong>
                                {{ document_format(contract.document_number) }}
                            </strong>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-menu>
    </div>
    <div v-else>
        <atoms-immobile-status-badge :immobile="immobile" />
    </div>
</template>

<script>
    import AtomsImmobileStatusBadge from '../atoms/ImmobileStatusBadge'
    import AtomsImmobileStatusButton from '../atoms/ImmobileStatusButton'
    import AtomsInitialsAvatar from '../atoms/InitialsAvatar'
    import { DocumentFilter } from '../../utils/filters/document'
    export default {
        name: 'MoleculesImmobileStatusBadge',
        components: {
            AtomsInitialsAvatar,
            AtomsImmobileStatusButton,
            AtomsImmobileStatusBadge,
        },
        data() {
            return {
                menu: false,
            }
        },
        props: {
            immobile: {
                type: Object,
                required: true,
            },
        },
        computed: {
            contract() {
                const { contract } = this.immobile
                return contract
            },
        },
        methods: {
            document_format(value) {
                return DocumentFilter(this.contract.document_type)(value)
            },
        },
    }
</script>

<style scoped></style>
