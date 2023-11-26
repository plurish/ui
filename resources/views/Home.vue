<template>
    <Head title="Home"><link rel="stylesheet" href="/hometest.css" /></Head>

    <body>
        <header>
            <a href="#" class="logo" style="--clr: #52c7ce">Plurish</a>
        </header>

        <!-- Slider Main -->
        <v-carousel
            cycle
            height="600"
            hide-delimiter-background
            show-arrows="hover"
        >
            <v-carousel-item v-for="(slide, i) in slides" :key="i">
                <v-sheet :color="colors[i]" height="100%">
                    <div class="d-flex fill-height justify-center align-center">
                        <div class="text-h2">{{ slide }} Slide</div>
                    </div>
                </v-sheet>
            </v-carousel-item>
        </v-carousel>

        <br />
        <br />

        <!-- Slider Jogos 1 -->
        <v-sheet
            class="mx-auto"
            elevation="8"
            max-width="1700"
            color="transparent"
        >
            <v-slide-group
                v-model="model"
                class="pa-4"
                selected-class="bg-success"
                show-arrows
            >
                <v-slide-group-item
                    v-for="n in 15"
                    :key="n"
                    v-slot="{ isSelected, toggle, selectedClass }"
                >
                    <v-card
                        color="grey-lighten-1"
                        :class="['ma-4', selectedClass]"
                        height="170"
                        width="270"
                        @click="toggle"
                    >
                        <div
                            class="d-flex fill-height align-center justify-center"
                        >
                            <v-scale-transition>
                                <v-icon
                                    v-if="isSelected"
                                    color="white"
                                    size="48"
                                    icon="mdi-close-circle-outline"
                                ></v-icon>
                            </v-scale-transition>
                        </div>
                    </v-card>
                </v-slide-group-item>
            </v-slide-group>
        </v-sheet>

        <!-- Slider Jogos 2 -->
        <v-sheet
            class="mx-auto"
            elevation="8"
            max-width="1700"
            color="transparent"
        >
            <v-slide-group
                v-model="model"
                class="pa-4"
                selected-class="bg-success"
                show-arrows
            >
                <v-slide-group-item
                    v-for="n in 15"
                    :key="n"
                    v-slot="{ isSelected, toggle, selectedClass }"
                >
                    <v-card
                        color="grey-lighten-1"
                        :class="['ma-4', selectedClass]"
                        height="170"
                        width="270"
                        @click="toggle"
                    >
                        <div
                            class="d-flex fill-height align-center justify-center"
                        >
                            <v-scale-transition>
                                <v-icon
                                    v-if="isSelected"
                                    color="white"
                                    size="48"
                                    icon="mdi-close-circle-outline"
                                ></v-icon>
                            </v-scale-transition>
                        </div>
                    </v-card>
                </v-slide-group-item>
            </v-slide-group>
        </v-sheet>

        <!-- Banner propaganda -->
        <section class="embaixo">
            <div class="embaixo-1">
                <p>1</p>
            </div>
        </section>

        <!-- Slider Jogos 3 -->
        <v-sheet
            class="mx-auto"
            elevation="8"
            max-width="1700"
            color="transparent"
        >
            <v-slide-group
                v-model="model"
                class="pa-4"
                selected-class="bg-success"
                show-arrows
            >
                <v-slide-group-item
                    v-for="n in 15"
                    :key="n"
                    v-slot="{ isSelected, toggle, selectedClass }"
                >
                    <v-card
                        color="grey-lighten-1"
                        :class="['ma-4', selectedClass]"
                        height="170"
                        width="270"
                        @click="toggle"
                    >
                        <div
                            class="d-flex fill-height align-center justify-center"
                        >
                            <v-scale-transition>
                                <v-icon
                                    v-if="isSelected"
                                    color="white"
                                    size="48"
                                    icon="mdi-close-circle-outline"
                                ></v-icon>
                            </v-scale-transition>
                        </div>
                    </v-card>
                </v-slide-group-item>
            </v-slide-group>
        </v-sheet>

        <!-- Banner Characters -->
        <section class="emcima">
            <div class="emcima-item"><p>1</p></div>
            <div class="emcima-item"><p>2</p></div>
            <div class="emcima-item"><p>3</p></div>
            <div class="emcima-item"><p>4</p></div>
        </section>

        <!-- Banner Abas -->
        <section class="embaixo">
            <div class="embaixo-item">
                <p>a</p>
            </div>

            <div class="embaixo-div">
                <div class="embaixo-item">
                    <p>b</p>
                </div>

                <div class="embaixo-item">
                    <p>c</p>
                </div>

                <div class="embaixo-item">
                    <p>d</p>
                </div>
            </div>
        </section>
    </body>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';
import { GamePartial } from '@/assets/ts/dtos';
import { GamePartial } from '@/assets/ts/dtos';

export default defineComponent({
    components: { Head },
    data() {
        return {
            colors: [
                'indigo',
                'warning',
                'pink darken-2',
                'red lighten-1',
                'deep-purple accent-4',
            ],
            slides: ['First', 'Second', 'Third', 'Fourth', 'Fifth'],
        };
    },

    props: {
        games: Array<GamePartial>,
    },
});
</script>
