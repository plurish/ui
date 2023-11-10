import tailwind from 'tailwindcss';
import postcss from 'postcss-import';
import autoprefixer from 'autoprefixer';

export default {
  plugins: [
    tailwind('./tailwind.config.ts'),
    postcss,
    autoprefixer,
  ]
}