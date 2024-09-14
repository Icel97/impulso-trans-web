import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< .merge_file_AIhmnG
            input: ["resources/css/app.css", "resources/js/app.js"],
=======
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
>>>>>>> .merge_file_ud9Eaj
            refresh: true,
        }),
    ],
});
