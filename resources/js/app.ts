import "./bootstrap";
import "../css/app.css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { VueQueryPlugin } from "@tanstack/vue-query";
import { i18nVue } from "laravel-vue-i18n";
import { setupCalendar } from "v-calendar";
import "v-calendar/style.css";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18nVue, {
                resolve: async (lang: string) => {
                    const langs = import.meta.glob("../../lang/*.json");
                    return await langs[`../../lang/${lang}.json`]();
                },
            })
            .use(VueQueryPlugin)
            .use(setupCalendar, {})
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
