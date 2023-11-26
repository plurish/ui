<template>
    <Head title="Home" />

    <v-carousel show-arrows="hover" min-height="450" cycle>
        <v-carousel-item
            v-for="ad in advertisements"
            :key="ad.id"
            :src="ad.cover"
            cover
        ></v-carousel-item>
    </v-carousel>

    <div v-for="section in slideSections" :key="section.title">
        <v-sheet elevation="8" color="transparent">
            <v-slide-group
                v-model="section.state"
                class="pa-4"
                selected-class="bg-success"
                show-arrows
            >
                <v-slide-group-item
                    v-for="game in section.slides"
                    :key="game.id"
                    v-slot="{ isSelected, toggle, selectedClass }"
                >
                    <v-card
                        :class="['ma-4', selectedClass]"
                        width="270"
                        @click="toggle"
                    >
                        <v-img :src="game.cover" cover></v-img>

                        <v-card-title>{{ game.title }}</v-card-title>

                        <!--
                            <v-card-actions>
                                <v-spacer />

                                <v-btn
                                    text="Ver detalhes"
                                    prepend-icon=""
                                    variant="flat"
                                ></v-btn>
                            </v-card-actions>
                        -->
                    </v-card>
                </v-slide-group-item>
            </v-slide-group>
        </v-sheet>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';
import { GamePartial } from '@/assets/ts/dtos';

export default defineComponent({
    components: { Head },

    props: {
        advertisements: Array<GamePartial>,
        trendings: Array<GamePartial>,
        populars: Array<GamePartial>,
        new_releases: Array<GamePartial>,
        recommendeds: Array<GamePartial>,
    },

    data: () => ({}),

    computed: {
        slideSections() {
            return [
                { title: 'Em alta', slides: this.trendings, state: null },
                { title: 'Populares', slides: this.populars, state: null },
                {
                    title: 'Recomendados',
                    slides: this.recommendeds,
                    state: null,
                },
                {
                    title: 'Lançamentos',
                    slides: this.new_releases,
                    state: null,
                },
            ];
        },
    },
});
</script>
