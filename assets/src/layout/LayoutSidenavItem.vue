<template>
  <sidenav-router-link
    v-if="!item.hidden&&hasOneShowingChild(item.children,item) && (!onlyOneChild.children||onlyOneChild.noShowingChildren)&&!item.alwaysShow"
    :icon="onlyOneChild.meta.icon||(item.meta&&item.meta.icon)"
    :active="isMenuActive(this.onlyOne?onlyOneChild.path:item.path)"
    :open="isMenuOpen(this.onlyOne?onlyOneChild.path:item.path)"
    :to="resolvePath(onlyOneChild.path)"
    :exact="true"
  >{{$t(onlyOneChild.meta.title)}}</sidenav-router-link>
  <sidenav-menu
    v-else-if="!item.hidden"
    :icon="item.meta && item.meta.icon"
    :active="isMenuActive(item.path)"
    :open="isMenuOpen(item.path)"
  >
    <template slot="link-text">{{$t(item.meta.title)}}</template>
    <layout-sidenav-item
      v-for="child in item.children"
      :key="child.path"
      :item="child"
      :base-path="resolvePath(child.path)"
    />
  </sidenav-menu>
</template>

<script>
import path from 'path'
import { SidenavMenu, SidenavRouterLink } from '@/vendor/libs/sidenav'

export default {
  name: 'layout-sidenav-item',
  components: {
    SidenavRouterLink,
    SidenavMenu
  },
  props: {
    // route object
    item: {
      type: Object,
      required: true
    },
    isNest: {
      type: Boolean,
      default: false
    },
    basePath: {
      type: String,
      default: ''
    }
  },
  data () {
    this.onlyOneChild = null
    this.onlyOne = false
    return {}
  },
  methods: {
    hasOneShowingChild (children = [], parent) {
      const showingChildren = children.filter(item => {
        if (item.hidden) {
          return false
        } else {
          // Temp set(will be used if only has one showing child)
          this.onlyOneChild = item
          return true
        }
      })

      // When there is only one child router, the child router is displayed by default
      if (showingChildren.length === 1) {
        this.onlyOne = true
        return true
      }

      // Show parent if there are no child router to display
      if (showingChildren.length === 0) {
        this.onlyOneChild = { ...parent, path: '', noShowingChildren: true }
        return true
      }

      return false
    },
    resolvePath (routePath) {
      return path.resolve(this.basePath, routePath)
    },
    isMenuActive (url) {
      return this.$route.path.indexOf(url) === 0
    },

    isMenuOpen (url) {
      return this.$route.path.indexOf(url) === 0 && this.orientation !== 'horizontal'
    },

    toggleSidenav () {
      this.layoutHelpers.toggleCollapsed()
    }
  }
}
</script>
