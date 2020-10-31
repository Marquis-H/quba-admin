import { generatorFaker } from '@/utils'
import faker from 'faker'

const userMap = {
  'ROLE_ADMIN': {
    roles: ['ROLE_USER'],
    token: 'ROLE_USER',
    name: 'Marquis Hou'
  }
}

const profile = {
  username: 'admin',
  email: 'marquis@wizmacau.com',
  name: 'Marquis',
  language: 'zh_TW'
}

const userSchema = {
  id: '{{random.number}}',
  firstname: '{{name.findName}}',
  lastname: '{{name.findName}}',
  enabled: '{{random.boolean}}',
  username: '{{internet.userName}}',
  email: '{{internet.email}}',
  language: '',
  isSuperAdmin: '{{random.boolean}}',
  password: '',
  confirmPassword: '',
  roles: []
}
const userList = generatorFaker(userSchema, 100, 100)

export default {
  login: config => {
    var data = JSON.parse(config.body)
    if (data.username !== 'admin') {
      return {
        code: -1,
        message: '用户名或密码错误'
      }
    } else {
      return {
        code: 0,
        data: {
          token: userMap['ROLE_ADMIN'].token
        }
      }
    }
  },
  getUserInfo: _ => {
    const token = 'ROLE_ADMIN'
    if (userMap[token]) {
      return {
        code: 0,
        data: userMap[token]
      }
    } else {
      return {
        code: -1,
        message: 'Fail'
      }
    }
  },
  getProfile: _ => {
    return {
      code: 0,
      data: profile
    }
  },
  updateProfile: config => {
    var data = JSON.parse(config.body)
    return {
      code: 0,
      data: data
    }
  },
  updatePassword: config => {
    var data = JSON.parse(config.body)
    if (data.old === '123456') {
      return {
        code: 0,
        message: 'Success'
      }
    } else {
      return {
        code: -1,
        message: '当前密码不存在'
      }
    }
  },
  logout: _ => {
    return {
      code: 0,
      message: 'Success'
    }
  },
  getUserList: config => {
    return {
      code: 0,
      data: userList
    }
  },
  createUser: config => {
    var data = JSON.parse(config.body) // password
    return {
      code: 0,
      data: {
        id: faker.random.number(100, 100),
        firstname: data.firstname,
        lastname: data.lastname,
        enabled: data.enabled,
        isSuperAdmin: data.isSuperAdmin,
        username: data.username,
        email: data.email,
        roles: data.roles
      }
    }
  },
  updateUser: config => {
    var data = JSON.parse(config.body) // password、id
    return {
      code: 0,
      data: {
        id: data.id,
        firstname: data.firstname,
        lastname: data.lastname,
        enabled: data.enabled,
        username: data.username,
        email: data.email,
        isSuperAdmin: data.isSuperAdmin,
        roles: data.roles
      }
    }
  },
  deleteUser: config => {
    return {
      code: 0,
      message: 'Success'
    }
  }
}
