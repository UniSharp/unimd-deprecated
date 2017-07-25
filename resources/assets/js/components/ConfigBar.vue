<template>
  <div class="configbar">
    This is footer.
  </div>
</template>

<script>
  export default {
    mounted() {
      console.log('Component mounted.')
    }
  }
</script>

<style scoped>
  .configbar {
    height: 20px;
    background-color: #222;
    font-size: 10px;
    color: white;
    padding: 2px;
  }
</style>
