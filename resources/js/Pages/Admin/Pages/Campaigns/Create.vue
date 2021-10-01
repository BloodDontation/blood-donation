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

                <form @submit.prevent="add_campaign">

                    <div class="whitespace-nowrap overflow-x-auto">

                        <div class="card-body bg-white">

                            <div class="flex flex-wrap">

                                <div class="flex w-full md:w-48">

                                    <div class="flex flex-wrap form-control w-full px-2">

                                        <div class="flex items-center justify-between bg-grey-lighter p-2">
                                            <label class="w-36 h-36 flex flex-col items-center px-6 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide capitalize border border-blue cursor-pointer hover:border-white">


                                                <template v-if="campaign.logo">

                                                    <img :src="campaign.logo_url" class="w-full h-full object-contain" @error="HelperService.replace_by_default_img($event, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJycmP3sIPmwRmsf55XLjL0d_jKkpD2gTEALg6kTcfFS9v6Lfi9kSRJv1fLUuod7pMExU&usqp=CAU')">

                                                </template>

                                                <template v-else>

                                                    <svg class="w-8 h-8 my-auto" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                    </svg>

                                                </template>

                                                <input type='file' class="hidden" accept="image/*" name="file"
                                                    @change="select_item_file($event)" />
                                            </label>

                                        </div>

                                    </div>

                                </div>

                                <div class="flex flex-wrap w-full md:w-10/12">

                                    <div class="flex form-control w-full md:w-1/2 px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('name')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <span class="absolute top-0 left-0 rounded-r-none btn" disabled>
                                                <i class="fas fa-align-left text-xl"></i>
                                            </span>

                                            <input v-model="campaign.name"
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
                                                {{trans('location')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <span class="absolute top-0 left-0 rounded-r-none btn" disabled>
                                                <i class="fas fa-align-left text-xl"></i>
                                            </span>

                                            <input v-model="campaign.location"
                                                :class="[ errors.location ? 'input-error' : 'input-primary' ]"
                                                type="text" class="w-full pl-16 input input-bordered">

                                        </div>

                                        <label class="label" v-if="errors.location">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.location}}
                                            </span>
                                        </label>

                                    </div>

                                    <div class="flex form-control w-full md:w-1/2 px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('start-time')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <input v-model="campaign.start_time"
                                                type="datetime-local" class="w-full input input-bordered">

                                        </div>

                                        <label class="label" v-if="errors.start_time">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.start_time}}
                                            </span>
                                        </label>

                                    </div>

                                    <div class="flex form-control w-full md:w-1/2 px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('end-time')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <input v-model="campaign.end_time"
                                                type="datetime-local" class="w-full input input-bordered">

                                        </div>

                                        <label class="label" v-if="errors.end_time">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.end_time}}
                                            </span>
                                        </label>

                                    </div>

                                    <div class="flex form-control w-full md:w-1/2 px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('total-donor')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <span class="absolute top-0 left-0 rounded-r-none btn" disabled>
                                                <i class="fas fa-align-left text-xl"></i>
                                            </span>

                                            <input v-model="campaign.total_donor"
                                                :class="[ errors.total_donor ? 'input-error' : 'input-primary' ]"
                                                type="number" class="w-full pl-16 input input-bordered">

                                        </div>

                                        <label class="label" v-if="errors.total_donor">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.total_donor}}
                                            </span>
                                        </label>

                                    </div>

                                    <div class="flex form-control w-full md:w-1/2 px-2">

                                        <label class="label">
                                            <span class="label-text required">
                                                {{trans('donor-per-hour')}}
                                            </span>
                                        </label>

                                        <div class="relative">

                                            <span class="absolute top-0 left-0 rounded-r-none btn" disabled>
                                                <i class="fas fa-align-left text-xl"></i>
                                            </span>

                                            <input v-model="campaign.donor_per_hour"
                                                :class="[ errors.donor_per_hour ? 'input-error' : 'input-primary' ]"
                                                type="number" class="w-full pl-16 input input-bordered">

                                        </div>

                                        <label class="label" v-if="errors.donor_per_hour">
                                            <span class="label-text-alt text-red-500">
                                                {{errors.donor_per_hour}}
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

                                            <textarea v-model="campaign.description"
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
                                :class="[ campaign.processing ? 'loading' : '']"
                                :disabled="campaign.processing"
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

            errors: [],


        },

        data: function() {

            return {


                show_modal: false,

                campaign: this.$inertia.form({

                    name : null,
                    location : null,
                    description : null,
                    logo : null,
                    status : true,
                    start_time: null,
                    end_time: null,
                    total_donor : null,
                    donor_per_hour : null,
                    registration_status : false,


                }),

            };

        },

        updated()
        {

            this.$refs.admin_layout.show_toast();

        },

        methods: {

            add_campaign: function () {

                this.campaign.transform(data => ({

                    ... data,

                }))
                .post(this.route('admin-campaigns-store'), {

                    // onFinish: () => this.$refs.admin_layout.show_toast(),
                    onsSuccess: () => {
                        this.$refs.admin_layout.show_toast();
                    },

                    onsError: () => {
                        this.$refs.admin_layout.show_toast();
                    },

                });

            },

            select_item_file: function(event)
            {

                this.campaign.logo              = event.target.files[0];
                this.campaign.logo_url     = URL.createObjectURL(event.target.files[0]);

            },


        },

        computed: {

        },

    }

</script>
