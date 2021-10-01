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

                </div>

                <div class="whitespace-nowrap overflow-x-auto">

                    {{
                        trans('added-successfully', {':type' : 'ترجمة'})
                    }}

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

        }

    }

</script>
