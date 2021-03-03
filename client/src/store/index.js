import Vue from 'vue'
import Vuex from 'vuex'
import stripPrefix from '@/helpers/strip-prefix'
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    player: {
      src: '1O0yazhqaxs',
    },
    playerBranding: {
      logo: {},
    },
    endPoster: {},
    promoAlert: {},
    pauseBanner: {},
  },
  getters: {
    player(state) {
      return {
        ...state.player,
        ...state.playerBranding,
      }
      // const logo = {
      //   src: state.playerBranding.logoSrc || '',
      //   href: state.playerBranding.logoHref || '',
      //   size: state.playerBranding.logoSize || '',
      //   position: state.playerBranding.logoPosition || '',
      //   opacity: state.playerBranding.logoOpacity || '',
      //   tile: state.playerBranding.logoTile ? true : false,
      // }

      // console.log('state tile', logo.tile)
      // return {
      //   ...state.player,
      //   ...stripPrefix(state.playerBranding, 'logo'),
      //   logo,
      // }
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
  },
  // actions: {},
  modules: {},
})
