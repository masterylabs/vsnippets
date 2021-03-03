import theme from './theme'
const appId = 'masteryl'
const config = {
  appId,
  colors: theme.colors,
}
let appEl = document.querySelector(`#${appId}`)
if (!appEl) appEl = document.querySelector(`#app`)

for (let k in appEl.dataset) {
  config[k] = appEl.dataset[k]
}

const getBaseUrl = (url) => {
  const i = url.split('/')
  i.pop()
  return i.join('/')
}

if (config.route) config.baseUrl = getBaseUrl(config.route)

export default config

export const textFieldAttrs = {
  outlined: true,
  hideDetails: true,
  class: 'mb-5',
}
