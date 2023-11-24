<template>
    <Head title="Iniciar Sessão" />

    <v-form>
        <v-text-field label="Username"></v-text-field>
        <v-text-field label="Password"></v-text-field>

        <v-checkbox input-value="true" value>Manter-me conectado</v-checkbox>

        <v-btn color="success">Iniciar Sessão</v-btn>
    </v-form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

export default defineComponent({
    components: { Head },
});
</script>
