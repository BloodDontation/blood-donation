<template>

    <div class="bg-grey-lighter min-h-screen flex flex-col">

        <div class="container w-full md:w-1/2 mx-auto flex-1 flex flex-col items-center justify-center px-2">

            <div class="flex w-full">

                <img :src="current_campaign.logo_url" class="w-64 mx-auto"/>

            </div>

            <!-- <div class="flex w-full">
                <pre>
                    {{errors}}
                </pre>
            </div> -->


            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <br>

                <div class="flex w-full mt-4">

                    <button @click.prevent="fetch"
                            class="btn w-full"
                            :class="[ donor.processing ? 'loading' : '']"
                            :disabled="donor.processing"
                    >
                        {{ trans('smart card') }}
                    </button>

                </div>
                <br>
                <br>

                <div class="flex w-full">

                    <h1 class="text-xl">
                        {{ trans('register-donor') }}
                    </h1>

                </div>

                <div class="flex w-full flex-wrap border-t-2 mt-2">

                    <div class="flex form-control w-full md:w-1/2 px-2">

                        <label class="label">
                            <span class="label-text required">
                                {{ trans('name') }}
                            </span>
                        </label>

                        <div class="relative">

                            <input
                                v-model="donor.name"
                                :class="[ errors.name ? 'input-error' : 'input-primary' ]"
                                type="text" class="w-full input input-bordered"
                            id="name">

                        </div>

                        <label class="label" v-if="errors.name">
                            <span class="label-text-alt text-red-500">
                                {{ errors.name }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">

                        <label class="label">
                            <span class="label-text required">
                                {{ trans('cpr') }}
                            </span>
                        </label>

                        <div class="relative">

                            <input
                                v-model="donor.cpr"
                                :class="[ errors.cpr ? 'input-error' : 'input-primary' ]"
                                type="text" class="w-full input input-bordered" id="cpr">

                        </div>

                        <label class="label" v-if="errors.cpr">
                            <span class="label-text-alt text-red-500">
                                {{ errors.cpr }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('date-of-birth') }}
                            </span>
                        </label>

                        <div class="relative">

                            <datepicker
                                v-model="donor.birth_date"
                                class="w-full input input-bordered"  id="birth"
                            />

                        </div>

                        <label class="label" v-if="errors.birth_date">
                            <span class="label-text-alt text-red-500">
                                {{ errors.birth_date }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('gender') }}
                            </span>
                        </label>

                        <div class="relative">
                            <Multiselect
                                v-model="donor.gender"
                                :options="return_array_for_select(genders, 'key', `name_${get_current_lang()}`)"
                                label="name"
                                trackBy="name"
                                :searchable="true"
                                class="w-full input input-bordered"
                                id="gender"
                            ></Multiselect>

                        </div>

                        <label class="label" v-if="errors.gender">
                            <span class="label-text-alt text-red-500">
                                {{ errors.gender }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('phone') }}
                            </span>
                        </label>

                        <div class="relative">
                            <input
                                v-model="donor.phone"
                                :class="[ errors.phone ? 'input-error' : 'input-primary' ]"
                                type="number" class="w-full input input-bordered">

                        </div>

                        <label class="label" v-if="errors.phone">
                            <span class="label-text-alt text-red-500">
                                {{ errors.phone }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('email') }}
                            </span>
                        </label>

                        <div class="relative">

                            <!-- <Multiselect
                                v-model="donor.nationality"
                                :options="nationalities"
                                :searchable="true"
                                class="w-full input input-bordered"
                            ></Multiselect> -->
                            <input
                                v-model="donor.email"
                                :class="[ errors.email ? 'input-error' : 'input-primary' ]"
                                type="email" class="w-full input input-bordered">

                        </div>

                        <label class="label" v-if="errors.email">
                            <span class="label-text-alt text-red-500">
                                {{ errors.email }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('nationality') }}
                            </span>
                        </label>

                        <div class="relative">

                            <!-- <Multiselect
                                v-model="donor.nationality"
                                :options="nationalities"
                                :searchable="true"
                                class="w-full input input-bordered"
                            ></Multiselect> -->
                            <input
                                v-model="donor.nationality"
                                :class="[ errors.nationality ? 'input-error' : 'input-primary' ]"
                                type="text" class="w-full input input-bordered"  id="nationality">

                        </div>

                        <label class="label" v-if="errors.nationality">
                            <span class="label-text-alt text-red-500">
                                {{ errors.nationality }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('city') }}
                            </span>
                        </label>

                        <div class="relative">

                            <!-- <Multiselect
                                v-model="donor.city"
                                :options="cities"
                                :searchable="true"
                                class="w-full input input-bordered"
                            ></Multiselect> -->

                            <input
                                v-model="donor.city"
                                :class="[ errors.city ? 'input-error' : 'input-primary' ]"
                                type="text" class="w-full input input-bordered"  id="city">

                        </div>

                        <label class="label" v-if="errors.city">
                            <span class="label-text-alt text-red-500">
                                {{ errors.city }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('blood-group') }}
                            </span>
                        </label>

                        <div class="relative">

                            <Multiselect
                                v-model="donor.blod_group"
                                :options="blood_groups"
                                :searchable="true"
                                class="w-full input input-bordered"
                            ></Multiselect>

                        </div>

                        <label class="label" v-if="errors.blod_group">
                            <span class="label-text-alt text-red-500">
                                {{ errors.blod_group }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('diseases') }}
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

                                    {{ value.name }}

                                </template>

                                <template v-slot:option="{ option }">

                                    <i :class="option.icon" class="mr-2"></i>

                                    {{ option.name }}

                                </template>

                            </Multiselect>

                        </div>

                        <label class="label" v-if="errors.diseases">
                            <span class="label-text-alt text-red-500">
                                {{ errors.diseases }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('last-travel-date') }}
                            </span>
                        </label>

                        <div class="relative">

                            <datepicker
                                v-model="donor.last_travel_date"
                                class="w-full input input-bordered"
                            />

                        </div>

                        <label class="label" v-if="errors.last_travel_date">
                            <span class="label-text-alt text-red-500">
                                {{ errors.last_travel_date }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full px-2" v-if="false">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('last-donate-date') }}
                            </span>
                        </label>

                        <div class="relative">

                            <datepicker
                                v-model="donor.last_donate_date"
                                class="w-full input input-bordered"
                            />

                        </div>

                        <label class="label" v-if="errors.last_donate_date">
                            <span class="label-text-alt text-red-500">
                                {{ errors.last_donate_date }}
                            </span>
                        </label>

                    </div>

                    <div class="flex form-control w-full md:w-1/2 px-2">
                        <label class="label">
                            <span class="label-text required">
                                {{ trans('time') }}
                            </span>
                        </label>

                        <div class="relative">

                            <!-- v-model="donor.city" -->
                            <Multiselect
                                v-model="donor.selected_time"
                                :options="timings_for_select"
                                label="name"
                                trackBy="name"
                                :disabled="isDisabled"
                                :searchable="true"
                                class="w-full input input-bordered"
                            ></Multiselect>

                        </div>

                        <!-- <label class="label" v-if="errors.city">
                            <span class="label-text-alt text-red-500">
                                {{errors.city}}
                            </span>
                        </label> -->

                    </div>

                    <div class="flex form-control">

                        <label class="cursor-pointer label">


                            <input v-model="donor.has_green_shield"
                                   type="checkbox"
                                   class="checkbox">

                            <span class="label-text ml-2">
                                {{ trans('has-green-shield') }}
                            </span>

                        </label>

                        <label class="label" v-if="errors.has_green_shield">
                            <span class="label-text-alt text-red-500">
                                {{ errors.has_green_shield }}
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
                        {{ trans('regiter') }}
                    </button>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

import datepicker from 'vue3-datepicker';
import * as $ from 'jquery';


import Multiselect from '@vueform/multiselect';

export default {

    props: {

        nationalities: [],

        cities: [],

        blood_groups: [],

        diseases: [],

        errors: [],

        current_campaign: Object,

        timings: [],

    },

    components: {

        datepicker,
        Multiselect,

    },

    data: function () {

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

                has_green_shield: false,
                last_travel_date: null,

                selected_time: null,


            }),

            genders: [
                {
                    key: 'male',
                    name_en: 'Male',
                    name_ar: 'ذكر'
                },
            ]

        };

    },

    mounted() {

        console.log(this.return_array_for_select(this.diseases, 'id', 'name'));

    },

    methods: {

        register: function () {

            this.donor.transform(data => ({

                ...data,

            }))
                .post(this.route('admin-donor-register'), {

                    onFinish: () => {

                        console.log("ttttt"+this.$page.props.flash?.toast?.status);
                        if (this.$page.props.flash?.toast?.status=='success'){
                            window.location.replace("/admin/donors/"+this.$page.props.flash?.toast?.message+"/print");
                        }

                        if (this.$page.props.flash?.toast?.status!='success'){

                            if (this.$page.props?.flash?.toast) {

                                this.$moshaToast(this.trans(this.$page.props.flash?.toast?.message), {

                                    type: this.$page.props.flash?.toast?.status,
                                    showIcon: true,
                                    hideProgressBar: true,


                                });

                            }
                        }



                    },

                    onSuccess: () => {

                        this.donor = {
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

                            has_green_shield: false,
                            last_travel_date: null,
                        };

                    },

                    onError: () => {

                    },

                });

        },


        fetch: function () {
            var x =this.donor;
            // axios.post('http://localhost:5050/api/operation/ReadCard', {
            //     "ReadCardInfo": false,
            //     "ReadPersonalInfo": false,
            //     "ReadAddressDetails": true,
            //     "ReadBiometrics": true,
            //     "ReadEmploymentInfo": false,
            //     "ReadImmigrationDetails": true,
            //     "ReadTrafficDetails": false,
            //     "SilentReading": false,
            //     "ReaderIndex": -1,
            //     "ReaderName": "",
            //     "OutputFormat": "JSON"
            // }, {
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'Access-Control-Allow-Origin': '*',
            //         'Access-Control-Allow-Methods': 'GET,HEAD,OPTIONS,POST,PUT',
            //         'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type,' +
            //             '    Accept, x-client-key, x-client-token, x-client-secret, Authorization',
            //     }
            // }).then((response) => {
            //     console.log(response);
            // })

            $.ajax({
                type: "POST",
                url: 'http://localhost:5050/api/operation/ReadCard',
                // dataType: "json",
                data: JSON.stringify(
                    {
                        "ReadCardInfo": false,
                        "ReadPersonalInfo": false,
                        "ReadAddressDetails": true,
                        "ReadBiometrics": true,
                        "ReadEmploymentInfo": false,
                        "ReadImmigrationDetails": true,
                        "ReadTrafficDetails": false,
                        "SilentReading": false,
                        "ReaderIndex": -1,
                        "ReaderName": "",
                        "OutputFormat": "JSON"
                    }),
                success: function (data) {
                    console.log(x);

                    x.name=data.ArabicFullName;
                    x.cpr=data.IdNumber;
                    x.birth_date= new Date(data.BirthDate);
                    x.nationality=data.MiscellaneousTextData.ArabicCountryName;
                    x.city=data.MiscellaneousTextData.BlockNameArabic;
                    x.gender="male";


                },
                error: function (xhr, tst, err) {

                }
            });
            this.donor=x;

        }

    },

    computed: {

        timings_for_select: function () {

            return Object.values(this.timings).map(x => {

                return {
                    value: x.time,
                    name: `${x.time} ${x.disabled ? '- ' + this.trans('not-available') : ''}`,
                    disabled: x.disabled,
                }

            });

        },

    },

}

</script>
<style src="@vueform/multiselect/themes/default.css"></style>
