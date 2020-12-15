<template>
  <div>
    <h4 class="font-weight-bold py-2 mb-2">小程序用户管理</h4>
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
          :fields="fields"
          :data="usersData"
          :currentPage="listQuery.currentPage"
          :perPage="listQuery.perPage"
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
              @change="handleFilter()"
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
import { getWeappUserList } from '@/api/weappUser'
import { listQuery, searchKeys, fields } from './table/TableOptions'
import { filterOptions } from './filter/FilterOptions'

export default {
  name: 'WeappUser',
  components: {
    ListFilter,
    ListTable
  },
  computed: {
    totalPages () {
      return Math.ceil(this.totalItems / this.listQuery.perPage)
    }
  },
  watch: {
    'listQuery.currentPage': function(v) {
      this.getList()
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
      options: {},
      totalItems: 0
    }
  },
  created () {
    this.getList()
  },
  methods: {
    getList () {
      getWeappUserList(this.listQuery)
        .then(res => {
          this.usersData = res.data.items
          this.totalItems = res.data.total
          const listQuery = {
            currentPage: res.data.currentPage,
            perPage: res.data.perPage
          }
          this.listQuery = {
            ...this.listQuery,
            ...listQuery
          }
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
    }
  }
}
</script>
