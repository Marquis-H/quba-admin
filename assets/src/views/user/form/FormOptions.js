/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { invalid } from './Validator'

export const formData = {
    enabled: true,
    isSuperAdmin: true,
    name: '',
    username: '',
    email: '',
    password: '',
    confirmPassword: '',
    roles: []
}

export const formItem = (options) => {
    let newOptions = JSON.parse(JSON.stringify(options))
    console.log(newOptions)
    return {
        enabled: { label: '启用', component: 'Switcher', required: false },
        isSuperAdmin: { label: '超级管理员', component: 'Switcher', required: false },
        username: {
            label: '用户名',
            placeholder: '请填写用户名',
            state: true,
            invalid: invalid().invalidUsername,
            component: 'Input',
            required: true
        },
        name: {
            label: '姓名',
            placeholder: '请填写姓名',
            component: 'Input',
            state: true,
            invalid: invalid().invalidUsername,
            required: true
        },
        email: {
            label: '电邮',
            placeholder: '请填写电邮',
            state: true,
            invalid: invalid().invalidEmail,
            component: 'Input',
            required: false
        },
        password: {
            label: '密码',
            placeholder: '请填写密码',
            state: true,
            invalid: invalid().invalidNewPassword,
            component: 'Input',
            required: false,
            type: 'password'
        },
        confirmPassword: {
            label: '确认密码',
            placeholder: '请填写确认密码',
            state: true,
            invalid: invalid().invalidRepeatPassword,
            component: 'Input',
            required: false,
            type: 'password'
        },
        roles: {
            label: '权限',
            options: [
                {
                    text: '管理员',
                    value: 'ROLE_ADMIN'
                },
                {
                    text: '评审',
                    value: 'ROLE_REVIEW'
                }
            ],
            component: 'CheckGroup',
            required: false
        }
    }
}
