<template>

    <admin-layout ref="admin_layout" :nav_items="nav_items" :active_index="active_index" :breadcrumb="breadcrumb">

        <main class="h-full overflow-y-auto">

            <div class="px-6 mx-auto grid">

                <div class="flex justify-between">

                    <div class="">

                        <h2 class="my-6 text-2xl font-semibold">

                            {{trans(active_page)}}

                        </h2>

                    </div>

                    <div class="my-6">

                        <a :href="route('admin-register-form')" class="btn" target="_blank">
                            {{trans('add')}}
                        </a>

                    </div>

                </div>

                <div class="flex w-full mb-4">

                    <div class="relative w-full">

                        <input
                            type="text"
                            :placeholder="placeholder"
                            v-model="term"
                            class="w-full pr-16 input input-primary input-bordered"
                        >

                        <div class="btn-group absolute top-0 right-0">

                            <button @click.prevent="search_donors"
                                class="btn rounded-l-none">

                                {{trans('search')}}

                            </button>

                            <button @click="clear_search"
                                class="btn btn-error">

                                {{trans('clear')}}

                            </button>

                        </div>


                    </div>

                </div>

                <div class="whitespace-nowrap overflow-x-auto mb-12">

                    <table class="table w-full">

                            <thead>

                                <tr>

                                    <th class="px-4 py-3">#</th>

                                    <th class="px-4 py-3">{{trans('name')}}</th>

                                    <th class="px-4 py-3">{{trans('cpr')}}</th>

                                    <th class="px-4 py-3">{{trans('phone')}}</th>

                                    <th class="px-4 py-3">{{trans('age')}}</th>

                                    <th class="px-4 py-3">{{trans('nationality')}}</th>

                                    <th class="px-4 py-3">{{trans('city')}}</th>

                                    <th class="px-4 py-3">{{trans('blood-group')}}</th>

                                    <th class="px-4 py-3">{{trans('time')}}</th>

                                    <th class="px-4 py-3">{{trans('status')}}</th>

                                    <th class="px-4 py-3 text-center w-32"></th>
                                    <th class="px-4 py-3 text-center w-32"></th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr class=""
                                    v-for="(donor,index) in donors" :key="index">

                                    <td class="px-4 py-3">{{donor.id}}</td>

                                    <td class="px-4 py-3">{{donor.name}}</td>

                                    <td class="px-4 py-3">{{donor.cpr}}</td>

                                    <td class="px-4 py-3">{{donor.phone}}</td>

                                    <td class="px-4 py-3">{{donor.age}}</td>

                                    <td class="px-4 py-3">{{donor.nationality}}</td>

                                    <td class="px-4 py-3">{{donor.city}}</td>

                                    <td class="px-4 py-3">{{donor.blod_group}}</td>

                                    <td class="px-4 py-3">{{donor.campaign_donor?.[0]?.time}}</td>

                                    <td class="px-4 py-3">

                                        <div class="badge p-3" v-if="donor.campaign_donor?.[0]">

                                            {{trans(StatusEnum.get_key(donor.campaign_donor?.[0]?.status))}}

                                        </div>

                                    </td>

                                    <td class="px-4 py-3">

                                        <a :href="route('admin-donors-print',donor.cpr)" target="_blank" class="btn">
                                            {{trans('Print')}}
                                        </a>
                                    </td>

                                    <td>

                                        <div class="flex items-center text-sm space-x-4">

                                            <template v-if="StatusEnum.get_key(donor.campaign_donor?.[0]?.status) == 'pending'">
                                                <button class="btn btn-success" @click.prevent="update_donor_status(donor, 'approved')">
                                                    {{trans('approve')}}
                                                </button>
                                                <button class="btn btn-error" @click.prevent="update_donor_status(donor, 'rejected')">
                                                    {{trans('reject')}}
                                                </button>
                                            </template>

                                            <template v-else-if="StatusEnum.get_key(donor.campaign_donor?.[0]?.status) == 'approved'">
                                                <button class="btn btn-error" @click.prevent="update_donor_status(donor, 'rejected')">
                                                    {{trans('reject')}}
                                                </button>
                                            </template>

                                            <template v-else>

                                            </template>


                                        </div>

                                    </td>

                                </tr>


                            </tbody>

                    </table>

                </div>


            </div>

        </main>

    </admin-layout>

</template>

<script>

    import AdminLayout from '@/Layouts/AdminLayout.vue'

    import StatusEnum from '@/Enums/StatusEnum'

    // import moment from 'moment';

    export default {

        components: {

            AdminLayout,

        },

        props: {

            nav_items: [],
            active_index: 0,
            breadcrumb: [],
            active_page: null,
            donors: [],
            term: null,

        },

        data: function() {

            return {

                StatusEnum: new StatusEnum(),

            };

        },

        mounted()
        {

            this.$refs.admin_layout.show_toast();

        },

        updated()
        {

            this.$refs.admin_layout.show_toast();

        },

        methods: {

            update_donor_status: function(donor, status)
            {

                const status_id = this.StatusEnum.get_value(status);

                this.$inertia.post(route('admin-donors-update-status'), {
                    donor_id: donor.id,
                    status: status_id,
                },
                {
                    onFinish: () => {

                        // this.$refs.admin_layout.show_toast();

                    },

                })

            },

            search_donors: function()
            {

                this.$inertia.replace(route('admin-donors-index', {
                    term: this.term,
                }));

            },

            clear_search: function()
            {

                this.$inertia.replace(route('admin-donors-index', {
                    term: '',
                }));

            }

        }

    }

</script>
