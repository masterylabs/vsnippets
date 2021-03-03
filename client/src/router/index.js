import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../app/Home' // '../pages/Home'
import Snippet from '../app/Snippet'
import Branding from '../app/player-branding/PlayerBranding'
import Marketing from '../app/Marketing'

import Settings from '../app/settings/Settings'
// import TestPage from '../pages/TestPage'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/snippets/:id',
    name: 'video',
    component: Snippet,
  },
  {
    path: '/branding',
    name: 'branding',
    component: Branding,
  },
  {
    path: '/marketing',
    name: 'marketing',
    component: Marketing,
  },
  {
    path: '/settings',
    name: 'settings',
    component: Settings,
  },
]

const router = new VueRouter({
  routes,
})

export default router
