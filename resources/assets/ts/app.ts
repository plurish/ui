import '@/assets/styles/_app.scss';

import { createInertiaApp } from "@inertiajs/vue3";
import { DefineComponent, createApp, h } from "vue";
import Vuetify from "./vuetify";
import Layout from "@/components/Layout.vue";

createInertiaApp({
    title: (title: string) => `${title} | Plurish`,

    progress: {
        delay: 0,
        includeCSS: true
    },

    resolve: (name: string) => {
        const page = require(`@/views/${name}`).default as DefineComponent;

        page.layout = Layout;

        return page;
    },

    setup({ el, App, props, plugin }) {
        createApp({
            name: 'Plurish',
            render: () => h(App, props)
        })
        .use(plugin)
        .use(Vuetify)
        .mount(el);
    }
})