<template>
  <div class="ui-bordered px-4 pt-4 mb-4">
    <div class="form-row align-items-center">
      <div class="col-md-4 mb-4" v-for="item in filterOptions" :key="item.value">
        <label class="form-label">{{item.label}}</label>
        <b-input v-model="filters[item.value]" />
      </div>
      <div class="col-md col-xl-2 mb-4">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <b-btn variant="secondary" :block="true" @click="handleSearch()">{{$t('TITLE_SEARCH')}}</b-btn>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'user-filter',
  props: {
    filters: {
      type: Object,
      default: function () {
        return {
          username: undefined
        }
      }
    },
    filterOptions: {
      type: Array,
      default: function () {
        return []
      }
    }
  },
  methods: {
    handleSearch () {
      this.$emit('action', this.filters)
    }
  }
}
</script>
