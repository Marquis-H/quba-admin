import Vue from 'vue'
import { i18n } from './common'

import App from './App.vue'
import router from './router'
import store from './store'

import BootstrapVue from 'bootstrap-vue'
import Notifications from 'vue-notification'
import globals from './globals'
import Popper from 'popper.js'
import { Vuelidate } from 'vuelidate'
import 'default-passive-events'

Vue.config.productionTip = false
Popper.Defaults.modifiers.computeStyle.gpuAcceleration = false
const isProduction = process.env.NODE_ENV === 'production'

Vue.use(BootstrapVue)
Vue.use(Notifications)
Vue.use(Vuelidate)
// Global RTL flag
Vue.mixin({
  data: globals
})

new Vue({
  router,
  store,
  i18n,
  render: h => h(App),
  performance: !isProduction,
  data: {
    sub: false
  }
}).$mount('#app')
