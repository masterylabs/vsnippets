import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../app/Home' // '../pages/Home'
import Snippet from '../app/Snippet'

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
    path: '/videos/:id',
    name: 'video',
    component: Snippet,
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
