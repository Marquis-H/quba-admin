/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
export const listQuery = (currentPage = 1, perPage = 10) => {
    return {
        currentPage: currentPage,
        perPage: perPage,
        filters: {
            title: undefined
        }
    }
}

export const searchKeys = () => {
    return ['id', 'title']
}

export const fields = () => {
    return [
        { label: 'ID', key: 'id', sortable: true, tdClass: 'align-middle' },
        {
            label: '名称',
            key: 'title',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '说明',
            key: 'description',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '学院',
            key: 'college',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '创建时间',
            key: 'createdAt',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            key: 'actions',
            label: ' ',
            tdClass: 'text-nowrap align-middle text-center'
        }
    ]
}
