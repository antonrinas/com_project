import Vue from 'vue';
import 'core-js/fn/promise';
import commentsBox from './components/comments-box.vue';
import bImg from 'bootstrap-vue/es/components/image/img';
window.Pusher = require('pusher-js');

const app = new Vue({
    data: {
        
    },
    components: {
        'comments-box': commentsBox,
        'b-img': bImg,
    },
}).$mount('#app');