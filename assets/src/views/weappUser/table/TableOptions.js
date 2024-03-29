/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
export const listQuery = (currentPage = 1, perPage = 10) => {
    return {
        currentPage: currentPage,
        perPage: perPage,
        filters: {
            nickname: undefined
        }
    }
}

export const searchKeys = () => {
    return ['id', 'nickname']
}

export const fields = () => {
    return [
        { label: 'ID', key: 'id', sortable: true, tdClass: 'align-middle' },
        {
            label: '昵称',
            key: 'nickname',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '头像',
            key: 'avatar',
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
