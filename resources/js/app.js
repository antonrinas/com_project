import Vue from 'vue';
import 'core-js/fn/promise';
import commentsBox from './components/comments-box.vue';
window.Pusher = require('pusher-js');

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