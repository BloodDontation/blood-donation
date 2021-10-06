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

                    <table class="table w-full">

                        <thead>

                        <tr>

                            <th class="px-4 py-3">#</th>

<!--                            <th class="px-4 py-3">{{trans('i_stages')}}</th>-->
<!--                            <th class="px-4 py-3">{{trans('i_plans')}}</th>-->
                            <th class="px-4 py-3">{{trans('position')}}</th>
                            <th class="px-4 py-3">{{trans('name')}}</th>


                        </tr>

                        </thead>

                        <!--                        <draggable :list="stages" :options="{}" :element="'tbody'">-->
                        <tbody>
                        <draggable class="dragArea list-group w-full"  :list="list"  @change="update">

                            <tr class=""
                                v-for="(stages,index) in stages.data" :key="index">

                                <td class="px-4 py-3">{{stages.id}}</td>

<!--                                <td class="px-4 py-3">{{stages.i_stages}}</td>-->

<!--                                <td class="px-4 py-3">{{stages.i_plans}}</td>-->
                                <td class="px-4 py-3">{{stages.position}}</td>
                                <td class="px-4 py-3">{{stages.name}}</td>


                            </tr>


                        </draggable>
                        </tbody>
                    </table>

                </div>


            </div>

        </main>

    </admin-layout>

</template>

<script>

    import AdminLayout from '@/Layouts/AdminLayout.vue'
    import { VueDraggableNext } from 'vue-draggable-next'


    export default {

        components: {

            AdminLayout,
            draggable: VueDraggableNext,


        },

        props: {

            nav_items: [],
            active_index: 0,
            breadcrumb: [],
            active_page: null,
            stages: [],
            term: null,
            id: null,

        },
        data() {
            return {
                enabled: true,
                list: this.stages.data ,
                dragging: false,

            }
        },
        methods: {
            update() {
                this.list.map((stages, index) => {
                    stages.position = index + 1;
                })
                axios.put('/admin/plans/'+this.id+'/update-position', {
                    stages: this.list
                }).then((response) => {
                    // success message
                })
            }
        },

        mounted() {

            this.$refs.admin_layout.show_toast();

        },

        updated() {

            this.$refs.admin_layout.show_toast();

        },

    }

</script>
