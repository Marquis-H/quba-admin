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
            label: '是否开启',
            key: 'isEnable',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '类型',
            key: 'category',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '名称',
            key: 'title',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '内容',
            key: 'content',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '图片',
            key: 'photos',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: 'Like',
            key: 'like',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '查看',
            key: 'views',
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
