import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fg from 'fast-glob';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...fg.sync('resources/js/pages/**/*.js'),
                ...fg.sync('resources/js/components/modals/*.js'),
            ],
            refresh: true,
        }),
    ],
});
