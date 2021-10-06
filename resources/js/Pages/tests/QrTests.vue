<template>
    <div><qrcode-stream></qrcode-stream>
    </div>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';
import { QrcodeStream } from 'vue-qrcode-reader/'

export default defineComponent({
    name: 'QrStreamExample',
    components: {
        QrcodeStream,

    },
    setup() {
        const state = reactive({
            data: null
        })
        function onDecode(data) {
            state.data = data
        }
        return {
            ...toRefs(state),
            onDecode
        }
    }
});
</script>

<style scoped>
.stream {
    max-height: 500px;
    max-width: 500px;
    margin: auto;
}
</style>
