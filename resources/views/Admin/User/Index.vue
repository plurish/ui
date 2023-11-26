<template>
    <Head title="Usuários" />

    <v-container class="max-w-screen-md">
        <h1 class="text-xl my-4 !opacity-90">Usuários</h1>

        <v-row class="mb-4">
            <v-col cols="6">
                <v-text-field
                    v-model="search"
                    prepend-inner-icon="mdi-magnify"
                    density="compact"
                    label="Filtrar"
                    flat
                    variant="solo"
                    hide-details
                    single-line
                >
                </v-text-field>
            </v-col>
        </v-row>

        <v-data-table
            :items="formattedUsers"
            v-model:search="search"
            :headers="tableHeaders"
        >
            <template
                v-slot:header.id
                :filterable="false"
                :sortable="false"
            ></template>

            <template v-slot:item.id="{ item: user }">
                <v-row class="!min-w-[100px]">
                    <v-btn
                        icon="mdi-delete"
                        @click="deleteUser(user?.id)"
                    ></v-btn>
                    <v-btn
                        icon="mdi-pencil"
                        @click="editUser(user?.id)"
                    ></v-btn>
                </v-row>
            </template>
        </v-data-table>
    </v-container>
</template>

<script lang="ts">
import { UserPartial } from '@/assets/ts/dtos';
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';

const todo = [
    'create a customizes column for edit/delete buttons',
    'create the delete button',
    'create the edit button',
];

export default defineComponent({
    components: { Head },

    props: {
        users: Array<UserPartial>,
    },

    data: () => ({
        search: '',
        tableHeaders: [
            {
                title: 'Username',
                value: 'username',
                sortable: true,
                filterable: true,
            },
            {
                title: 'E-mail',
                value: 'email',
                sortable: true,
                filterable: true,
            },
            { title: 'Tipo', value: 'tipo', sortable: true, filterable: true },
            { key: 'id', sortable: false, filterable: false },
        ],
    }),

    computed: {
        formattedUsers() {
            return this.users?.map((u) => ({
                id: u.id,
                username: u.username,
                email: u.email,
                tipo: u.roles.map((r) => r.split('_')[1]).join(', '),
            }));
        },
    },

    methods: {
        async showForm() {},
        async deleteUser(id: number) {
            console.log('this user will be deleted: ', id);
        },
        async editUser(id: number) {
            console.log('this user will be edited: ', id);
        },
    },
});
</script>
