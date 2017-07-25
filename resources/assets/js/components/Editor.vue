<template>
  <codemirror v-model="code" :options="{}"></codemirror>
</template>

<script>
  export default {
    data () {
      return {
        code: "123"
      }
    }
  }
</script>

<style scoped>
  .CodeMirror {
    height: calc(100vh - 50px - 2px - 20px);
    background-color: #444;
    color: white;
  }
</style>
