import { isEmpty } from 'lodash'

const start = function() {
  return this.api
    .get('app')
    .then(({ data }) => {
      data.ready = true
      this.setValues(data)
      this.started = true
      if (data.license) {
        this.store.dispatch('app/parseLicense')
      }

      this.loadModuleStates(data)
    })
    .catch((e) => {
      if (!this.api.isUrlAuth) {
        this.api.isUrlAuth = true
        return this.start()
      }

      this.addError(e.response)

      this.setValues({ noAuth: true })
    })
}

// automatically commit objects with SET_DATA mutation
const loadModuleStates = function(data) {
  for (const k in data) {
    const valid = typeof data[k] == 'object' && !isEmpty(data[k])
    if (!valid) continue

    const mut = `SET_${k.toUpperCase()}`
    if (this.store._mutations[mut]) {
      this.store.commit(mut, data[k])
    } else if (this.store._mutations[`${k}/SET_DATA`]) {
      this.store.commit(`${k}/SET_DATA`, data[k])
    }
  }
}

const remoteStart = function(options) {
  const url = typeof options == 'string' ? options : options.url
  return this.api
    .get(url)
    .then(({ data }) => {
      data.ready = true
      this.setValues(data)
      this.started = true
    })
    .catch((e) => {
      this.addError(e.response)
    })
}

const devStart = function(values = false) {
  if (!values) {
    values = {
      license: {
        valid: true,
        active: true,
        product: {
          name: 'Dev Started',
        },
      },
      ready: true,
    }
  }
  this.setValues(values)
}

const stop = function() {
  //
}

const updateLicense = function(form) {
  return this.api
    .post('/license', form)
    .then(({ data }) => {
      if (data.data) {
        this.setValues({ license: data.data })
        this.store.dispatch('app/parseLicense')
        this.success('License successfully updated!')
      }
    })
    .catch(({ response }) => {
      this.onErrorResponse(response)
      return false
    })
}

const upgrade = function() {
  return this.api
    .get('/upgrade')
    .then(({ data }) => {
      const upgrade = data.data

      if (window.location.href.indexOf('https://') < 0)
        upgrade.use_upgrade_dialog = false // never allow for unsecure

      if (!upgrade.width) upgrade.width = window.innerWidth - 40

      if (!upgrade.height) upgrade.height = window.innerHeight - 40

      this.store.dispatch('app/setProps', { upgrade })

      if (!upgrade.url || upgrade.use_upgrade_dialog) return

      window.open(
        upgrade.url,
        'UpgradeWindow',
        `toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=${upgrade.width},height=${upgrade.height}`
      )
    })
    .catch((e) => {
      this.onErrorResponse(e.response)
    })
}

export default {
  remoteStart,
  devStart,
  start,
  stop,
  updateLicense,
  upgrade,
  loadModuleStates,
}
