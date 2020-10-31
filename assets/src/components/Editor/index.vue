<template>
  <quill-editor
    v-model="inputVal"
    :options="editorOptions"
    :class="state? 'is-invalid': 'is-valid'"
  ></quill-editor>
</template>

<script>

export default {
  name: 'form-type',
  props: {
    value: String,
    placeholder: String,
    type: String,
    state: Boolean
  },
  components: {
    quillEditor: () => import('vue-quill-editor/dist/vue-quill-editor').then(m => m.quillEditor).catch(() => { })
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
  data() {
    return {
      editorOptions: {
        placeholder: this.placeholder,
        modules: {
          toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }, { 'font': [] }, { 'size': [] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            ['blockquote', 'code-block'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }, { 'align': [] }],
            // ['link', 'image', 'video'],
            ['link'],
            ['clean']
          ]
        }
      }
    }
  }
}
</script>

<style src="@/vendor/libs/vue-quill-editor/typography.scss" lang="scss"></style>
<style src="@/vendor/libs/vue-quill-editor/editor.scss" lang="scss"></style>

<style>
.ql-editor.ql-blank::before{
  font-style: inherit;
}
</style>>
