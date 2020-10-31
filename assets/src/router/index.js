import Vue from 'vue'
import Router from 'vue-router'
import Layout from '@/layout/Layout'

Vue.use(Router)

/**
 * meta : {
    roles: ['admin','editor']    control the page roles (you can set multiple roles)
    title: 'title'               the name show in sidebar and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if set true, the page will no be cached(default is false)
    affix: true                  if set true, the tag will affix in the tags-view
    breadcrumb: false            if set false, the item will hidden in breadcrumb(default is true)
    activeMenu: '/example/list'  if set path, the sidebar will highlight the path you set
  }
 */

export const constantRoutes = [
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    meta: { title: 'TITLE_LOGIN' },
    hidden: true
  },
  {
    path: '/',
    component: Layout,
    redirect: '/dashboard',
    children: [
      {
        path: 'dashboard',
        component: () => import('@/views/dashboard/index'),
        name: 'Dashboard',
        meta: { title: 'TITLE_DASHBOARD', icon: 'ion ion-md-speedometer' }
      }
    ]
  },
  {
    path: '/banner',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/banner/index'),
        name: 'Banner',
        meta: { title: 'Banner', icon: 'ion ion-md-apps' }
      }
    ]
  },
  {
    path: '/page',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/page/index'),
        name: 'Page',
        meta: { title: '页面', icon: 'ion ion-md-apps' }
      }
    ]
  },
  {
    path: '/college',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/college/index'),
        name: 'College',
        meta: { title: '学院', icon: 'ion ion-md-apps' }
      }
    ]
  },
  {
    path: '/professional',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/professional/index'),
        name: 'Professional',
        meta: { title: '专业', icon: 'ion ion-md-apps' }
      }
    ]
  },
  {
    path: '/idle_category',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/idleCategory/index'),
        name: 'IdleCategory',
        meta: { title: '闲置分类', icon: 'ion ion-md-apps' }
      }
    ]
  },
  {
    path: '/idle_application',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/idleApplications/index'),
        name: 'IdleApplication',
        meta: { title: '二手闲置', icon: 'ion ion-md-apps' }
      }
    ]
  },
  {
    path: '/match_category',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/matchCategory/index'),
        name: 'MatchCategory',
        meta: { title: '比赛类别', icon: 'ion ion-md-apps' }
      }
    ]
  },
  {
    path: '/match_info',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/matchInfo/index'),
        name: 'MatchInfo',
        meta: { title: '比赛信息', icon: 'ion ion-md-apps' }
      }
    ]
  },
  {
    path: '/weapp_user',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/weappUser/index'),
        name: 'WeappUser',
        meta: { title: '小程序用户', icon: 'ion ion-md-people' }
      }
    ]
  },
  {
    path: '/user',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/user/index'),
        name: 'User',
        meta: { title: 'TITLE_USER_MANAGER', icon: 'ion ion-md-people' }
      }
    ]
  },
  {
    path: '/setting',
    component: Layout,
    children: [
      {
        path: 'index',
        name: 'Profile',
        component: () => import('@/views/setting/index'),
        meta: { title: 'TITLE_PROFILE' },
        hidden: true
      },
      {
        path: 'system',
        name: 'System',
        component: () => import('@/views/setting/system'),
        meta: { title: 'TITLE_SYSTEM_SETTING', icon: 'ion ion-md-hammer' }
      }
    ]
  }
]

export const asyncRoutes = [
  { path: '*', redirect: '/404', hidden: true }
]

const createRouter = () => new Router({
  mode: 'history',
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

const router = createRouter()

// eslint-disable-next-line space-before-function-paren
export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router
