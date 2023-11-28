<template>
    <Head :title="game?.title ?? 'Jogo'" />

    <!-- TODO: USAR O BACKGROUND IMAGE DO GAME COMO FUNDO-->

    <v-card :title="game?.title ?? 'Jogo'" class="p-4">
        <template v-slot:append>
            <v-btn icon="mdi-close-circle" @click="$emit('close')"></v-btn>
        </template>

        <v-container class="my-4" v-if="alert.text">
            <v-alert v-bind="alert" variant="flat"></v-alert>
        </v-container>

        <v-container v-if="showSkeletonLoader">
            <v-skeleton-loader type="image" class="mb-4"></v-skeleton-loader>
            <v-skeleton-loader type="article"></v-skeleton-loader>
        </v-container>

        <v-container v-if="game">
            <v-carousel show-arrows="hover" height="300" cycle>
                <v-carousel-item
                    v-for="imageUrl in game.screenshots"
                    :key="game.id"
                    :src="imageUrl"
                    cover
                ></v-carousel-item>
            </v-carousel>

            <v-divider class="my-4"></v-divider>

            <v-container>
                <v-row no-gutters>
                    <v-col cols="12" md="6" class="p-3">
                        <p>
                            <span class="text-primary mr-2"
                                >Desenvolvedora:</span
                            >
                            <span class="text-sm">{{ game.developer }}</span>
                        </p>
                        <p>
                            <span class="text-primary mr-2"
                                >Distribuidora:</span
                            >
                            <span class="text-sm">{{ game.publisher }}</span>
                        </p>
                        <p>
                            <span class="text-primary mr-2">Plataforma:</span>
                            <span class="text-sm">{{ game.platform }}</span>
                        </p>
                        <p>
                            <span class="text-primary mr-2">Gênero:</span>
                            <span class="text-sm">{{ game.genre }}</span>
                        </p>
                    </v-col>

                    <v-col cols="12" lg="6" class="p-3">
                        <div class="flex align-end mb-2">
                            <Link :href="game.game_url">
                                <v-btn
                                    text="Jogar"
                                    variant="flat"
                                    color="primary"
                                ></v-btn>
                            </Link>
                        </div>

                        <div v-if="game.sys_requirements">
                            <h2 class="text-base mb-4">Requisitos</h2>

                            <p>
                                <span class="text-primary mr-2">SO:</span>
                                <span class="text-sm">{{
                                    game.sys_requirements.os
                                }}</span>
                            </p>
                            <p>
                                <span class="text-primary mr-2"
                                    >Armazenamento:</span
                                >
                                <span class="text-sm">{{
                                    game.sys_requirements.storage
                                }}</span>
                            </p>
                            <p>
                                <span class="text-primary mr-2"
                                    >Placa gráfica:</span
                                >
                                <span class="text-sm">{{
                                    game.sys_requirements.graphics
                                }}</span>
                            </p>
                            <p>
                                <span class="text-primary mr-2"
                                    >Processador:</span
                                >
                                <span class="text-sm">{{
                                    game.sys_requirements.processor
                                }}</span>
                            </p>
                            <p>
                                <span class="text-primary mr-2">Memória:</span>
                                <span class="text-sm">{{
                                    game.sys_requirements.memory
                                }}</span>
                            </p>
                        </div>

                        <p>
                            <span class="text-primary mr-2"
                                >Data de lançamento:</span
                            >
                            <span class="text-sm">{{ game.release_date }}</span>
                        </p>
                    </v-col>
                </v-row>
            </v-container>

            <v-divider></v-divider>

            <v-card title="Descrição" class="text-sm mt-4">
                <v-container>
                    {{ game.description }}
                </v-container>
            </v-card>
        </v-container>

        <!-- videos? -->
    </v-card>
</template>

<script lang="ts">
import { VuetifyAlert } from '@/assets/ts/utils/vuetify-alert';
import { Game, ResponseWrapper } from '@/assets/ts/dtos';
import axios, { AxiosError, AxiosResponse } from 'axios';
import { Head, Link } from '@inertiajs/vue3';
import { defineComponent } from 'vue';

export default defineComponent({
    components: { Head, Link },

    emits: ['close'],

    props: {
        gameId: {
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
        game: null as Game | null,
    }),

    created() {
        this.fetchGame();
    },

    methods: {
        async fetchGame() {
            let errorMessage = '';

            try {
                this.loading = true;
                this.showSkeletonLoader = true;

                const { status, data }: AxiosResponse = await axios.get(
                    '/api/game/' + this.gameId,
                );

                const response = data as ResponseWrapper<Game>;

                if (status !== 200) {
                    errorMessage =
                        response?.message ??
                        'Um erro inesperado ocorreu na busca do jogo';
                    return;
                }

                this.game = response.data;
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
    },
});
</script>
