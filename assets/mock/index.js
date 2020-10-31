import Mock from 'mockjs'

// import UserApi from './user'
// import DashboardApi from './dashboard'
// import UploadApi from './upload'
import SettingApi from './setting'

// User
// Mock.mock(/\/api\/v1\/admin\/auth\/login_check/, 'post', UserApi.login)
// Mock.mock(/\/api\/v1\/admin\/user\/info\.*/, 'get', UserApi.getUserInfo)
// Mock.mock(/\/api\/v1\/admin\/auth\/logout/, 'post', UserApi.logout)

// User Manager
// Mock.mock(/\/api\/v1\/admin\/user\/list/, 'get', UserApi.getUserList)
// Mock.mock(/\/api\/v1\/admin\/user\/create/, 'post', UserApi.createUser)
// Mock.mock(/\/api\/v1\/admin\/user\/[0-9]+\/update/, 'post', UserApi.updateUser)
// Mock.mock(/\/api\/v1\/admin\/user\/[0-9]+\/delete/, 'post', UserApi.deleteUser)

// Profile
// Mock.mock(/\/api\/v1\/admin\/user\/get_profile/, 'get', UserApi.getProfile)
// Mock.mock(/\/api\/v1\/admin\/user\/update_profile/, 'post', UserApi.updateProfile)
// Mock.mock(/\/api\/v1\/admin\/user\/update_password/, 'post', UserApi.updatePassword)

// Setting
Mock.mock(/\/api\/v1\/admin\/setting\/info/, 'get', SettingApi.getSetting)
Mock.mock(/\/api\/v1\/admin\/setting\/update/, 'post', SettingApi.updateSetting)

// Dashboard
// Mock.mock(/\/api\/v1\/admin\/dashboard\/info\.*/, 'get', DashboardApi.getDashboardInfo)

// Upload
// Mock.mock(/\/api\/v1\/admin\/upload/, 'post', UploadApi.upload)

export default Mock
