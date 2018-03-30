<template>
    <div>
        <b-card class="comment" v-for="comment in comments" :key="comment.id">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="mt-0">{{ comment.user_name }}</h5>
                    <p v-html="comment.content"></p>
                </div>
                <div class="col-md-2">
                    {{ comment.created_at }}
                </div>
            </div>
        </b-card>
    </div>
</template>

<script>
    import bCard from 'bootstrap-vue/es/components/card/card';

    export default {
        props: ['comments'],
        components: {
            'b-card': bCard,
        },
    }
</script>

<style scoped>
    .comment {
        margin-top: 0.5rem;
    }
    .comment:last-of-type {
        margin-bottom: 0.5rem;
    }
</style>