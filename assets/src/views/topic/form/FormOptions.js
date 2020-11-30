/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { invalid } from './Validator'
import store from '../../../store'

export const formData = {
    category: null,
    title: '',
    content: null,
    isEnable: true,
    photos: []
}

export const formItem = (options) => {
    let newOptions = JSON.parse(JSON.stringify(options))
    return {
        isEnable: { label: '启用', component: 'Switcher', required: false },
        category: {
            label: '类别',
            placeholder: '请选择类别',
            state: true,
            invalid: invalid().invalidCategory,
            options: newOptions['category'],
            component: 'Select',
            required: true
        },
        title: {
            label: '名称',
            placeholder: '请填写名称',
            state: true,
            invalid: invalid().invalidTitle,
            component: 'Input',
            required: true
        },
        content: {
            label: '内容',
            component: 'Textarea',
            state: false,
            required: false
        },
        photos: {
            label: '图片',
            state: false,
            component: 'UploadImages',
            action: store.getters.setting.domain + '/api/v1/admin/upload/image',
            required: false
        }
    }
}
