import Loading from './components/Loading'

window._ = require('lodash')
window.Vue = require('vue')
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

import router from './router'
import store from './store'
import Vue3TouchEvents from 'vue3-touch-events'

const app = Vue.createApp({
    el: '#app',
    components: {
        'App': {
            template:
                '<loading></loading>' +
                '<router-view></router-view>'
        },
    }
})

app.component('loading',Loading)
app.use(router)
app.use(store)
app.use(Vue3TouchEvents)
app.mount('#app')
