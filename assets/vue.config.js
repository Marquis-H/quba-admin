const path = require("path")
const defaultSettings = require('./src/settings.js')

function resolve(dir) {
    return path.join(__dirname, dir)
}

const name = defaultSettings.title

module.exports = {
    transpileDependencies: [
        /\bvue-echarts\b/,
        /\bresize-detector\b/,
        /\bvue-c3\b/,
        /\bvue-masonry\b/,
        /\bvue-cropper\b/
    ],
    chainWebpack: config => {
        // Add "node_modules" alias
        config.resolve.alias
            .set('node_modules', path.join(__dirname, './node_modules'))

        // Disable "prefetch" plugin since it's not properly working in some browsers
        config.plugins
            .delete('prefetch')

        // Do not remove whitespaces
        config.module.rule('vue')
            .use('vue-loader')
            .loader('vue-loader')
            .tap(options => {
                options.compilerOptions.preserveWhitespace = true
                return options
            })
    },
    configureWebpack: {
        name: name,
        resolve: {
            alias: {
                '@': resolve('src')
            }
        }
    },
    devServer: {
        overlay: {
            warnings: false,
            errors: true
        },
        proxy: {
            [process.env.VUE_APP_BASE_API]: {
                target: `http://127.0.0.1/`,
                changeOrigin: true,
                pathRewrite: {
                    ['^' + process.env.VUE_APP_BASE_API]: ''
                }
            }
        }
    }
}