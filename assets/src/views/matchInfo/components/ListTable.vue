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
    <template slot="topAt" slot-scope="data">
      <span v-if="data.item.topAt">
        <b-btn
          variant="success"
          size="sm"
          :block="true"
          @click="changeTop(data.item.id, false)"
          >取消置顶</b-btn
        >
      </span>
      <span v-else>
        <b-btn
          variant="secondary"
          size="sm"
          :block="true"
          @click="changeTop(data.item.id, true)"
          >置顶</b-btn
        >
      </span>
    </template>
    <template slot="tabs" slot-scope="data">
      <span>{{ data.item.tabs | getText("tabs", options, category) }}</span>
    </template>
    <template slot="files" slot-scope="data">
      <a
        v-if="data.item.files.length > 0"
        :href="
          $store.getters.setting.domain +
          data.item.files[0]['response']['data']['file']
        "
        target="_blank"
        >文件</a
      >
      <span v-else>-</span>
    </template>
    <!-- 队伍 -->
    <template slot="team" slot-scope="data">
      <b-button size="sm" @click="data.toggleDetails" class="mr-2">
        {{ data.detailsShowing ? "关闭" : "查看" }}
      </b-button>
    </template>
    <template #row-details="data">
      <b-card no-body class="mb-1">
        <b-card-header header-tag="header" class="p-1" role="tab">
          <b-button block v-b-toggle.team-1 variant="info">队伍 1</b-button>
        </b-card-header>
        <b-collapse id="team-1" accordion="my-accordion" role="tabpanel">
          <b-card-body>
            <b-card-text></b-card-text>
            <b-card-text></b-card-text>
          </b-card-body>
        </b-collapse>
      </b-card>
    </template>
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
    },
    changeTop(id, isTop) {
      this.$emit('changeTop', id, isTop)
    }
  }
}
</script>
