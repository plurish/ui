<template>
    <Head title="Home" />

    <v-carousel cycle interval="4000" height="400" show-arrows="hover">
        <v-carousel-item v-for="game in games?.slice(0, 5)" :key="game.id">
            <v-sheet class="h-full">
                <div
                    class="flex justify-center align-center h-full bg-no-repeat bg-center bg-cover"
                    :style="{
                        'background-image': `url(${game.cover})`,
                    }"
                ></div>
            </v-sheet>
        </v-carousel-item>
    </v-carousel>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';
import { GamePartial } from '@/assets/ts/dtos/game-partial.dto';

export default defineComponent({
    components: { Head },

    props: {
        games: Array<GamePartial>,
    },
});
</script>
