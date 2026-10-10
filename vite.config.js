import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],

    // Dev Harbor: browser → nginx (travels.test:80) → travels-vite:5173
    server: {
        host: '0.0.0.0',
        port: 5173,
        origin: 'http://travels.test',
        allowedHosts: ['travels.test'],
        hmr: {
            host: 'travels.test',
            port: 80,
            protocol: 'ws',
        },
    },
});