<template>
    <Head title="Home" />

    <body>
    <header>
        <a href="#" class="logo" style="--clr:#52c7ce;">Plurish</a>
    </header>
    
    <section id="home">Home</section>
    <section id="about">Teste
        <div class="slider-content">
            <input type="radio" name="btn-radio" id="radio1">
            <input type="radio" name="btn-radio" id="radio2">
            <input type="radio" name="btn-radio" id="radio3">

            <div class="slide-box primeiro">
                <img class="img-desktop" src="Banner_1.jpg" alt="slide 1">
                <img class="img-mobile" src="Banner_1.jpg" alt="slide 2">
            </div>

            <div class="slide-box">
                <img class="img-desktop" src="Banner_2.jpg" alt="slide 1">
                <img class="img-mobile" src="Banner_2.jpg" alt="slide 2">
            </div>

            <div class="slide-box">
                <img class="img-desktop" src="Banner_3.jpg" alt="slide 1">
                <img class="img-mobile" src="Banner_3.jpg" alt="slide 2">
            </div>

            <div class="nav-auto">
                <div class="auto-btn1"></div>
                <div class="auto-btn2"></div>
                <div class="auto-btn3"></div>

                </div>
            </div>

        </div>
    </section>
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