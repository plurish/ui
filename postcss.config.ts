import tailwindcss from 'tailwindcss';
import postcss from 'postcss-import';
import autoprefixer from 'autoprefixer';

module.exports = {
  plugins: {
    tailwindcss('./tailwind.config.ts'),
    postcss,
    autoprefixer,
  },
}
