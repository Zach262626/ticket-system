import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/js/app.js', 
                'resources/scss/app.scss',
            ],
            refresh: true,
        }),
    ],
    resolve: {
    alias: {
      vue: 'vue/dist/vue.esm-bundler.js',
    },
    css: {
      devSourcemap: false
    }
  },
});
