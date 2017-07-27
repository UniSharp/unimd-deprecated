<template>
  <div class="btn-group navbar-btn" role="group" aria-label="...">
    <a class="btn btn-default" @click="switchView(mode.name)" v-for="mode in modes"><i :class="'fa fa-' + mode.icon"></i></a>
  </div>
</template>

<script>
  export default {
    props: {
      value: String
    },
    data() {
      return {
        modes: [
          {
            name: "view",
            icon: "eye"
          },
          {
            name: "preview",
            icon: "columns"
          },
          {
            name: "edit",
            icon: "pencil"
          }
        ]
      }
    },
    methods: {
      switchView(new_mode_name) {
        this.$emit('change').$emit('input', new_mode_name)
      }
    }
  }
</script>
