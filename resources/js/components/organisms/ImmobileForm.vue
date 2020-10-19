<template>
    <v-row>
        <v-col md="12" lg="8" sm="12">
            <v-card class="elevation-4 pa-4">
                <v-card-text>
                    <v-form v-model="valid" @submit.prevent="onSubmit">
                        <v-text-field
                            type="email"
                            outlined
                            dense
                            label="Owner e-mail"
                            v-model="form.email"
                            :rules="rules.email"
                        />

                        <div class="d-flex justify-center">
                            <v-switch
                                label="Brazilian address"
                                color="primary"
                                class="mt-0"
                                v-model="brazilianAddress"
                            />
                        </div>

                        <v-row>
                            <v-col cols="4">
                                <v-combobox
                                    v-model="form.state"
                                    :items="ibge.states"
                                    v-if="brazilianAddress"
                                    outlined
                                    dense
                                    autocomplete="off"
                                    label="Select a state"
                                    @change="onStateUpdate"
                                    :rules="rules.state"
                                />
                                <v-text-field
                                    v-else
                                    v-model="form.state"
                                    label="State"
                                    outlined
                                    dense
                                    :rules="rules.state"
                                />
                            </v-col>
                            <v-col>
                                <v-combobox
                                    v-model="form.city"
                                    :items="ibge.cities"
                                    v-if="brazilianAddress"
                                    autocomplete="off"
                                    outlined
                                    label="Select a city"
                                    dense
                                    :rules="rules.city"
                                />
                                <v-text-field
                                    v-else
                                    v-model="form.city"
                                    label="City"
                                    outlined
                                    dense
                                    :rules="rules.city"
                                />
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <v-text-field
                                    v-model="form.neighborhood"
                                    outlined
                                    dense
                                    label="Neighborhood"
                                    :rules="rules.neighborhood"
                                />
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="form.street"
                                    outlined
                                    dense
                                    label="Street"
                                    :rules="rules.street"
                                />
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <v-text-field
                                    v-model="form.number"
                                    outlined
                                    dense
                                    label="Number (optional)"
                                />
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="form.complement"
                                    outlined
                                    dense
                                    label="Complement (optional)"
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
    import IBGEClient from '../../utils/consumer/ibge'
    import { ApiBodyParser } from '../../utils/parsers/api-body'
    import { RequiredValidatorRule } from '../../utils/validator/required'
    import { EmailValidatorRule } from '../../utils/validator/email'
    import { StringSorter } from '../../utils/sorter/string'
    import { ApiClient } from '../../utils/consumer/api'
    import { ApiResourceParser } from '../../utils/parsers/api-resource'

    export default {
        name: 'OrganismsImmobileForm',
        data() {
            return {
                valid: false,
                loading: false,
                brazilianAddress: false,
                ibge: {
                    cities: [],
                    states: [],
                },
                form: {
                    email: null,
                    city: null,
                    state: null,
                    neighborhood: null,
                    street: null,
                    number: null,
                    complement: null,
                },
            }
        },
        computed: {
            rules() {
                return {
                    email: [
                        RequiredValidatorRule('email'),
                        EmailValidatorRule('email'),
                    ],
                    city: [RequiredValidatorRule('city')],
                    state: [RequiredValidatorRule('state')],
                    neighborhood: [RequiredValidatorRule('neighborhood')],
                    street: [RequiredValidatorRule('street')],
                }
            },
        },
        methods: {
            async onStateUpdate(state) {
                if (state) {
                    await this.loadCities(state)
                }
            },
            async loadStates() {
                const response = await IBGEClient.states()
                const states = ApiBodyParser(response)

                this.ibge.states = states
                    .map(({ sigla }) => sigla)
                    .sort(StringSorter())
            },
            async loadCities(uf) {
                const response = await IBGEClient.cities(uf)
                const cities = ApiBodyParser(response)

                this.ibge.cities = cities
                    .map(({ nome }) => nome)
                    .sort(StringSorter())
            },
            async onSubmit() {
                if (this.loading) return
                this.loading = true

                return ApiClient()
                    .post('/immobile', this.form)
                    .then((response) => {
                        const immobile = ApiResourceParser(response)
                        this.$router.push({ name: 'immobile.index' })
                    })
                    .catch(console.log)
                    .finally(() => (this.loading = false))
            },
        },
        async mounted() {
            await this.loadStates()
        },
    }
</script>

<style scoped></style>
