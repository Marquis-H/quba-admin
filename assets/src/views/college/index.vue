<template>
  <div>
    <h4 class="font-weight-bold py-2 mb-2">学院管理</h4>
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
import { getCollegeList, createCollege, updateCollege, deleteCollege } from '@/api/college'
import { listQuery, searchKeys, fields } from './table/TableOptions'
import { formData } from './form/FormOptions'
import { filterOptions } from './filter/FilterOptions'
const defaultSettings = require('../../settings.js')

export default {
  name: 'College',
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
      options: {}
    }
  },
  created () {
    this.getList()
  },
  methods: {
    getList () {
      getCollegeList(this.listQuery)
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
      this.userForm = row
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
      createCollege(this.userForm).then((result) => {
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
      updateCollege(id, this.userForm).then((result) => {
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
      deleteCollege(row.id, row).then((result) => {
        notify(defaultSettings.successAlert, 'Success', '删除成功')
        this.getList()
      }).catch((e) => {
        console.log(e)
      })
    }
  }
}
</script>
