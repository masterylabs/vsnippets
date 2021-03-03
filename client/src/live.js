import Vue from 'vue'
import App from './live/Live.vue'
import store from './store'
import config from './config/config'
import vuetify from './plugins/vuetify'
import ml from './plugins/ml'

// plugins
import localforage from './plugins/localforage'
import VideoPlayer from './mods/video-player'

const modules = [VideoPlayer]

import dev from './plugins/dev'
console.log('dev plugin')
Vue.use(dev)

// plugins
Vue.use(localforage)
Vue.use(ml, { store, ...config, modules, config })

Vue.config.productionTip = false

new Vue({
  store,
  vuetify,
  render: (h) => h(App),
}).$mount('#app')
