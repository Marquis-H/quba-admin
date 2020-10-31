<template>
  <b-form-group
    :label="item.label"
    :invalid-feedback="this.item.invalid && this.item.invalid(this)"
  >
    <div slot="label" v-if="item.required">
      <i class="ion ion-ios-medical text-left text-danger"></i>
      {{ item.label }}
    </div>
    <component
      :is="item.component"
      :placeholder="item.placeholder"
      :value="value"
      :state="
        item.state && v.formData[name].$dirty ? !v.formData[name].$error : null
      "
      :options="item.options"
      :action="item.action"
      @onchage="onChage"
    />
  </b-form-group>
</template>

<script>
import CheckGroup from '../../../components/CheckGroup'
import Input from '../../../components/Input'
import Switcher from '../../../components/Switcher'
import Textarea from '../../../components/Textarea'
import Select from '../../../components/Select'
import MultiSelect from '../../../components/MultiSelect'
import Editor from '../../../components/Editor'
import UploadImages from '../../../components/UploadImages'

export default {
  name: 'form-item',
  components: {
    CheckGroup,
    Input,
    Switcher,
    Textarea,
    Select,
    MultiSelect,
    Editor,
    UploadImages
  },
  props: {
    name: String,
    value: [Number, String, Boolean, Array],
    item: Object,
    v: Object
  },
  methods: {
    onChage (val) {
      this.$emit('onchage', { name: this.name, val: val })
    }
  }
}
</script>>
