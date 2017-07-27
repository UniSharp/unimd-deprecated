<template>
  <div class="btn-group navbar-btn" role="group" aria-label="...">
    <a class="btn btn-default" @click="switchView('view')"><i class="fa fa-eye"></i></a>
    <a class="btn btn-default" @click="switchView('preview')"><i class="fa fa-columns"></i></a>
    <a class="btn btn-default" @click="switchView('edit')"><i class="fa fa-pencil"></i></a>
  </div>
</template>

<script>
  export default {
    props: {
      mode: String
    },
    // data() {
    //   return {
    //     mode_name: this.mode
    //   }
    // },
    methods: {
      switchView(new_mode_name) {
        this.$emit('change:mode', new_mode_name)
      }
    }
  }
</script>

<style>

</style>
