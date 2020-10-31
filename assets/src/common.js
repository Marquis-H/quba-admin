import Vue from 'vue'
import VueI18n from 'vue-i18n'
import locales from '@/locales'
import VueSweetalert2 from 'vue-sweetalert2'
import VJsoneditor from 'v-jsoneditor'

import '../mock'
import './permission'

Vue.use(VueI18n)
Vue.use(VueSweetalert2)
Vue.use(VJsoneditor)

const defaultLanguage = 'zhHant'

export const i18n = new VueI18n({
  locale: defaultLanguage,
  fallbackLocale: defaultLanguage,
  messages: locales,
  silentTranslationWarn: true
})
