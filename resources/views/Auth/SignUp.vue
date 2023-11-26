<template>
    <Head title="Cadastro" />

    <div class="h-screen flex align-center justify-center">
        <v-card
            class="pa-12 pb-6"
            elevation="8"
            max-width="448"
            min-width="400"
            rounded="lg"
        >
            <v-form @submit.prevent="signup" ref="form">
                <v-alert
                    v-if="alert.text"
                    v-bind="alert"
                    variant="outlined"
                    class="mb-4"
                />

                <Logo class="flex justify-center align-center mb-8" />

                <v-text-field
                    v-model="form.username"
                    density="compact"
                    label="Username"
                    prepend-inner-icon="mdi-account"
                    variant="outlined"
                    :rules="validations.username"
                    :disabled="loading"
                    class="mb-4"
                ></v-text-field>

                <v-text-field
                    v-model="form.email"
                    density="compact"
                    label="E-mail"
                    prepend-inner-icon="mdi-account"
                    variant="outlined"
                    :rules="validations.email"
                    :disabled="loading"
                    class="mb-4"
                ></v-text-field>

                <v-text-field
                    v-model="form.password"
                    :append-inner-icon="
                        showPassword ? 'mdi-eye-off' : 'mdi-eye'
                    "
                    :type="showPassword ? 'text' : 'password'"
                    density="compact"
                    label="Senha"
                    prepend-inner-icon="mdi-lock-outline"
                    variant="outlined"
                    @click:append-inner="showPassword = !showPassword"
                    :rules="validations.password"
                    :disabled="loading"
                ></v-text-field>

                <v-text-field
                    v-model="form.password_confirmation"
                    :append-inner-icon="
                        showPassword ? 'mdi-eye-off' : 'mdi-eye'
                    "
                    :type="showPassword ? 'text' : 'password'"
                    density="compact"
                    label="Confirmar senha"
                    prepend-inner-icon="mdi-lock-outline"
                    variant="outlined"
                    @click:append-inner="showPassword = !showPassword"
                    :rules="passConfirmationValidations"
                    :disabled="loading"
                ></v-text-field>

                <v-checkbox
                    v-model="form.terms_accepted"
                    label="Aceito as condições e termos de uso"
                    color="primary"
                    hide-details
                    required
                ></v-checkbox>

                <v-btn
                    block
                    class="mb-8 mt-4"
                    color="blue"
                    size="large"
                    variant="tonal"
                    type="submit"
                    :disabled="loading"
                >
                    <span v-if="!loading">Cadastrar</span>

                    <v-progress-circular
                        v-if="loading"
                        indeterminate
                        color="primary"
                        class="pl-2"
                    ></v-progress-circular>
                </v-btn>

                <v-card-text class="text-center">
                    <Link
                        class="text-blue text-decoration-none"
                        href="/auth/signin"
                    >
                        Já possui uma conta?
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </Link>
                </v-card-text>
            </v-form>
        </v-card>
    </div>
</template>

<script lang="ts">
import { DefineComponent, PropType, defineComponent } from 'vue';
import { VuetifyAlert } from '@/assets/ts/utils/vuetify-alert';
import axios, { AxiosResponse, AxiosError } from 'axios';
import { Head, Link, router } from '@inertiajs/vue3';
import { SubmitEventPromise } from 'vuetify';
import Logo from '@/components/Logo.vue';
import validations from '@/assets/ts/utils/form-validations';

export default defineComponent({
    components: { Head, Link, Logo },

    data: () => ({
        loading: false,
        alert: {
            title: '',
            text: '',
            type: undefined,
            closable: false,
        } as VuetifyAlert,
        form: {
            username: '',
            email: '',
            password: '',
            password_confirmation: '',
            terms_accepted: false,
        },
        showPassword: false,
        validations: {
            username: validations.username,
            email: validations.email,
            password: validations.password,
            terms_accepts: [
                (value: boolean) =>
                    value ||
                    'Os termos de uso devem ser aceitos, para prosseguir',
            ],
        },
    }),

    computed: {
        passConfirmationValidations() {
            return [
                (confirmation: string) =>
                    confirmation === this.form.password ||
                    'A confirmação deve coincidir com a senha',
            ];
        },
    },

    methods: {
        async signup(event: SubmitEventPromise) {
            const error = {
                occurred: false,
                message: '',
            };

            try {
                const form = this.$refs.form as DefineComponent;

                if (!form.isValid) return;

                if (this.form.password !== this.form.password_confirmation) {
                    error.occurred = true;
                    error.message = '';
                }

                this.loading = true;

                const { data, status }: AxiosResponse = await axios.post(
                    '/api/auth/signup',
                    this.form,
                );

                if (status == 201) {
                    router.visit('/auth/signin');

                    this.alert = {
                        title: 'Sucesso!',
                        text:
                            data?.message ??
                            'Você será redirecionado para o login',
                        type: 'success',
                        closable: true,
                    };
                } else {
                    const responseWrapper = data?.response?.data;

                    error.occurred = true;
                    error.message = responseWrapper?.data?.message;
                }
            } catch (e) {
                console.error(e);

                if (e instanceof AxiosError) {
                    const errorMessage: string =
                        e?.response?.data?.message ?? e.message;

                    error.message = errorMessage;
                    error.occurred = true;
                }
            } finally {
                this.loading = false;

                if (error.occurred)
                    this.alert = {
                        title: 'Algo deu errado',
                        text:
                            error.message ||
                            'Algo deu errado ao tentar lhe cadastrar. Recarregue a página ou tente novamente',
                        type: 'error',
                        closable: true,
                    };
            }
        },
    },
});
</script>
