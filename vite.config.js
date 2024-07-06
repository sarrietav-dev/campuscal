import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vueJsxPlugin from "@vitejs/plugin-vue-jsx";
import i18n from "laravel-vue-i18n/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.ts",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vueJsxPlugin(),
        i18n(),
    ],
});
