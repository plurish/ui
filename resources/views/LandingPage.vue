<template>
    <Head title="Bem Vindo!" />

    <header>
        <a href="#" class="logo" style="color: #52c7ce">Plurish</a>
        <nav>
            <a href="#home" style="color: #2a2a2a" class="active">Nós</a>
            <a href="#about" style="color: #050052">Sobre</a>
            <a href="#services" style="color: #0d179d">Planos</a>
            <a href="#portifolio" style="color: #050052">Lançamentos</a>
            <a href="#contact" style="color: #050052">Cadastre-se</a>
        </nav>
    </header>

    <section id="home" style="color: #2a2a2a">Home</section>
    <section id="about"></section>
    <section id="services">Services</section>
    <section id="portifolio">Portfolio</section>
    <section id="contact">Contact</section>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

export default defineComponent({
    components: { Head },

    created() {
        // let sec = document.querySelectorAll('section');
        // let links = document.querySelectorAll('nav a');
        // window.onscroll = () => {
        //     sec.forEach((section) => {
        //         let top = window.scrollY;
        //         let offset = section.offsetTop - 80;
        //         let height = section.offsetHeight;
        //         let id = section.getAttribute('id');
        //         if (top >= offset && top < offset + height) {
        //             links.forEach((link) => {
        //                 link.classList.remove('active');
        //                 document
        //                     .querySelector('nav a[href*=' + id + ']')
        //                     ?.classList.add('active');
        //             });
        //         }
        //     });
        // };
    },
});
</script>

<style lang="scss" scoped>
$colors: (
    primary: #222831,
    secondary: #52c7ce,
    p1: #2e3540,
    p2: #0d1117,
);

body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    scroll-behavior: smooth;
    background: #0d1117;
    background: linear-gradient(
        90deg,
        map-get($colors, p2) 0%,
        map-get($colors, p1) 100%
    );
}

section {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 8em;
    font-weight: 800;
    color: rgba(0, 0, 0, 0.25);
    text-transform: uppercase;
    /* background: var(--clr); */
}

header {
    position: fixed;
    top: 0;
    width: 100%;
    background: #333;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 50px 0;
}

#home {
    background-size: 1900px 1900px;
}

#about {
    background-size: 1900px 1900px;
}

#services {
    background-size: 1900px 1900px;
}

#portifolio {
    background-size: 1900px 1900px;
}

#contact {
    background-size: 1900px 1900px;
}

.logo {
    position: relative;
    padding-bottom: 10px;
    color: #fff;
    font-size: 2em;
    font-weight: 700;
    text-decoration: none;
}

header nav {
    display: flex;
    gap: 10px;
}

header nav a {
    position: relative;
    text-decoration: none;
    padding: 12px 20px;
    color: #fff;
    font-weight: 500;
}

header nav a.active {
    background: var(--clr);
    color: #fff;
    height: 60px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

header nav a.active::before {
    content: '';
    position: absolute;
    left: -20px;
    bottom: 0;
    width: 20px;
    height: 20px;
    background: transparent;
    border-bottom-right-radius: 20px;
    box-shadow: 5px 5px 0 5px var(--clr);
}

header nav a.active::after {
    content: '';
    position: absolute;
    right: -20px;
    bottom: 0;
    width: 20px;
    height: 20px;
    background: transparent;
    border-bottom-left-radius: 20px;
    box-shadow: -5px 5px 0 5px var(--clr);
}
</style>
