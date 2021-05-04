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
            label: '封面',
            key: 'cover',
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
            label: '标签',
            key: 'tabs',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '报名截止日期',
            key: 'endAt',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '团队人数限制',
            key: 'peopleLimit',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '文件',
            key: 'files',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '链接',
            key: 'urls',
            sortable: true,
            tdClass: 'align-middle'
        },
        {
            label: '队伍',
            key: 'team',
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
