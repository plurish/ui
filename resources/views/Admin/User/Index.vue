<template>
    <Head title="Usuários" />

    <v-container class="my-4 max-w-screen-md" v-if="alert.text">
        <v-alert v-bind="alert" variant="outlined" />
    </v-container>

    <v-container v-if="showSkeletonLoader" class="max-w-screen-md">
        <v-skeleton-loader type="paragraph" class="mb-4"></v-skeleton-loader>
        <v-skeleton-loader type="card"></v-skeleton-loader>
    </v-container>

    <v-container v-show="!showSkeletonLoader" class="max-w-screen-md">
        <h1 class="text-xl my-4 !opacity-90">Usuários</h1>

        <div class="flex justify-center align-center py-6" v-if="loading">
            <v-progress-circular
                indeterminate
                color="primary"
                :size="70"
                :width="7"
            ></v-progress-circular>
        </div>

        <div v-show="!loading">
            <v-row class="mb-4">
                <v-col cols="6">
                    <v-text-field
                        v-model="search"
                        prepend-inner-icon="mdi-magnify"
                        density="compact"
                        label="Filtrar"
                        flat
                        variant="solo"
                        hide-details
                        single-line
                    >
                    </v-text-field>
                </v-col>
            </v-row>

            <v-data-table
                :items="tableUsers"
                v-model:search="search"
                :headers="tableHeaders"
            >
                <template
                    v-slot:header.id
                    :filterable="false"
                    :sortable="false"
                ></template>

                <template v-slot:item.id="{ item: user }">
                    <v-row class="!min-w-[100px]">
                        <v-dialog width="600">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" icon="mdi-pencil"></v-btn>
                            </template>

                            <template v-slot:default="{ isActive }">
                                <Form
                                    :user-id="user?.id"
                                    @close="isActive.value = false"
                                    @edited-successfully="
                                        (message: VuetifyAlert) => {
                                            alert = message;
                                            isActive.value = false;
                                            reload();
                                        }
                                    "
                                />
                            </template>
                        </v-dialog>

                        <v-dialog width="500">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props" icon="mdi-delete"></v-btn>
                            </template>

                            <template v-slot:default="{ isActive }">
                                <v-card title="Tem certeza?">
                                    <v-card-text>
                                        Tem certeza que deseja deletar o usuário
                                        '{{
                                            users?.find((u) => u.id == user?.id)
                                                ?.username
                                        }}'?
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-spacer />

                                        <v-btn
                                            text="Cancelar"
                                            color="primary"
                                            variant="elevated"
                                            @click="isActive.value = false"
                                        ></v-btn>

                                        <v-btn
                                            text="Confirmar"
                                            color="secondary"
                                            variant="outlined"
                                            @click="
                                                isActive.value = false;
                                                deleteUser(user?.id);
                                            "
                                        ></v-btn>
                                    </v-card-actions>
                                </v-card>
                            </template>
                        </v-dialog>
                    </v-row>
                </template>
            </v-data-table>
        </div>
    </v-container>
</template>

<script lang="ts">
import { UserPartial } from '@/assets/ts/dtos';
import { defineComponent } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { VuetifyAlert } from '@/assets/ts/utils/vuetify-alert';
import axios, { AxiosResponse, AxiosError } from 'axios';
import Form from './Form.vue';

export default defineComponent({
    components: { Head, Form },

    props: {
        users: Array<UserPartial>,
    },

    data: () => ({
        showSkeletonLoader: false,
        loading: false,
        alert: {
            title: '',
            text: '',
            type: undefined,
            closable: false,
        } as VuetifyAlert,
        search: '',
        tableHeaders: [
            {
                title: 'Username',
                value: 'username',
                sortable: true,
                filterable: true,
            },
            {
                title: 'E-mail',
                value: 'email',
                sortable: true,
                filterable: true,
            },
            { title: 'Tipo', value: 'tipo', sortable: true, filterable: true },
            { key: 'id', sortable: false, filterable: false },
        ],
    }),

    computed: {
        tableUsers() {
            return this.users?.map((u) => ({
                id: u.id,
                username: u.username,
                email: u.email,
                tipo: u.roles.map((r) => r.split('_')[1]).join(', '),
            }));
        },
    },

    methods: {
        async deleteUser(id: number) {
            let errorMessage = '';

            try {
                this.loading = true;

                const { status, data }: AxiosResponse = await axios.delete(
                    '/api/user/' + id,
                );

                if (status !== 200) {
                    errorMessage =
                        data?.message ??
                        'Um erro inesperado ocorreu na deleção do usuário';
                    return;
                }

                this.alert = {
                    title: 'Sucesso!',
                    text: data?.message ?? 'Usuário deletado com sucesso',
                    type: 'success',
                    closable: true,
                };

                this.reload();
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
        reload() {
            this.showSkeletonLoader = true;

            router.reload({
                onFinish: () => {
                    this.showSkeletonLoader = false;
                },
            });
        },
    },
});
</script>
