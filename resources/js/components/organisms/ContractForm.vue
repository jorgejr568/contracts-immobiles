<template>
    <v-row>
        <v-col md="12" lg="8" sm="12">
            <v-card class="elevation-4 pa-4">
                <v-card-text>
                    <v-form v-model="valid" @submit.prevent="onSubmit">
                        <v-autocomplete
                            :items="immobiles"
                            v-model="selectedImmobile"
                            :loading="loadingImmobile"
                            :search-input.sync="searchImmobile"
                            no-filter
                            hide-no-data
                            item-text="uuid"
                            item-value="id"
                            label="Search for immobile"
                            prepend-inner-icon="mdi-office-building"
                            return-object
                            solo
                            clearable
                            :rules="rules.immobile"
                        >
                            <template v-slot:selection="{ item: property }">
                                {{ property | address_line }}
                            </template>
                            <template v-slot:item="{ item: property }">
                                {{ property | address_line }}
                            </template>
                        </v-autocomplete>

                        <v-text-field
                            type="name"
                            outlined
                            dense
                            label="Contractor name"
                            v-model="form.receiver_name"
                            :rules="rules.receiver_name"
                        />

                        <v-text-field
                            type="email"
                            outlined
                            dense
                            label="Contractor e-mail"
                            v-model="form.receiver_email"
                            :rules="rules.receiver_email"
                        />

                        <v-row>
                            <v-col cols="3">
                                <v-select
                                    v-model="form.document_type"
                                    :items="document_types"
                                    outlined
                                    dense
                                    label="Document type"
                                    :rules="rules.document_type"
                                />
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="form.document_number"
                                    :label="document_label"
                                    v-mask="document_mask"
                                    outlined
                                    dense
                                    :rules="rules.document_number"
                                />
                            </v-col>
                        </v-row>

                        <div class="d-flex justify-space-between">
                            <v-btn
                                link
                                color="error"
                                :to="{ name: 'immobile.index' }"
                            >
                                Back
                            </v-btn>

                            <v-btn
                                type="submit"
                                color="success"
                                :loading="loading"
                                :disabled="!valid"
                            >
                                REGISTER
                            </v-btn>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import { debounce } from 'lodash'
    import { RequiredValidatorRule } from '../../utils/validator/required'
    import { EmailValidatorRule } from '../../utils/validator/email'
    import { ApiClient } from '../../utils/consumer/api'
    import { ApiResourceParser } from '../../utils/parsers/api-resource'
    import { InValidatorRule } from '../../utils/validator/in'
    import {
        CONTRACT_DOCUMENT_TYPE_ENTITY,
        CONTRACT_DOCUMENT_TYPE_PERSON,
        CONTRACT_DOCUMENT_TYPES,
    } from '../../utils/const/contracts-document-type'
    import { SizeValidatorRule } from '../../utils/validator/size'
    import { onlyNumbersParser } from '../../utils/parsers/only-numbers'
    import { DocumentValidatorRule } from '../../utils/validator/document'
    import ContractAddressLineFilter from '../../utils/filters/contract-address-line'

    export default {
        name: 'OrganismsContractForm',
        filters: {
            address_line: (property) => ContractAddressLineFilter(property),
        },
        data() {
            return {
                valid: false,
                loading: false,
                searchImmobile: null,
                selectedImmobile: null,
                loadingImmobile: false,
                form: {
                    receiver_email: null,
                    receiver_name: null,
                    document_type: CONTRACT_DOCUMENT_TYPE_PERSON,
                    document_number: null,
                },
                immobiles: [],
            }
        },
        computed: {
            document_types: () => CONTRACT_DOCUMENT_TYPES,
            document_mask() {
                if (this.form.document_type === CONTRACT_DOCUMENT_TYPE_ENTITY)
                    return `##.###.###/####-##`

                return '###.###.###-##'
            },
            document_length() {
                return this.document_mask.match(/#/g).length
            },
            document_label() {
                if (this.form.document_type === CONTRACT_DOCUMENT_TYPE_ENTITY)
                    return `CNPJ`

                return 'CPF'
            },
            rules() {
                return {
                    immobile: [RequiredValidatorRule('immobile')],
                    receiver_email: [
                        RequiredValidatorRule('email'),
                        EmailValidatorRule('email'),
                    ],
                    receiver_name: [RequiredValidatorRule('name')],
                    document_type: [
                        RequiredValidatorRule('document type'),
                        InValidatorRule('document type', this.document_types),
                    ],
                    document_number: [
                        RequiredValidatorRule('document number'),
                        SizeValidatorRule(
                            'document number',
                            this.document_length,
                            onlyNumbersParser
                        ),
                        DocumentValidatorRule(
                            'document number',
                            this.form.document_type
                        ),
                    ],
                }
            },
        },
        methods: {
            async onSubmit() {
                if (this.loading && this.selectedImmobile) return
                this.loading = true

                return ApiClient()
                    .post(
                        `/immobile/${this.selectedImmobile.uuid}/contract`,
                        Object.assign(
                            {
                                ...this.form,
                            },
                            {
                                document_number: onlyNumbersParser(
                                    this.form.document_number
                                ),
                            }
                        )
                    )
                    .then((response) => {
                        const contract = ApiResourceParser(response)
                        this.$router.push({ name: 'immobile.index' })
                    })
                    .catch(console.log)
                    .finally(() => (this.loading = false))
            },
            async makeSearch(search) {
                if (!search) {
                    this.immobiles = []
                    this.selectedImmobile = null
                }

                if (this.loadingImmobile) {
                    return
                }

                this.loadingImmobile = true

                // YOUR AJAX Methods go here
                // if you prefer not to use vue-api-query
                await ApiClient()
                    .get('/immobile', {
                        params: {
                            search: this.searchImmobile,
                        },
                    })
                    .then((response) => {
                        this.immobiles = ApiResourceParser(response)
                        console.log(this.immobiles)
                    })
                    .catch(console.log)
                    .finally(() => (this.loadingImmobile = false))
            },
        },
        watch: {
            searchImmobile(value) {
                if (!value) {
                    return
                }

                debounce(this.makeSearch, 200)(value)
            },
        },
    }
</script>

<style scoped></style>
