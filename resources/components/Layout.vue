<template>
    <v-app>
        <v-app-bar :elevation="2" density="comfortable">
            <v-app-bar-nav-icon
                @click="showSidebar = !showSidebar"
            ></v-app-bar-nav-icon>

            <v-app-bar-title>
                <Logo />
            </v-app-bar-title>

            <template v-slot:append>
                <v-btn icon="mdi-magnify"></v-btn>
            </template>
        </v-app-bar>

        <v-navigation-drawer v-model="showSidebar">
            <v-list-item
                v-if="!loading"
                :title="user?.username ?? 'Guest'"
                prepend-icon="mdi-account-circle"
            ></v-list-item>

            <v-skeleton-loader
                v-else
                type="list-item-avatar"
            ></v-skeleton-loader>

            <v-divider />

            <v-list density="compact" nav>
                <Link href="/">
                    <v-list-item
                        title="Home"
                        prepend-icon="mdi-home"
                        value="home"
                    ></v-list-item>
                </Link>

                <v-list-group
                    v-if="user?.roles.includes('ROLE_ADMIN')"
                    value="admin"
                >
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            prepend-icon="mdi-security"
                            title="Admin"
                        >
                        </v-list-item>
                    </template>

                    <Link href="/admin/user">
                        <v-list-item
                            title="Usuários"
                            prepend-icon="mdi-account-multiple-outline"
                            value="admin-users"
                        >
                        </v-list-item>
                    </Link>
                </v-list-group>

                <v-list-item
                    title="Mudar tema"
                    value="theme"
                    prepend-icon="mdi-theme-light-dark"
                    @click="toggleTheme"
                >
                </v-list-item>

                <v-skeleton-loader
                    v-if="loading"
                    type="list-item-avatar"
                ></v-skeleton-loader>

                <v-list-item
                    @click="signout"
                    v-else-if="user?.username"
                    title="Sair"
                    prepend-icon="mdi-logout"
                    value="signout"
                ></v-list-item>

                <div v-else>
                    <Link href="/auth/signin">
                        <v-list-item
                            title="Entrar"
                            prepend-icon="mdi-login"
                            value="signin"
                        ></v-list-item>
                    </Link>
                </div>
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <slot />
        </v-main>

        <v-card flat>
            <v-card-text class="text-center white--text">
                &copy; 2023 Plurish. All rights reserved.
            </v-card-text>
        </v-card>
    </v-app>
</template>

<script lang="ts">
import { defineComponent, provide, ref } from 'vue';
import axios, { AxiosResponse } from 'axios';
import Logo from '@/components/Logo.vue';
import { Link } from '@inertiajs/vue3';
import { useTheme } from 'vuetify';
import { User } from '@/assets/ts/dtos';

export default /*#__PURE__*/ defineComponent({
    components: { Link, Logo },

    setup: () => {
        const user = ref(null as User | null);

        provide('user', user);

        return {
            theme: useTheme(),
            user,
        };
    },

    data: () => ({
        showSidebar: false,
        loading: false,
    }),

    computed: {
        isAdmin() {
            return this.user?.roles.includes('ROLE_ADMIN');
        },
    },

    created() {
        this.getCurrentUser();
    },

    methods: {
        toggleTheme() {
            const theme = this.theme.global;

            theme.name.value = theme.current.value.dark ? 'light' : 'dark';
        },
        async getCurrentUser() {
            try {
                this.loading = true;

                const { data: response }: AxiosResponse =
                    await axios.get('/api/auth/whoami');

                this.user = Object.freeze(response.data) as User;
            } catch (e: unknown) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
        async signout() {
            try {
                this.loading = true;

                const { status }: AxiosResponse =
                    await axios.delete('/api/auth/signout');

                if ((status >= 200 && status <= 299) || status == 302)
                    location.reload();
            } catch (e: unknown) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
    },
});
</script>
