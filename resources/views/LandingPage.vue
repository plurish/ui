<template>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heya, Plurish</title>
    <link rel="stylesheet" type="text/css" href="landpage.css">
</head>

<body>
    <header>
        <a href="#" class="logo" style="--clr:#52c7ce;">Plurish</a>
        <nav>
            <a href="#home" style="--clr: #2a2a2a;" class=" active">Nós</a>
            <a href="#about" style="--clr:#050052;">Sobre</a>
            <a href="#services" style="--clr:#0d179d;">Planos</a>
            <a href="#portifolio" style="--clr:#050052;">Lançamentos</a>
            <a href="#contact" style="--clr:#050052;">Cadastre-se</a>
        </nav>
    </header>
    <section id="home" style="--clr:#2a2a2a;">Home</section>
    <section id="about"></section>
    <section id="services">Services</section>
    <section id="portifolio">Portifolio</section>
    <section id="contact">Contact</section>

</body>
</html>

</template>

<script lang='ts'>;
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

export default defineComponent({
    components: { Head }
});
</script>

<script>
let sec = document.querySelectorAll('section');
let links = document.querySelectorAll('nav a');

window.onscroll = () => {
    sec.forEach(section => {
        let top = window.scrollY;
        let offset = section.offsetTop - 80;  
        let height = section.offsetHeight;
        let id = section.getAttribute('id');

        if(top >= offset && top < offset + height){
            links.forEach(link => {
                link.classList.remove('active');
                document.querySelector('nav a[href*=' + id + ']').classList.add('active');                            
            })
        }
    })
}; 
</script>