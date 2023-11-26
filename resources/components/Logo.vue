<template>
    <Link
        href="/"
        class="text-2xl lg:text-3xl font-bold transition-all hover:scale-[1.05] font-jetbrains text-primary bg-secondary rounded-lg inline-block py-1 px-4"
    >
        plurish
    </Link>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/vue3';

export default defineComponent({
    components: { Link },
});
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@1,700&display=swap');

.font-jetbrains {
    font-family: 'JetBrains Mono', monospace !important;
}
</style>
