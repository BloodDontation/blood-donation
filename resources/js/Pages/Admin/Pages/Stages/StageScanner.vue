<template>
    <div>
        <p class="decode-result">stage: {{ name }}</p><br>
        <p class="decode-result">Last result: <b>{{ result }}</b></p>

        <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit">
            <div v-if="validationSuccess" class="validation-success">
                {{ this.msg }}
            </div>

            <div v-if="validationFailure" class="validation-failure">
                هناك مشكلة، الرجاء التأكد من المراحل السابقة
            </div>

            <div v-if="validationPending" class="validation-pending">
                قيد التحقق...
            </div>
        </qrcode-stream>

        <input type="text" v-model="cpr">
        <button v-on:click="submit" class="btn">check</button>
    </div>

</template>

<script>

import {QrcodeStream} from 'vue3-qrcode-reader';
import Login from "@/Pages/Auth/Login";


export default {

    components: {QrcodeStream},


    data() {
        return {
            isValid: undefined,
            camera: 'auto',
            result: null,
            flag: '',
            msg: '',
            cpr: ''
        }
    },
    props: {

        id: '',
        name: '',

    },
    computed: {
        validationPending() {
            return this.isValid === undefined
                && this.camera === 'off'
        },

        validationSuccess() {
            return this.isValid === true
        },

        validationFailure() {
            return this.isValid === false
        }
    },

    methods: {

        onInit(promise) {
            promise
                .catch(console.error)
                .then(this.resetValidationState);
        },

        resetValidationState() {
            this.isValid = undefined
        },

        async onDecode(content) {
            this.result = content
            this.turnCameraOff()

            // pretend it's taking really long
            this.resetValidationState();
            axios.get('/admin/stages/insert-donor?cpr=' + this.result + '&stage_id=' + this.id, {}).then((response) => {
                const val = response.data;
                let msg = '';
                if (val === 'Inserted') {
                    msg = "تم الإدخال بنجاح";
                } else if (val === 'Completed') {
                    msg = "تم الإنتهاء من جميع المراحل، شكرا";
                } else if (val === 'Exit') {
                    msg = 'هناك مشكلة، الرجاء التأكد من المراحل السابقة';
                }
                alert(msg);

            });
            // some more delay, so users have time to read the message
            await this.timeout(3000);

            this.turnCameraOn()
        },

        async submit() {
            this.result = this.cpr;
            this.turnCameraOff()

            // pretend it's taking really long
            this.resetValidationState();
            axios.get('/admin/stages/insert-donor?cpr=' + this.result + '&stage_id=' + this.id, {}).then((response) => {
                const val = response.data;
                let msg = '';
                if (val === 'Inserted') {
                    msg = "تم الإدخال بنجاح";
                } else if (val === 'Completed') {
                    msg = "تم الإنتهاء من جميع المراحل، شكرا";
                } else if (val === 'Exit') {
                    msg = 'هناك مشكلة، الرجاء التأكد من المراحل السابقة';
                }
                alert(msg);

            });
            // some more delay, so users have time to read the message
            await this.timeout(3000);

            this.turnCameraOn()
        },

        turnCameraOn() {
            this.camera = 'auto'
        },

        turnCameraOff() {
            this.camera = 'off'
        },

        timeout(ms) {
            return new Promise(resolve => {
                window.setTimeout(resolve, ms)
            })
        }
    }
}
</script>

<style scoped>
.validation-success,
.validation-failure,
.validation-pending {
    position: absolute;
    width: 100%;
    height: 100%;

    background-color: rgba(255, 255, 255, .8);
    text-align: center;
    font-weight: bold;
    font-size: 1.4rem;
    padding: 10px;

    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
}

.validation-success {
    color: green;
}

.validation-failure {
    color: red;
}
</style>
