<template>
  <div class="text-block">
    123
  </div>
</template>

<script>
  export default {
    mounted() {
      console.log('ok.')
    }
  }
</script>

<style scoped>
  .text-block {
    height: calc(100vh - 50px - 2px - 20px);
    background-color: #444;
    color: white;
  }
</style>
