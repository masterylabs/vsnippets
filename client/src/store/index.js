import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    player: {
      src:
        'https://player.vimeo.com/external/519422218.sd.mp4?s=abb64be0e34144a31ac14a2aa6450dc8fc217593&profile_id=165', // 'VzK8tWA3rNE', // '1O0yazhqaxs',
    },
    playerBranding: {
      logo: {},
    },
    endPoster: {},
    promoAlert: {},
    pauseBanner: {},
    extensions: {},
  },
  getters: {
    player(state) {
      return {
        ...state.player,
        ...state.playerBranding,
      }
    },
    playerBranding(state) {
      return state.playerBranding
    },
    endPoster(state) {
      return state.endPoster
    },
    promoAlert(state) {
      return state.promoAlert
    },
    pauseBanner(state) {
      return state.pauseBanner
    },
    extensions(state) {
      return state.extensions
    },
  },

  mutations: {
    SET_PLAYER_BRANDING(state, payload) {
      state.playerBranding = payload
    },
    SET_END_POSTER(state, payload) {
      state.endPoster = payload
    },
    SET_PROMO_ALERT(state, payload) {
      state.promoAlert = payload
    },
    SET_PAUSE_BANNER(state, payload) {
      state.pauseBanner = payload
    },
    SET_EXTENSIONS(state, payload) {
      state.extensions = payload
    },
  },
  // actions: {},
  modules: {},
})
