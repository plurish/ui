<template>
    <Head :title="`Admin - Editar ${user?.username ?? 'usuário'}`" />

    <v-card :title="user?.username ?? 'Usuário'" class="p-4">
        <v-container class="my-4" v-if="alert.text">
            <v-alert v-bind="alert" variant="outlined" />
        </v-container>

        <v-container v-if="showSkeletonLoader">
            <v-skeleton-loader
                type="card-avatar"
                class="mb-4"
            ></v-skeleton-loader>
            <v-skeleton-loader type="paragraph"></v-skeleton-loader>
        </v-container>

        <v-container v-if="user" class="mt-4">
            <v-row class="gap-4">
                <v-text-field
                    v-model="user.username"
                    density="compact"
                    label="Username"
                    variant="outlined"
                    disabled
                ></v-text-field>

                <v-text-field
                    v-model="user.email"
                    density="compact"
                    label="E-mail"
                    variant="outlined"
                    disabled
                ></v-text-field>
            </v-row>

            <v-row>
                <v-col cols="6" class="p-0">
                    <v-select
                        multiple
                        chips
                        v-model="user.roles"
                        :items="roles"
                    ></v-select>
                </v-col>

                <v-col cols="6">
                    <v-switch
                        v-model="user.active"
                        color="primary"
                        label="Ativo"
                    ></v-switch>
                </v-col>
            </v-row>
        </v-container>

        <v-card-actions class="gap-4">
            <v-spacer />

            <v-btn
                @click="$emit('close')"
                text="Cancelar"
                color="secondary"
                variant="outlined"
            ></v-btn>

            <v-btn @click="save" color="primary" variant="flat">
                <span v-if="!loading">Salvar</span>

                <v-progress-circular
                    v-if="loading"
                    indeterminate
                    color="secondary"
                    class="ml-2"
                ></v-progress-circular
            ></v-btn>
        </v-card-actions>
    </v-card>
</template>

<script lang="ts">
import { VuetifyAlert } from '@/assets/ts/utils/vuetify-alert';
import { ResponseWrapper, User } from '@/assets/ts/dtos';
import axios, { AxiosError, AxiosResponse } from 'axios';
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

export default defineComponent({
    components: { Head },

    emits: ['close', 'edited-successfully'],

    props: {
        userId: {
            required: true,
            type: Number,
        },
    },

    data: () => ({
        showSkeletonLoader: true,
        loading: true,
        alert: {
            title: '',
            text: '',
            type: undefined,
            closable: false,
        } as VuetifyAlert,
        user: null as User | null,
        roles: ['ROLE_PLAYER', 'ROLE_ADMIN'],
    }),

    created() {
        this.fetchUser(this.userId);

        // TODO: adicionar rules para o campo de select
        /* TODO: usar inertia form, pra permitir o salvamento 
           apenas se algo foi de fato alterado */
    },

    methods: {
        async fetchUser(id: number) {
            let errorMessage = '';

            try {
                this.loading = true;

                const { status, data }: AxiosResponse = await axios.get(
                    '/api/user/' + id,
                );

                const response = data as ResponseWrapper<User>;

                if (status !== 200) {
                    errorMessage =
                        response?.message ??
                        'Um erro inesperado ocorreu na busca do usuário';
                    return;
                }

                this.user = response.data;
            } catch (e: unknown) {
                console.error(e);

                if (e instanceof AxiosError)
                    errorMessage = e?.response?.data?.message ?? e.message;
            } finally {
                this.loading = false;
                this.showSkeletonLoader = false;

                if (errorMessage)
                    this.alert = {
                        title: 'Oops! Algo deu errado',
                        text: errorMessage,
                        type: 'error',
                        closable: true,
                    };
            }
        },
        async save() {
            let errorMessage = '';

            try {
                this.loading = true;

                const { status, data }: AxiosResponse = await axios.patch(
                    '/api/user/',
                    {
                        ...this.user,
                        password: '',
                    },
                );

                const response = data as ResponseWrapper<boolean>;

                if (status !== 200) {
                    errorMessage =
                        response?.message ??
                        'Um erro inesperado ocorreu na edição do usuário';
                    return;
                }

                this.$emit(
                    'edited-successfully',
                    (this.alert = {
                        title: 'Sucesso!',
                        text:
                            response?.message ??
                            'Edição realizada com sucesso!',
                        type: 'success',
                        closable: true,
                    }),
                );
            } catch (e: unknown) {
                console.error(e);

                if (e instanceof AxiosError)
                    errorMessage = e?.response?.data?.message ?? e.message;
            } finally {
                this.loading = false;

                if (errorMessage)
                    this.alert = {
                        title: 'Oops! Algo deu errado',
                        text: errorMessage,
                        type: 'error',
                        closable: true,
                    };
            }
        },
    },
});
</script>
