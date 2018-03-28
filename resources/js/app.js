import Vue from 'vue';
import commentsBox from './components/comments-box.vue';

const app = new Vue({
    data: {
        
    },
    components: {
        'comments-box': commentsBox,
    },
    mounted: function () {
    },
    computed: {
    }
}).$mount('#app');