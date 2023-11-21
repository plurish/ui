<template>
  <Head title="Home"><link rel="stylesheet" href="/hometest.css" /></Head>

  <body>
  <header>
      <a href="#" class="logo" style="--clr:#52c7ce;">Plurish</a>
  </header>
  
  <section class="emcima">
    <div class="emcima-item"><p>1</p></div>
    <div class="emcima-item"><p>2</p></div>
    <div class="emcima-item"><p>3</p></div>
    <div class="emcima-item"><p>4</p></div>
  </section>

  <section class="embaixo">
    <div class="embaixo-item">
      <p>a</p>
    </div>

    <div class="embaixo-div">
      <div class="embaixo-item">
        <p>b</p>
      </div>

      <div class="embaixo-item">
        <p>c</p>
      </div>

      <div class="embaixo-item">
        <p>d</p>
      </div>
    </div>
  </section>

</body>
    
</template>

<script lang='ts'>
  import { defineComponent } from 'vue';
  import { Head } from '@inertiajs/vue3';

  export default defineComponent({
      components: { Head }
  });
</script>
