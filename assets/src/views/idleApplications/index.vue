<template>
  <div>
    <h4 class="font-weight-bold py-2 mb-2">二手闲置</h4>
    <list-filter
      :filters="listQuery.filters"
      @action="handleFilter"
      :filterOptions="filterOptions"
    />
    <b-card no-body>
      <b-card-body>
        <div class="row">
          <div class="col">
            <b-input
              size="sm"
              placeholder="搜寻..."
              class="d-inline-block w-auto float-sm-right"
              @input="filter($event)"
            />
          </div>
        </div>
      </b-card-body>
      <div class="table-responsive">
        <ListTable
          :options="options"
          :fields="fields"
          :data="usersData"
          :currentPage="listQuery.currentPage"
          :perPage="listQuery.perPage"
          @changeTop="handleChangeTop"
          @del="handleDel"
        />
      </div>
      <!-- Pagination -->
      <b-card-body class="pt-0 pb-3">
        <div class="row">
          <div class="col-sm text-sm-left text-center pt-3">
            <span class="text-muted" v-if="totalItems"
              >Page {{ listQuery.currentPage }} of {{ totalPages }}</span
            >
          </div>
          <div class="col-sm pt-3">
            <b-pagination
              class="justify-content-center justify-content-sm-end m-0"
              v-if="totalItems"
              v-model="listQuery.currentPage"
              :total-rows="totalItems"
              :per-page="listQuery.perPage"
              size="sm"
            />
          </div>
        </div>
      </b-card-body>
      <!-- / Pagination -->
    </b-card>
  </div>
</template>

<style src="@/vendor/libs/sweet-modal-vue/sweet-modal-vue.scss" lang="scss"></style>
<script>
import ListFilter from './components/ListFilter'
import ListTable from './components/ListTable'
import { getIdleApplicationList, deleteIdleApplication, changeTop } from '@/api/idleApplication'
import { listQuery, searchKeys, fields } from './table/TableOptions'
import { filterOptions } from './filter/FilterOptions'
import { notify } from '@/utils'
const defaultSettings = require('../../settings.js')

export default {
  name: 'MatchCategory',
  components: {
    ListFilter,
    ListTable
  },
  computed: {
    totalItems () {
      return this.usersData.length
    },
    totalPages () {
      return Math.ceil(this.totalItems / this.listQuery.perPage)
    }
  },
  data () {
    return {
      searchKeys: searchKeys(),
      handleType: 'create',
      usersData: [],
      listQuery: listQuery(),
      filterOptions: filterOptions(),
      fields: fields(),
      originalUsersData: [],
      category: [],
      options: {}
    }
  },
  created () {
    this.getList()
  },
  methods: {
    getList () {
      getIdleApplicationList(this.listQuery)
        .then(res => {
          this.usersData = res.data.items
          this.originalUsersData = res.data.items.slice(0)
        })
        .catch(e => {
          console.log(e)
        })
    },
    handleFilter () {
      this.getList()
    },
    filter (value) {
      const val = value.toLowerCase()
      const filtered = this.originalUsersData.filter(d => {
        return (
          Object.keys(d)
            .filter(k => this.searchKeys.includes(k))
            .map(k => String(d[k]))
            .join('|')
            .toLowerCase()
            .indexOf(val) !== -1 || !val
        )
      })
      this.usersData = filtered
    },
    handleChangeTop(id, isTop) {
      changeTop({ id, isTop }).then(res => {
        if (res.code === 0) { // 刷新页面
          var index = this.usersData.findIndex(v => v.id === id)
          this.usersData[index]['topAt'] = isTop
        }
      })
    },
    // 删除标签
    handleDel (row) {
      deleteIdleApplication(row.id, row).then((result) => {
        notify(defaultSettings.successAlert, 'Success', '删除成功')
        this.getList()
      }).catch((e) => {
        console.log(e)
      })
    }
  }
}
</script>
