import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { globSync } from 'fast-glob';  // ← 変更

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...globSync('resources/js/pages/**/*.js'),  // ← 変更
            ],
            refresh: true,
        }),
    ],
});
