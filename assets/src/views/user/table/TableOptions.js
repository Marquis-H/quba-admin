/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
export const listQuery = () => {
    return {
        currentPage: 1,
        perPage: 20,
        filters: {
            username: undefined
        }
    }
}

export const searchKeys = () => {
    return ['id', 'username', 'email', 'name']
}

export const fields = () => {
    return [
        { label: 'ID', key: 'id', sortable: true, tdClass: 'align-middle' },
        {
            label: '啟用',
            key: 'enabled',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '賬戶',
            key: 'username',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '姓名',
            key: 'name',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '電郵',
            key: 'email',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '最後登錄',
            key: 'lastLogin',
            sortable: true,
            tdClass: 'align-middle',
            thStyle: {
                minWidth: '110px'
            }
        },
        {
            key: 'actions',
            label: ' ',
            tdClass: 'text-nowrap align-middle text-center'
        }
    ]
}
