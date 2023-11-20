<template>
    <Head title="Home" />

    <ul>
        <li v-for="game in games">{{ game?.title }}</li>
    </ul>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

// apenas exemplo. TODO: mover para diretório de DTOs
type Game = {
    id: number;
    title: string;
    cover: string;
    description: string;
    genre: string;
    publisher: string;
    developer: string;
    platform: string;
    videos: string[];
};

export default defineComponent({
    components: { Head },

    props: {
        games: Array as () => Game[],
    },
});
</script>
