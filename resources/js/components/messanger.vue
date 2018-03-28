<template>
    <b-modal ref="myModal" v-bind:title="title" hide-footer v-on:hide="hideModal">
        <div class="modal-body">
            <p>{{ content }}</p>
        </div>
        <div class="modal-footer">
            <b-button v-on:click="hideModal" variant="outline-danger">Закрыть</b-button>
        </div>
    </b-modal>
</template>

<script>
    import bModal from 'bootstrap-vue/es/components/modal/modal';
    import bButton from 'bootstrap-vue/es/components/button/button';

    export default {
        props: ['showMessage', 'title', 'content'],
        components: {
            'b-modal': bModal,
            'b-button': bButton,
        },
        watch: {
            showMessage: function (value) {
                if (value === true){
                    this.$refs.myModal.show();
                } else {
                    this.$refs.myModal.hide();
                }
            },
        },
        methods: {
            hideModal: function() {
                this.$emit('hide', true);
            },
        },
    }
</script>

<style scoped>

</style>