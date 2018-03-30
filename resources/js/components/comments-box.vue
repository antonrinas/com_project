<template>
    <div id="comments_box">
        <template v-if="commentsLength === 0">
            <p>Комментарии отсутствуют</p>
        </template>

        <comments-list :comments="comments"></comments-list>

        <b-pagination
                v-if="commentsLength > 0"
                align="center"
                class="pagination_block"
                :total-rows="pagination.totalRows"
                v-model="pagination.page"
                :per-page="pagination.perPage"
                v-on:input="retrieveComments"
        ></b-pagination>

        <add-comment-form></add-comment-form>

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
    import addCommentForm from './add-comment-form.vue'
    import decodeValues from './../mixins/decode-values';
    import messanger from './messanger.vue';
    import bPagination from 'bootstrap-vue/es/components/pagination/pagination';

    export default {
        mixins: [decodeValues],
        components: {
            'comments-list': commentsList,
            'add-comment-form': addCommentForm,
            'b-pagination': bPagination,
            'messanger': messanger,
        },
        data(){
            return {
                comments: [],
                pagination: {
                    totalRows: null,
                    page: 1,
                    perPage: null,
                },
                message: {
                    title: null,
                    content: null,
                },
                showMessage: false,
                pusher: null,
            }
        },
        computed: {
            commentsLength: function () {
                return this.comments.length;
            }
        },
        beforeMount: function () {
            var vueInstance = this;
            //Pusher.logToConsole = true;
            this.pusher = new Pusher('cdb14d8667c152df38cb', {
                cluster: 'eu',
                encrypted: false
            });
            var channel = this.pusher.subscribe('comments');
            channel.bind('added', function(data) {
                vueInstance.commentAddedEventHandler(data);
            });
        },
        mounted: function () {
            axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
            this.retrieveComments();
        },
        methods: {
            isInList: function (id) {
                for (var i = 0; i < this.comments.length; i++) {
                    var currentComment = this.comments[i];
                    if (currentComment.id == id) {
                        return true;
                    }
                }
            },
            commentAddedEventHandler: function (data) {
                if (this.isInList(data.id)) {
                    return;
                }
                this.pagination.totalRows++;
                this.comments.unshift(this.decodeValues(data));
                if (this.commentsLength > this.pagination.perPage) {
                    this.comments.pop();
                }
            },
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
    #comments_box {
        margin-top: 2rem;
    }
    .pagination_block {
        margin: 1rem 0;
    }
</style>