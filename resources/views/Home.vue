<template>
    <Head title="Home" />

    <link rel="stylesheet" href="home.css">

    <section class="slider">
        <div class="slider-content">
            <input type="radio" name="btn-radio" id="radio1">
            <input type="radio" name="btn-radio" id="radio2">
            <input type="radio" name="btn-radio" id="radio3">

            <div class="slide-box primeiro">
                <img class="img-desktop" src="../../public/build/images/img (4).png" alt="slide 1">
                <img class="img-mobile" src="../../public/build/images/img (1).png" alt="slide 1">
            </div>

            <div class="slide-box">
                <img class="img-desktop" src="../../public/build/images/img (3).png" alt="slide 2">
                <img class="img-mobile" src="../../public/build/images/img (2).png" alt="slide 1">
            </div>

            <div class="slide-box">
                <img class="img-desktop" src="../../public/build/images/img (4).png" alt="slide 3">
                <img class="img-mobile" src="../../public/build/images/img (1).png" alt="slide 1">
            </div>   

            <div class="slide-box">
                <img class="img-desktop" src="../../public/build/images/img (3).png" alt="slide 4">
                <img class="img-mobile" src="../../public/build/images/img (2).png" alt="slide 1">
            </div>   

            <div class="nav-auto">
                <div  class="auto-btn1"></div>
                <div  class="auto-btn2"></div>
                <div  class="auto-btn3"></div>
                <div  class="auto-btn4"></div>
            </div>

            <div class="nav-manual">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
                <label for="radio3" class="manual-btn"></label>
                <label for="radio4" class="manual-btn"></label>
            </div>
        </div>
    </section> 

<br>
<br>
<br>

  <v-sheet
    class="mx-auto"
    elevation="5"
    width="1500"
  >
    <v-slide-group
    v-model="model"
      class="pa-4 #fff"
      center-active
      show-arrows
    >
      <v-slide-group-item
        v-for="n in 15"
        :key="n"
        v-slot="{ isSelected, toggle, selectedClass }"
      >
        <v-card        
          :class="['ma-4', selectedClass]"
          height="140"
          width="250"
          @click="toggle"
          v-for="game in games"><img :src="game.cover"
        >
          <div class="d-flex align-center justify-center">
            <v-scale-transition>
              <v-icon
                v-if="isSelected"
                color="white"
                size="48"
                icon="mdi-close-circle-outline"
              ></v-icon>
            </v-scale-transition>
          </div>
        </v-card>
      </v-slide-group-item>
    </v-slide-group>
  </v-sheet>
<br>
<br>
  <v-sheet
    class="mx-auto"
    elevation="5"
    width="1500"
  >
    <v-slide-group
    v-model="model"
      class="pa-4"
      center-active
      show-arrows
    >
      <v-slide-group-item
        v-for="n in 15"
        :key="n"
        v-slot="{ isSelected, toggle, selectedClass }"
      >
        <v-card        
          :class="['ma-4', selectedClass]"
          height="140"
          width="250"
          @click="toggle"
          v-for="game in games"><img :src="game.cover"
        >
          <div class="d-flex align-center justify-center">
            <v-scale-transition>
              <v-icon
                v-if="isSelected"
                color="white"
                size="48"
                icon="mdi-close-circle-outline"
              ></v-icon>
            </v-scale-transition>
          </div>
        </v-card>
      </v-slide-group-item>
    </v-slide-group>
  </v-sheet>


</template>

<script lang="ts" >
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
        
        data: () => ({
        model: null,
        }),

    });

</script>
