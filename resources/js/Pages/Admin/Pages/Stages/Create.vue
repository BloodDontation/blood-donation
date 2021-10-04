<template>

    <admin-layout ref="admin_layout" :nav_items="nav_items" :active_index="active_index"
                  :breadcrumb="breadcrumb">

        <main class="h-full overflow-y-auto">

            <div class="px-6 mx-auto grid">

                <div class="flex justify-between">

                    <div class="">

                        <h2 class="my-6 text-2xl font-semibold">

                            {{ trans(active_page) }}

                        </h2>

                    </div>

                </div>

                <form @submit.prevent="add_stages">

                    <div class="whitespace-nowrap overflow-x-auto">

                        <div class="card-body bg-white">

                            <div class="flex flex-wrap">


                                <div class="flex flex-wrap w-full md:w-10/12">

                                    <div class="flex form-control w-full md:w-2/2 px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('name')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <span class="absolute top-0 left-0 rounded-r-none btn" disabled>
                                                <i class="fas fa-align-left text-xl"></i>
                                            </span>

                                            <input v-model="stages.name"
                                                   :class="[ errors.name ? 'input-error' : 'input-primary' ]"
                                                   type="text" class="w-full pl-16 input input-bordered">

                                        </div>

                                        <label class="label" v-if="errors.name">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.name}}
                                            </span>
                                        </label>

                                    </div>


                                    <div class="flex form-control w-full md:w-1/2 px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('Type')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <span class="absolute top-0 left-0 rounded-r-none btn" disabled>
                                                <i class="fas fa-align-left text-xl"></i>
                                            </span>

                                            <select v-model="stages.type"
                                                    :class="[ errors.type ? 'input-error' : 'input-primary' ]"
                                                    class="w-full pl-16 input input-bordered">
                                                <option value="Required">Required</option>
                                                <option value="Optioninal">Optioninal</option>
                                            </select>

                                        </div>

                                        <label class="label" v-if="errors.type">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.type}}
                                            </span>
                                        </label>

                                    </div>

                                    <div class="flex form-control w-full md:w-1/2 px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('Prerequisite')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <span class="absolute top-0 left-0 rounded-r-none btn" disabled>
                                                <i class="fas fa-align-left text-xl"></i>
                                            </span>


                                            <select v-model="stages.prerequisite"
                                                    :class="[ errors.prerequisite ? 'input-error' : 'input-primary' ]"
                                                    @change="setCodeAndLabelForForm($event.target.selectedIndex)"
                                                    class="w-full pl-16 input input-bordered">
                                                <option value="">None</option>
                                                <option v-for="i in stages1" :value="i.id">{{ i.name }}</option>
                                            </select>

                                        </div>

                                        <label class="label" v-if="errors.prerequisite">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.prerequisite}}
                                            </span>
                                        </label>

                                    </div>

                                    <div class="flex form-control w-full px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('description')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <textarea v-model="stages.description"
                                                      :class="[ errors.description ? 'input-error' : 'input-primary' ]"
                                                      class="textarea h-28 w-full textarea-bordered">
                                            </textarea>

                                        </div>

                                        <label class="label" v-if="errors.description">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.description}}
                                            </span>
                                        </label>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                    <div class="flex justify-end">

                        <div class="mt-4">

                            <button
                                type="submit"
                                class="btn"
                                :class="[ stages.processing ? 'loading' : '']"
                                :disabled="stages.processing"
                            >
                                {{trans('save')}}
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </main>

    </admin-layout>

    <!-- dropback -->
    <div v-if="show_modal" class="opacity-50 fixed inset-0 z-40 bg-black"></div>
    <!-- end dropback -->


</template>

<script>

    import AdminLayout from '@/Layouts/AdminLayout.vue'

    // import VueTimepicker from 'vue3-timepicker';

    // import 'vue3-timepicker/dist/VueTimepicker.css'

    import datepicker from 'vue3-datepicker';

    export default {

        components: {

            AdminLayout,
            // VueTimepicker,
            datepicker

        },

        props: {

            nav_items: [],
            active_page: String,
            active_index: 0,
            breadcrumb: [],
            stages1: [],

            errors: [],


        },

        data: function () {

            return {


                show_modal: false,

                stages: this.$inertia.form({

                    name: null,
                    description: null,
                    type: null,
                    prerequisite: null,

                }),

            };

        },

        updated() {

            this.$refs.admin_layout.show_toast();

        },

        methods: {

            add_stages: function () {

                this.stages.transform(data => ({

                    ...data,

                }))
                    .post(this.route('admin-stages-store'), {

                        // onFinish: () => this.$refs.admin_layout.show_toast(),
                        onsSuccess: () => {
                            this.$refs.admin_layout.show_toast();
                        },

                        onsError: () => {
                            this.$refs.admin_layout.show_toast();
                        },

                    });

            },

        },

        computed: {},

    }

</script>
