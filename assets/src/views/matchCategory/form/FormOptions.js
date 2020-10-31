/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { invalid } from './Validator'

export const formData = {
    title: '',
    type: null,
    isOnline: false
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
        type: {
            label: '级别',
            placeholder: '请选择级别',
            invalid: invalid().invalidType,
            state: true,
            options: newOptions['types'],
            component: 'Select',
            required: true
        },
        isOnline: { label: '是否线上比赛', component: 'Switcher', required: false }
    }
}
