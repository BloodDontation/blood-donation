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

                        <a :href="route('admin-stages-create')" class="btn">
                            {{trans('add')}}
                        </a>

                    </div>

                </div>

                <div class="whitespace-nowrap overflow-x-auto">

                    <table class="table w-full">

                        <thead>

                        <tr>

                            <th class="px-4 py-3">#</th>

                            <th class="px-4 py-3">{{trans('name')}}</th>

                            <th class="px-4 py-3 text-center w-32"></th>

                        </tr>

                        </thead>

                        <tbody>

                        <tr class=""
                            v-for="(plans,index) in plans.data" :key="index">

                            <td class="px-4 py-3">{{plans.id}}</td>

                            <td class="px-4 py-3">{{plans.name}}</td>

                            <td>

                                <div class="flex items-center text-sm space-x-4">

                                    <!-- v-if="can(needed_permissions,'update-item')" -->
                                    <a
                                        :href="route('admin-stages-edit', {id: plans.id})"
                                        class="btn"
                                        aria-label="Edit">

                                        <i class="fas fa-pen"></i>

                                    </a>

                                    <!-- using select menu -->
                                    <!-- <Multiselect
                                        label="name"
                                        trackBy="name"
                                        :options="action_options"
                                        :searchable="true"
                                        @change="apply_action_option"
                                    >

                                        <template v-slot:singleLabel="{ value }">

                                            <i :class="value.icon"></i>

                                            {{value.name}}

                                        </template>

                                        <template v-slot:option="{ option }">

                                            <i :class="option.icon" class="mr-2"></i>

                                            {{option.name}}

                                        </template>

                                    </Multiselect> -->

                                    <template v-if="false && item.deleted_at != null">

                                        <!-- v-if="can(needed_permissions,'enable-item')" -->
                                        <button
                                            @click="enable_item(item)"
                                            class="btn"
                                            aria-label="Enable">
                                            <i class="fas fa-sync"></i>
                                        </button>

                                    </template>

                                    <template v-else>

                                        <!-- v-if="can(needed_permissions,'delete-item')" -->
                                        <!-- <button
                                            @click="delete_item(item)"
                                            class="btn"
                                            aria-label="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button> -->

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

    export default {

        components: {

            AdminLayout,

        },

        props: {

            nav_items: [],
            active_index: 0,
            breadcrumb: [],
            active_page: null,
            plans: [],
            term: null,

        },

        mounted()
        {

            this.$refs.admin_layout.show_toast();

        },

        updated()
        {

            this.$refs.admin_layout.show_toast();

        },

    }

</script>
