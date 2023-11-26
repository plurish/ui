<template>
    <Head
        :title="mode === 'edit' ? `Editar ${user?.username}` : 'Criar Usuário'"
    />
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { Head } from '@inertiajs/vue3';
import { User } from '@/assets/ts/dtos';

type Mode = 'create' | 'edit';

export default defineComponent({
    components: { Head },

    props: {
        mode: String as PropType<Mode>,
        user: Object as PropType<User | null>,
    },
});
</script>
