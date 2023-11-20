<template>
    <Head title="Home" />

    <body>
    <header>
        <a href="#" class="logo" style="--clr:#52c7ce;">Plurish</a>

    </header>
    <section id="home">Home</section>
    <section id="about"></section>
    <section id="services">Services</section>
    <section id="portifolio">Portifolio</section>
    <section id="contact">Contact</section>

</body>
    
</template>

<script lang='ts'>;
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

export default defineComponent({
    components: { Head }
});
</script>

