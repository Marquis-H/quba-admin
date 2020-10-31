const setting = {
  system: {
    name: '后台管理系统',
    logo: undefined
  },
  normal: {
    isGray: false
  }
}

export default {
  getSetting: config => {
    return {
      code: 0,
      data: setting
    }
  },
  updateSetting: config => {
    var data = JSON.parse(config.body)
    return {
      code: 0,
      data: data
    }
  }
}
