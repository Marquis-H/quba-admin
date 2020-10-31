/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { invalid } from './Validator'

export const formData = {
    title: '',
    description: ''
}

export const formItem = (options) => {
    return {
        title: {
            label: '名称',
            placeholder: '请填写名称',
            state: true,
            invalid: invalid().invalidTitle,
            component: 'Input',
            required: true
        },
        description: {
            label: '说明',
            placeholder: '请填写说明',
            component: 'Textarea',
            state: false
        }
    }
}
