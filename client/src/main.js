import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import config from './config/config'
import vuetify from './plugins/vuetify'
import ml from './plugins/ml'
import views from './plugins/views'
import comps from './plugins/comps'
import layouts from './plugins/layouts'

// mods
import VueClipboard from 'vue-clipboard2'

// mods
import WpFullscreenBtn from './plugins/wp-fullscreen-btn'
import VideoSurvey from './mods/video-survey'
import Mplayer from './mods/mplayer'
import DragSort from './mods/drag-sort'
import VideoPlayer from './mods/video-player'
import VideoPlayerAdmin from './mods/video-player-admin'

const modules = [WpFullscreenBtn, Mplayer, VideoSurvey, DragSort, VideoPlayer, VideoPlayerAdmin]

import dev from './plugins/dev'
console.log('dev plugin')
Vue.use(dev)

// mods
Vue.use(VueClipboard)

Vue.use(views)
Vue.use(comps)
Vue.use(layouts)
Vue.use(ml, { store, ...config, modules, config })

Vue.config.productionTip = false

new Vue({
	router,
	store,
	vuetify,
	render: (h) => h(App),
}).$mount('#masteryl')
