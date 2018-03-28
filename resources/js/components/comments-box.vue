<template>
    <div>
        <comments-list :comments="comments"></comments-list>

        <b-pagination
                v-if="comments.length > 0"
                align="center"
                class="pagination_block"
                :total-rows="pagination.totalRows"
                v-model="pagination.page"
                :per-page="pagination.perPage"
                v-on:input="retrieveComments"
        ></b-pagination>

        <messanger
                v-bind:show-message="showMessage"
                v-bind:title="message.title"
                v-bind:content="message.content"
                v-on:hide="showMessage = false"
        ></messanger>
    </div>
</template>

<script>
    import commentsList from './comments-list.vue';
    import decodeValues from './../mixins/decode-values';
    import messanger from './messanger.vue';
    import bPagination from 'bootstrap-vue/es/components/pagination/pagination';

    export default {
        props: [],
        mixins: [decodeValues],
        components: {
            'comments-list': commentsList,
            'b-pagination': bPagination,
            'messanger': messanger,
        },
        data(){
            return {
                comments: [],
                pagination: {
                    totalRows: null,
                    page: 1,
                    perPage: 1,
                },
                message: {
                    title: null,
                    content: null,
                },
                showMessage: false,
            }
        },
        mounted: function () {
            this.retrieveComments();
        },
        methods: {
            retrieveComments: function () {
                var vueInstance = this;
                axios.get('/api/comments', {
                    params: {
                        page: vueInstance.pagination.page,
                    }
                }).then(function (response) {
                    if (response.status === 200){
                        vueInstance.comments = vueInstance.decodeValues(response.data.data);
                        vueInstance.pagination.totalRows = parseInt(response.data.total_rows);
                        vueInstance.pagination.perPage = parseInt(response.data.per_page);
                    } else {
                        vueInstance.makeMessage('Ошибка', response.data.message);
                        console.log('Возникла ошибка ' + response.status + ': ' + response.data.message_for_developer);
                    }
                }).catch(function (error) {
                    vueInstance.makeMessage('Ошибка', 'Ошибка выполнения запроса');
                    console.log(error);
                });
            },
            makeMessage: function(title, message) {
                this.message.title = title;
                this.message.content = message;
                this.showMessage = true;
            },
        },
    }
</script>

<style scoped>
    .pagination_block {
        margin: 1rem 0;
    }
</style>