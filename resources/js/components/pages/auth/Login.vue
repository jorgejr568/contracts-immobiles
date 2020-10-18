<template>
    <v-container
        style="min-height: 100vh"
        class="d-flex justify-center align-center"
    >
        <v-row justify="center">
            <v-col md="6" lg="4" sm="12">
                <v-card class="elevation-10">
                    <v-card-title
                        class="primary white--text d-flex justify-center"
                    >
                        HELLGATE
                    </v-card-title>

                    <v-card-text>
                        <v-form
                            class="mt-5"
                            v-model="validForm"
                            @submit.prevent="attempt"
                        >
                            <v-text-field
                                type="email"
                                label="E-mail"
                                outlined
                                dense
                                :rules="rules.email"
                                v-model="auth.email"
                            />
                            <v-text-field
                                type="password"
                                label="Password"
                                outlined
                                dense
                                class="mt-4"
                                persistent-hint
                                :hint="forgotPasswordText"
                                :rules="rules.password"
                                v-model="auth.password"
                            >
                                <template v-slot:message="{ message, key }">
                                    <span v-html="message" />
                                </template>
                            </v-text-field>
                            <v-btn
                                :loading="isLoading"
                                type="submit"
                                block
                                class="mt-2"
                                color="primary"
                                :disabled="!validForm"
                                >SIGN-IN</v-btn
                            >
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar v-model="authError.display" color="error">
            {{ authError.message }}
        </v-snackbar>
    </v-container>
</template>

<script>
    import EnvironmentsLayout from '../../environments/Layout'
    import { RequiredValidatorRule } from '../../../utils/validator/required'
    import { EmailValidatorRule } from '../../../utils/validator/email'
    import { ApiClient } from '../../../utils/consumer/api'
    import { ApiBodyParser } from '../../../utils/parsers/api-body'
    export default {
        name: 'PagesAuthLogin',
        components: { EnvironmentsLayout },
        data() {
            return {
                validForm: true,
                isLoading: false,
                auth: {
                    email: '',
                    password: '',
                },
                authError: {
                    display: false,
                    message: '',
                },
            }
        },
        computed: {
            forgotPasswordText() {
                return '<span v-else>Forgot your password? <a href="#">Click here</a></span>'
            },
            rules() {
                return {
                    email: [
                        RequiredValidatorRule('email'),
                        EmailValidatorRule('email'),
                    ],
                    password: [RequiredValidatorRule('password')],
                }
            },
        },
        methods: {
            attempt() {
                if (this.isLoading) return
                this.isLoading = true
                ApiClient()
                    .post('/auth', this.auth)
                    .then(async (response) => {
                        const token = ApiBodyParser(response)
                        await this.$store.dispatch('user/setToken', token)
                        await this.$router.push({ name: 'dashboard.home' })
                    })
                    .catch(({ response }) => {
                        this.authError = {
                            display: true,
                            message: 'Authentication failed',
                        }
                    })
                    .finally(() => (this.isLoading = false))
            },
        },
    }
</script>

<style scoped></style>
