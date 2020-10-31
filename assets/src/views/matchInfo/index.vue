<template>
  <div>
    <h4 class="font-weight-bold py-2 mb-2">比赛信息管理</h4>
    <list-filter
      :filters="listQuery.filters"
      @action="handleFilter"
      :filterOptions="filterOptions"
    />
    <b-btn
      variant="primary rounded-pill"
      class="d-block mb-3"
      @click="showUserCreateModal"
    >
      <span class="ion ion-md-add"></span>&nbsp;&nbsp;新增
    </b-btn>
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
          :category="category"
          :options="options"
          :fields="fields"
          :data="usersData"
          :currentPage="listQuery.currentPage"
          :perPage="listQuery.perPage"
          @edit="showUserEditModal"
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
    <!-- Form -->
    <form-modal
      :handleType="handleType"
      :options="options"
      :userForm.sync="userForm"
      ref="addEvent"
      @save="handleOperationUser"
    ></form-modal>
    <!-- / Form -->
  </div>
</template>

<style src="@/vendor/libs/sweet-modal-vue/sweet-modal-vue.scss" lang="scss"></style>
<script>
import ListFilter from './components/ListFilter'
import ListTable from './components/ListTable'
import FormModal from './components/FormModal'
import { notify } from '@/utils'
import { getMatchInfoList, createMatchInfo, updateMatchInfo, deleteMatchInfo } from '@/api/matchInfo'
import { getMatchCategoryItems } from '@/api/matchCategory'
import { listQuery, searchKeys, fields } from './table/TableOptions'
import { formData } from './form/FormOptions'
import { filterOptions } from './filter/FilterOptions'
const defaultSettings = require('../../settings.js')

export default {
  name: 'MatchCategory',
  components: {
    ListFilter,
    ListTable,
    FormModal
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
      userForm: formData,
      listQuery: listQuery(),
      filterOptions: filterOptions(),
      fields: fields(),
      originalUsersData: [],
      category: [],
      options: {
        'onlineOrOffline': [
          { value: null, text: '请选择' },
          { value: 1, text: '线上比赛' },
          { value: 0, text: '线下比赛' }
        ],
        'types': [
          { value: null, text: '请选择级别' },
          {
            text: '国家级',
            value: '1'
          },
          {
            text: '省级',
            value: '2'
          },
          {
            text: '市级',
            value: '3'
          },
          {
            text: '校级',
            value: '4'
          },
          {
            text: '院级',
            value: '5'
          }
        ],
        'category': [
          { value: null, text: '请选择类别' }
        ]
      }
    }
  },
  created () {
    this.getList()
  },
  watch: {
    'userForm.onlineOffline': function(n, o) {
      if (n !== o && this.userForm.type) {
        const data = (this.category[n][this.userForm.type] || []).filter((x) => { return x.value === this.userForm.tabs })
        if (data.length === 0) {
          this.userForm.tabs = null
        }
        this.options.category = [{ value: null, text: '请选择类别' }].concat(this.category[n][this.userForm.type] || [])
      }
    },
    'userForm.type': function(n, o) {
      if (n !== o && this.userForm.onlineOffline !== null) {
        const data = (this.category[this.userForm.onlineOffline][n] || []).filter((x) => { return x.value === this.userForm.tabs })
        if (data.length === 0) {
          this.userForm.tabs = null
        }
        this.options.category = [{ value: null, text: '请选择类别' }].concat(this.category[this.userForm.onlineOffline][n] || [])
      }
    }
  },
  methods: {
    getList () {
      getMatchInfoList(this.listQuery)
        .then(res => {
          this.usersData = res.data.items
          this.originalUsersData = res.data.items.slice(0)
        })
        .catch(e => {
          console.log(e)
        })
      getMatchCategoryItems().then(res => {
        this.category = res.data
      })
    },
    handleFilter () {
      this.getList()
    },
    showUserCreateModal () {
      // 新增标签
      this.userForm = formData
      this.handleType = 'create'
      this.$refs['addEvent'].$refs['form'].$v && this.$refs['addEvent'].$refs['form'].$v.$reset()
      this.$refs['addEvent'].$refs.userModal.show()
    },
    showUserEditModal (row) {
      // 編輯标签
      this.handleType = 'edit'
      var tabs = row.tabs
      var onlineOffline = tabs[0]
      var type = tabs[1]
      this.userForm = { ...row, onlineOffline, type, tabs: tabs[2] }

      this.$refs['addEvent'].$refs['form'].$v && this.$refs['addEvent'].$refs['form'].$v.$reset()
      this.$refs['addEvent'].$refs.userModal.show()
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
    handleOperationUser () {
      if (this.handleType === 'create') {
        this.handleCreateData()
      } else {
        this.handleUpdateData()
      }
    },
    // 保存标签
    handleCreateData () {
      var tabs = []
      tabs.push(this.userForm.onlineOffline)
      tabs.push(this.userForm.type)
      tabs.push(this.userForm.tabs)
      createMatchInfo({ ...this.userForm, tabs }).then((result) => {
        this.usersData.unshift(result.data)
        this.$refs['addEvent'].$refs.userModal.hide()
        notify(defaultSettings.successAlert, 'Success', '创建成功')
      }).catch((e) => {
        console.log(e)
      })
    },
    // 更新标签
    handleUpdateData () {
      const id = this.userForm.id
      var tabs = []
      tabs.push(this.userForm.onlineOffline)
      tabs.push(this.userForm.type)
      tabs.push(this.userForm.tabs)
      updateMatchInfo(id, { ...this.userForm, tabs }).then((result) => {
        this.userForm = result.data
        this.getList()
        this.$refs['addEvent'].$refs.userModal.hide()
        notify(defaultSettings.successAlert, 'Success', '更新成功')
      }).catch((e) => {
        console.log(e)
      })
    },
    // 删除标签
    handleDel (row) {
      deleteMatchInfo(row.id, row).then((result) => {
        notify(defaultSettings.successAlert, 'Success', '删除成功')
        this.getList()
      }).catch((e) => {
        console.log(e)
      })
    }
  }
}
</script>
