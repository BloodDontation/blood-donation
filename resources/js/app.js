require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

import moshaToast from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(moshaToast)
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

                    return_array_for_select(array, value_key, name_key, add_new_option = false, full_object_with_index = false, index = -1, translate = false)
                    {

                        let list = array.map((object) => {

                            let value = object[value_key];

                            if ( full_object_with_index )
                            {
                                value = {
                                    object: object,
                                    index: index
                                };
                            }

                            return {

                                value: value,
                                name: translate ? this.trans(object[name_key]) : object[name_key],
                                icon: null,

                            };

                        });

                        if ( add_new_option )
                        {

                            const new_option =
                            {
                                value: -1,
                                name: this.trans('add'),
                                icon: 'fas fa-plus-square',
                            }

                            list = [new_option, ...list];
                        }

                        return list;

                    },

                }

            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
