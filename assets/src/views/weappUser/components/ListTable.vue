<template>
  <b-table
    :items="data"
    :fields="fields"
    :sort-by.sync="sortBy"
    :sort-desc.sync="sortDesc"
    :striped="true"
    :bordered="true"
    responsive
    class="card-table"
  >
    <template slot="avatar" slot-scope="data">
      <img width="60" :src="data.item.avatar" />
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
