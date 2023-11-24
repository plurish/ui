<template>
    <Link
        href="/"
        class="text-2xl lg:text-3xl font-bold transition-all hover:scale-[1.05]"
    >
        Plurish
    </Link>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/vue3';

export default defineComponent({
    components: { Link },
});
</script>
