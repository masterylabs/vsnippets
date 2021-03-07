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

// plugins
import localforage from './plugins/localforage'

// mods
import WpFullscreenBtn from './plugins/wp-fullscreen-btn'

import CardGrid from './mods/card-grid'
import DragAndDrop from './mods/drag-and-drop'
import DragSort from './mods/drag-sort'
import VideoTrimmer from './mods/video-trimmer'
import VideoPlayer from './mods/video-player'

// import DurationField from './mods/duration-field'
const modules = [
  //
  WpFullscreenBtn,
  CardGrid,
  DragAndDrop,
  DragSort,
  VideoTrimmer,
  VideoPlayer,
]

const mapModules = ['marketing', 'player_branding', 'extensions']

import dev from './plugins/dev'

Vue.use(dev)

// plugins
Vue.use(localforage)

// mods
Vue.use(VueClipboard)

Vue.use(views)
Vue.use(comps)
Vue.use(layouts)
Vue.use(ml, { store, ...config, modules, config, mapModules })

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: (h) => h(App),
}).$mount('#masteryl')
