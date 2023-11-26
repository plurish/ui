<template>
    <Head title="Home" />

    <v-carousel cycle interval="4000" height="400" show-arrows="hover">
        <v-carousel-item
            v-for="game in advertisements?.slice(0, 5)"
            :key="game.id"
            :src="game.cover"
            cover
        >
        </v-carousel-item>
    </v-carousel>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Game, GamePartial } from '@/assets/ts/dtos';

export default defineComponent({
    components: { Head },

    props: {
        advertisements: Array<GamePartial>,
        new_releases: Array<GamePartial>,
        trendings: Array<GamePartial>,
        populars: Array<GamePartial>,
        recommendeds: Array<GamePartial>,
    },
});
</script>
