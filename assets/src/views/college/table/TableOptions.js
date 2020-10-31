/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
export const listQuery = () => {
    return {
        currentPage: 1,
        perPage: 20,
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
