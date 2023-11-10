<template>
    <Head title="Home" />

    <v-container class="flex align-center justify-center h-100">
        <h1 class="text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl font-extrabold my-4 text-center
            bg-clip-text text-transparent bg-gradient-to-r from-sky-400 to-blue-50
            hover:bg-gradient-to-l transition-all block mx-auto w-100"
        >
            Welcome to Plurish!
        </h1>
    </v-container>
</template>

<script lang='ts'>;
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

export default defineComponent({
    components: { Head }
});
</script>