import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/js/app.js'],
            refresh: [
                'resources/js/Pages/**',
                'resources/js/Components/**',
                'resources/routes/**',
                'routes/**',
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }), 
    ],
    server: {
        watch: {
            usePolling: true,
        },
    },
});
