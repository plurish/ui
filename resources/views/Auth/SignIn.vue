<template>
    <Head title="Iniciar sessão" />

    <div class="h-screen flex align-center justify-center">
        <v-card
            class="pa-12 pb-6"
            elevation="8"
            max-width="448"
            min-width="400"
            rounded="lg"
        >
            <v-form @submit.prevent="signin" ref="form">
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
                    required
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
                    required
                ></v-text-field>

                <v-checkbox
                    v-model="form.remember_me"
                    label="Manter-me conectado"
                    color="primary"
                    hide-details
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
                    <span v-if="!loading">Iniciar sessão</span>

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
                        href="/auth/signup"
                    >
                        Ainda não tem uma conta?
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
import { Head, Link } from '@inertiajs/vue3';
import { SubmitEventPromise } from 'vuetify';
import Logo from '@/components/Logo.vue';
import validations from '@/assets/ts/utils/form-validations';
import { ResponseWrapper } from '@/assets/ts/dtos';

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
            password: '',
            remember_me: false,
        },
        showPassword: false,
        validations: {
            username: validations.username,
            password: validations.password,
        },
    }),

    mounted() {
        window.scrollTo(0, 0);
    },

    methods: {
        async signin(event: SubmitEventPromise) {
            const error = {
                occurred: false,
                message: '',
            };

            try {
                const form = this.$refs.form as DefineComponent;

                if (!form.isValid) return;

                this.loading = true;

                const { data, status }: AxiosResponse = await axios.post(
                    '/api/auth/signin',
                    this.form,
                );

                if ((status >= 200 && status <= 299) || status == 302) {
                    this.alert = {
                        title: 'Sucesso!',
                        text: 'Sessão iniciada com sucesso!',
                        type: 'success',
                        closable: true,
                    };

                    location.reload();
                } else {
                    const responseWrapper = data?.response?.data;

                    error.occurred = true;
                    error.message = responseWrapper?.data?.message;
                }
            } catch (e) {
                console.error(e);

                const axiosError = e as AxiosError;

                if (axiosError) {
                    const response = axiosError?.response
                        ?.data as ResponseWrapper<boolean> | null;

                    const errorMessage: string =
                        response?.message ?? axiosError.message;

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
                            'Algo deu errado ao tentar iniciar a sessão. Recarregue a página ou tente novamente',
                        type: 'error',
                        closable: true,
                    };
            }
        },
    },
});
</script>
