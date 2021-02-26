import localforage from 'localforage'
import config from '@/config/config'

const install = (Vue) => {
  localforage.config({
    driver: localforage.LOCALSTORAGE,
    name: config.appId,
    version: 1.0,
  })
  Vue.prototype.$localf = localforage
}
// Localforage

export default { install }
