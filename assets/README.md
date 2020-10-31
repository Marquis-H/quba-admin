# vue-admin

## 項目運行
- 安裝依賴包
```
yarn install
```

- 編譯和開發運行
```
yarn run serve
```

- 編譯和打包文件
```
yarn run build
```

## 現有模塊
### 基礎模塊
- [x] Layout框架，Sidenav，Navbar，Footer
- [x] API MOCK
- [x] API 請求封裝
- [x] I18N
- [x] 路由封裝
- [x] Vuex封裝
- [x] 權限封裝
  
### 主要模塊
- [x] 登錄、登出
- [x] 儀錶板

## 開發計劃
### 模塊
- [ ] 後台用戶管理
- [ ] 個人資料
- [ ] 系統設定

### 組件
- [x] 上傳組件
- [ ] 編輯器組件
- [ ] 表單組件

## 使用vscode，需新增或修改.vscode/settings.json，統一代碼格式
```Json
{
    "javascript.format.insertSpaceAfterConstructor": true,
    // 对于.vue文件,关闭prettier,交给eslint fix
    "vetur.format.defaultFormatter.css": "none",
    // "vetur.format.defaultFormatter.html": "none",
    "vetur.format.defaultFormatter.js": "none",
    "vetur.format.defaultFormatter.less": "none",
    "vetur.format.defaultFormatter.postcss": "none",
    "vetur.format.defaultFormatter.scss": "none",
    "vetur.format.defaultFormatter.stylus": "stylus-supremacy",
    "vetur.format.defaultFormatter.ts": "none",
    "eslint.validate": [
        "javascript",
        "javascriptreact",
        {
            "language": "vue",
            "autoFix": true
        }
    ],
}
```
