<template>
  <div class="config-item">
    <span @click="switchIndent" v-if="value.useTab">Tab Size</span>
    <span @click="switchIndent" v-if="!value.useTab">Spaces</span>
    :&nbsp;
    <span @click="startEditing" v-if="!is_editing">{{ value.spaces }}</span>
    <input @blur="finishEditing" ref="spaces_count" :value="value.spaces" type="text">
  </div>
</template>

<script>
  export default {
    props: {
      value: Object
    },
    data() {
      return {
        is_editing: false
      }
    },
    mounted () {
      this.$refs.spaces_count.hidden = true
    },
    methods: {
      switchIndent() {
        this.value.useTab = !this.value.useTab
        this.$emit('change').$emit('input', this.value)
      },
      startEditing() {
        this.is_editing = true
        this.$refs.spaces_count.hidden = false
        this.$refs.spaces_count.focus()
      },
      finishEditing() {
        this.is_editing = false
        this.$refs.spaces_count.hidden = true
        this.value.spaces = this.$refs.spaces_count.value
        this.$emit('change').$emit('input', this.value)
      }
    }
  }
</script>

<style>
  input {
    width: 20px;
    border-radius: 3px;
    background-color: #222;
    color: white;
    border: 1px solid #666;
  }
</style>
