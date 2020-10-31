<template>
  <b-table
    :items="data"
    :fields="fields"
    :sort-by.sync="sortBy"
    :sort-desc.sync="sortDesc"
    :striped="true"
    :bordered="true"
    :current-page="currentPage"
    :per-page="perPage"
    responsive
    class="card-table"
  >
    <template slot="actions" slot-scope="data">
      <b-btn
        variant="default btn-xs icon-btn md-btn-flat"
        v-b-tooltip.hover
        title="編輯"
        @click="showUserEditModal(data.item)"
      >
        <i class="ion ion-md-create"></i>
      </b-btn>
      <b-dropdown
        variant="default btn-xs icon-btn md-btn-flat hide-arrow"
        :right="!isRTL"
      >
        <template slot="button-content">
          <i class="ion ion-ios-settings"></i>
        </template>
        <b-dropdown-item href="javascript:void(0)" @click="del(data.item)"
          >刪除</b-dropdown-item
        >
      </b-dropdown>
    </template>
  </b-table>
</template>

<script>
export default {
  name: 'user-table',
  data () {
    return {
      sortBy: 'id',
      sortDesc: false
    }
  },
  props: {
    fields: {
      type: Array
    },
    data: {
      type: Array
    },
    currentPage: {
      type: Number
    },
    perPage: {
      type: Number
    },
    options: {
      type: Object
    },
    category: {
      type: Array
    }
  },
  filters: {
    getText: function (value, type, options, category) {
      var data = ''
      data = data + options.onlineOrOffline.find(v => v.value === value[0]).text
      data = data + '-' + options.types.find(v => v.value === value[1]).text
      data = data + '-' + category[value[0]][value[1]].find(v => v.value === value[2]).text

      return data
    }
  },
  methods: {
    showUserEditModal (row) {
      this.$emit('edit', row)
    },
    del (row) {
      this.$swal({
        title: '是否删除',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: this.$t('TITLE_CONFIRM'),
        cancelButtonText: this.$t('TITLE_CANCEL'),
        confirmButtonColor: '#1cbb84',
        allowOutsideClick: false
      }).then((result) => {
        if (result.value) {
          this.$emit('del', row)
        }
      })
    }
  }
}
</script>
