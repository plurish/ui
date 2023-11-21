<template>
    <v-app>
        <v-app-bar :elevation="2" density="comfortable">
            <v-app-bar-nav-icon
                @click="showSidebar = !showSidebar"
            ></v-app-bar-nav-icon>

            <v-app-bar-title class="text-2xl font-bold">
                <Link href="/">Plurish</Link>
            </v-app-bar-title>

            <p class="pr-6">{{ seconds }}</p>

            <template v-slot:append>
                <v-icon
                    icon="mdi-theme-light-dark"
                    @click="toggleTheme"
                ></v-icon>
            </template>
        </v-app-bar>

        <v-navigation-drawer v-model="showSidebar">
            <v-list-item
                title="Guest"
                prepend-icon="mdi-account-circle"
            ></v-list-item>

            <v-divider />

            <v-list density="compact" nav>
                <v-list-item
                    title="Home"
                    prepend-icon="mdi-home"
                    value="home"
                ></v-list-item>
                <v-list-item
                    title="Sign In"
                    prepend-icon="mdi-login"
                    value="signin"
                ></v-list-item>
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
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useTheme } from 'vuetify/lib/framework.mjs';

export default /*#__PURE__*/ defineComponent({
    setup() {
        return { theme: useTheme() };
    },

    components: { Link },

    data: () => ({ seconds: 0, showSidebar: false }),

    created() {
        setInterval(() => this.seconds++, 1000);
    },

    methods: {
        toggleTheme() {
            this.theme.global.name.value = this.theme.global.current.value.dark
                ? 'light'
                : 'dark';
        },
    },
});
</script>
