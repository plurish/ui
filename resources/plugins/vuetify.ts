import '@mdi/font/css/materialdesignicons.css';

import 'vuetify/styles';
import { createVuetify, ThemeDefinition } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { aliases, mdi } from 'vuetify/iconsets/mdi';

// TODO: customizar scrollbar de acordo com o theme
const darkTheme: ThemeDefinition = {
    dark: true,
    colors: {
        primary: '#67CED4',
        secondary: '#47688D',
    },
};

const lightTheme: ThemeDefinition = {
    dark: false,
    colors: {
        primary: '#253649',
        secondary: '#2F9FA6',
    },
};

export default createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'dark',
        themes: {
            dark: darkTheme,
            light: lightTheme,
        },
    },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
});
