import router from './router'
import store from './store'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

import { getToken } from '@/utils/auth'
import { getPageTitle } from '@/utils'
NProgress.configure({ showSpinner: false })

const whiteList = ['/login']

router.beforeEach(async (to, form, next) => {
  NProgress.start()
  document.title = getPageTitle(to.meta.title)
  // Token
  const hasToken = getToken()

  if (hasToken) { // 存在Token
    if (to.path === '/login') {
      next({ path: '/' })
      NProgress.done()
    } else {
      const hasRoles = store.getters.roles && store.getters.roles.length > 0
      if (hasRoles) {
        next()
      } else {
        try {
          const { roles } = await store.dispatch('user/getInfo')
          const accessRoutes = await store.dispatch('permission/generateRoutes', roles)
          // dynamically add accessible routes
          router.addRoutes(accessRoutes)
          next()
        } catch (error) {
          await store.dispatch('user/resetToken')
          next(`/login?redirect=${to.path}`)
          NProgress.done()
        }
      }
    }
  } else {
    if (whiteList.indexOf(to.path) !== -1) {
      const hasRoles = store.getters.roles && store.getters.roles.length > 0
      if (hasRoles) {
        const accessRoutes = await store.dispatch('permission/generateRoutes', hasRoles)
        router.addRoutes(accessRoutes)
        next()
      } else {
        next()
      }
    } else {
      next(`/login?redirect=${to.path}`)
      NProgress.done()
    }
  }
})

router.afterEach(() => {
  // finish progress bar
  NProgress.done()
})
