import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/assets/css/style.css',
                'resources/assets/css/components.css',
                'resources/assets/js/stisla.js',
                'resources/assets/js/scripts.js',
                'resources/assets/js/custom.js',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
