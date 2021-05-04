<template>
  <div :style="styles">
    <div style="padding-bottom: 8px">
      <div v-for="(file, index) in inputVal" :key="index">
        <template v-if="Number(file.progress) == 100">
          <a
            :href="$store.getters.setting.domain + file.response.data.file"
            target="_blank"
            >查看文件</a
          >
          <i
            @click.prevent="$refs.upload.remove(file)"
            class="fa fa-minus-square pl-2 text-danger"
          ></i>
        </template>
        <template v-else>
          <b-progress :value="Number(file.progress)" height="0.75rem" />
        </template>
      </div>
    </div>
    <file-upload
      :class="componentClass"
      :post-action="action"
      :extensions="extensions"
      :accept="accept"
      :size="size"
      :multiple="true"
      v-model="inputVal"
      @input-filter="inputFilter"
      @input-file="inputFile"
      ref="upload"
    >
      <i class="fa fa-plus"></i>
      <span v-if="inputVal.length == 0">选择文件</span>
      <span v-else>添加文件</span>
    </file-upload>
    <div class="tips">支持上传文件：{{ accept }}</div>
  </div>
</template>

<script>
import VueUploadComponent from 'vue-upload-component'

export default {
  name: 'upload-images',
  props: {
    styles: String,
    accept: {
      type: String,
      default: 'image/png, image/gif, image/jpeg, image/webp'
    },
    extensions: {
      type: String,
      default: 'gif,jpg,jpeg,png,webp'
    },
    size: {
      type: Number,
      default: 1024 * 1024 * 10
    },
    componentClass: {
      type: String,
      default: 'btn btn-primary'
    },
    action: {
      type: String,
      required: true
    },
    value: {
      type: Array,
      required: true
    }
  },
  components: {
    FileUpload: VueUploadComponent
  },
  computed: {
    inputVal: {
      get () {
        return this.value
      },
      set (val) {
        this.$emit('onchage', val)
      }
    }
  },
  data () {
    return {}
  },
  methods: {
    inputFilter (newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Before adding a file
        // 添加文件前
        // Filter system files or hide files
        // 过滤系统文件 和隐藏文件
        if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
          return prevent()
        }
        // Filter php html js file
        // 过滤 php html js 文件
        if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
          return prevent()
        }
      }
    },
    inputFile (newFile, oldFile) {
      if (newFile && !oldFile) {
        // add
        console.log('add', newFile)
      }
      if (newFile && oldFile) {
        // update
        console.log('update', newFile)
      }
      if (!newFile && oldFile) {
        // remove
        console.log('remove', oldFile)
      }
      if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
        if (!this.$refs.upload.active) {
          this.$refs.upload.active = true
        }
      }
    }
  }
}
</script>

<style>
.tips{
  margin-top: 5px
}
</style>
