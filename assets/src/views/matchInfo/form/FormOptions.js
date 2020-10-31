/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { invalid } from './Validator'
import store from '../../../store'

export const formData = {
    title: '',
    onlineOffline: null, // 线上、线下
    type: null, // 级别
    tabs: null,
    endAt: null,
    peopleLimit: 0,
    qualificationLimit: '',
    files: [],
    urls: ''
}

export const formItem = (options) => {
    let newOptions = JSON.parse(JSON.stringify(options))
    return {
        title: {
            label: '名称',
            placeholder: '请填写名称',
            state: true,
            invalid: invalid().invalidTitle,
            component: 'Input',
            required: true
        },
        onlineOffline: {
            label: '线上、线下',
            placeholder: '请选择',
            options: newOptions['onlineOrOffline'],
            component: 'Select',
            required: true
        },
        type: {
            label: '级别',
            placeholder: '请选择级别',
            options: newOptions['types'],
            component: 'Select',
            required: true
        },
        tabs: {
            label: '类别',
            placeholder: '请选择类别',
            state: true,
            invalid: invalid().invalidTabs,
            options: newOptions['category'],
            component: 'Select',
            required: true
        },
        endAt: {
            label: '报名截止日期',
            component: 'DatePicker',
            invalid: invalid().invalidEndAt,
            state: true,
            required: true
        },
        peopleLimit: {
            label: '团队人数限制',
            component: 'Input',
            state: false,
            required: false,
            type: 'number'
        },
        qualificationLimit: {
            label: '参赛人员资格限制条件',
            component: 'Textarea',
            state: false,
            required: false
        },
        files: {
            label: '文件',
            component: 'SingleUploadFile',
            state: false,
            required: false,
            accept: 'image/png, image/gif, image/jpeg, application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            extensions: 'gif,jpg,jpeg,png,pdf,doc,docx',
            action: store.getters.setting.domain + '/api/v1/admin/upload/image'
        },
        urls: {
            label: '链接（请使用,将链接隔开）',
            placeholder: '请填写链接',
            state: false,
            component: 'Input',
            required: false
        }
    }
}
