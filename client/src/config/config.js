const appId = 'masteryl'

const config = {
  appId,
  colors: {
    primary: '#39BF6F', //'#635BFF', // '#578CFF', // pp: 0070ba, stripe: 635BFF
    secondary: '#424242',
    accent: '#82B1FF',
    error: '#FF5252',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FFC107',
  },
}
let appEl = document.querySelector(`#${appId}`)
if (!appEl) appEl = document.querySelector(`#app`)

for (let k in appEl.dataset) {
  config[k] = appEl.dataset[k]
}

export default config
