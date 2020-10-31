/* eslint-disable space-before-function-paren */
/* eslint-disable indent */
import { required, email, requiredIf, sameAs, minLength } from 'vuelidate/lib/validators'

export const validator = () => {
    return {
        formData: {
            username: {
                required
            },
            name: {
                required
            },
            password: {
                required: requiredIf(function () {
                    return this.handleType && this.handleType === 'create'
                }),
                minLength: minLength(8)
            },
            email: {
                email
            },
            confirmPassword: {
                required: requiredIf(function () {
                    return this.formData.password
                }),
                sameAsPassword: sameAs('password')
            }
        }
    }
}

export const invalid = () => {
    return {
        invalidUsername(t) {
            if (!t.v.formData.username.required) {
                return t.$t('TITLE_REQUIRED')
            }
            return undefined
        },
        invalidName(t) {
            if (!t.v.formData.username.required) {
                return t.$t('TITLE_REQUIRED')
            }
            return undefined
        },
        invalidNewPassword(t) {
            if (!t.v.formData.password.required) {
                return t.$t('TITLE_REQUIRED')
            }
            if (!t.v.formData.password.minLength) {
                return '密码至少大于8位'
            }
            return undefined
        },
        invalidRepeatPassword(t) {
            if (!t.v.formData.confirmPassword.required) {
                return t.$t('TITLE_REQUIRED')
            }
            if (!t.v.formData.confirmPassword.sameAsPassword) {
                return '密码必须相同'
            }
            return undefined
        },
        invalidEmail(t) {
            if (!t.v.formData.email.email) {
                return '邮箱地址无效'
            }
            return undefined
        }
    }
}
