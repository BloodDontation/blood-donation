<template>

    <div class="bg-grey-lighter min-h-screen flex flex-col">

        <div class="container w-1/2 mx-auto flex-1 flex flex-col items-center justify-center px-2">

            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">

                <div class="flex w-full">

                    <h1 class="text-xl">
                        {{trans('register-donor')}}
                    </h1>

                </div>

                <div class="flex w-full flex-wrap border-t-2 mt-2">

                    <div class="flex form-control w-full md:w-1/2 px-2">

                        <label class="label">
                            <span class="label-text required">
                                {{trans('name')}}
                            </span>
                        </label>

                        <div class="relative">

                            <input
                                v-model="donor.name"
                                :class="[ errors.name ? 'input-error' : 'input-primary' ]"
                                type="text" class="w-full input input-bordered">

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
                                {{trans('cpr')}}
                            </span>
                        </label>

                        <div class="relative">

                            <input
                                v-model="donor.cpr"
                                :class="[ errors.cpr ? 'input-error' : 'input-primary' ]"
                                type="number" class="w-full input input-bordered">

                        </div>

                        <label class="label" v-if="errors.cpr">
                            <span class="label-text-alt text-red-500">
                                {{errors.cpr}}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{trans('date-of-birth')}}
                            </span>
                        </label>

                        <div class="relative">

                            <datepicker
                                v-model="donor.birth_date"
                                class="w-full input input-bordered"
                            />

                        </div>

                        <label class="label" v-if="errors.birth_date">
                            <span class="label-text-alt text-red-500">
                                {{errors.birth_date}}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{trans('nationality')}}
                            </span>
                        </label>

                        <div class="relative">

                            <Multiselect
                                v-model="donor.nationality"
                                :options="nationalities"
                                :searchable="true"
                                class="w-full input input-bordered"
                            ></Multiselect>

                        </div>

                        <label class="label" v-if="errors.nationality">
                            <span class="label-text-alt text-red-500">
                                {{errors.nationality}}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{trans('city')}}
                            </span>
                        </label>

                        <div class="relative">

                            <Multiselect
                                v-model="donor.city"
                                :options="cities"
                                :searchable="true"
                                class="w-full input input-bordered"
                            ></Multiselect>

                        </div>

                        <label class="label" v-if="errors.nationality">
                            <span class="label-text-alt text-red-500">
                                {{errors.nationality}}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{trans('blood-group')}}
                            </span>
                        </label>

                        <div class="relative">

                            <Multiselect
                                v-model="donor.blood_group"
                                :options="blood_groups"
                                :searchable="true"
                                class="w-full input input-bordered"
                            ></Multiselect>

                        </div>

                        <label class="label" v-if="errors.nationality">
                            <span class="label-text-alt text-red-500">
                                {{errors.nationality}}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{trans('diseases')}}
                            </span>
                        </label>

                        <div class="relative">

                            <Multiselect
                                v-model="donor.diseases"
                                :options="return_array_for_select(diseases, 'id', 'name')"
                                :searchable="true"
                                mode="tags"
                                :createTag="true"
                                :closeOnSelect="false"
                                label="name"
                                trackBy="name"
                                class="w-full input input-bordered"
                            >

                                <template v-slot:singleLabel="{ value }">

                                    <i :class="value.icon"></i>

                                    {{value.name}}

                                </template>

                                <template v-slot:option="{ option }">

                                    <i :class="option.icon" class="mr-2"></i>

                                    {{option.name}}

                                </template>

                            </Multiselect>

                        </div>

                        <label class="label" v-if="errors.nationality">
                            <span class="label-text-alt text-red-500">
                                {{errors.nationality}}
                            </span>
                        </label>

                    </div>

                </div>

                <div class="flex w-full mt-4">

                    <button @click.prevent="register"
                        class="btn w-full"
                        :class="[ donor.processing ? 'loading' : '']"
                        :disabled="donor.processing"
                    >
                        {{trans('regiter')}}
                    </button>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

    import datepicker from 'vue3-datepicker';

    import Multiselect from '@vueform/multiselect';

    export default {

        props: {

            nationalities: [],

            cities: [],

            blood_groups: [],

            diseases: [],

            errors: [],

        },

        components: {

            datepicker,
            Multiselect,

        },

        data: function() {

            return {

                donor: this.$inertia.form({

                    username: null,
                    // password: null,
                    name: null,
                    phone: null,
                    email: null,
                    cpr: null,
                    birth_date: null,
                    city: null,
                    gender: null,
                    nationality: null,
                    religion: null,
                    blod_group: null,
                    status: null,

                    diseases: [],

                }),

            };

        },

        mounted()
        {

            console.log(this.return_array_for_select(this.diseases, 'id', 'name'));

        },

        methods: {

            register: function()
            {

                this.donor.transform(data => ({

                    ... data,

                }))
                .post(this.route('donor-register'), {

                    // onFinish: () => this.$refs.admin_layout.show_toast(),
                    onSuccess: () => {

                    },

                    onError: () => {

                    },

                });

            },

        },

    }

</script>
<style src="@vueform/multiselect/themes/default.css"></style>
