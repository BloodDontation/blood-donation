require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({

                methods: {

                    route,

                    get_current_lang() {
                        return this.$page.props.lang['current_language'];
                    },

                    trans(key, params = {}) {

                        key = key?.toString().toLowerCase();

                        if (this.$page.props.lang['dictionary'] == null || this.$page.props.lang['dictionary'].length <= 0)
                        {
                            return key;
                        }

                        let translate = this.$page.props.lang['dictionary'][key];

                        Object.keys(params).forEach(param => {

                            translate = translate.replaceAll(param, params[param]);

                        });

                        return translate ?? key;


                    },

                }

            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
