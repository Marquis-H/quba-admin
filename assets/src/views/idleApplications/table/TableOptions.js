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
            label: '是否置顶',
            key: 'topAt',
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
            label: '类别',
            key: 'category',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '商品详情',
            key: 'description',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '状态',
            key: 'status',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '新旧程度',
            key: 'oldDeep',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '商品数量',
            key: 'number',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '原价',
            key: 'originalCost',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '现价',
            key: 'currentCost',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '联系方式',
            key: 'contactType',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '联系',
            key: 'contact',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '商品链接',
            key: 'originalUrl',
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
