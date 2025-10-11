import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { glob } from 'glob';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...glob.sync('resources/js/pages/**/*.js'),  // ← 全ページJS自動読み込み
            ],
            refresh: true,
        }),
    ],
});
