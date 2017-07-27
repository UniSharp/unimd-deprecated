<template>
  <div class="btn-group dropup config-item">
    <a class="dropdown-toggle" data-toggle="dropdown">
      {{ value }}
    </a>
    <ul class="dropdown-menu dropdown-menu-right">
      <li v-for="mode in modes"><a href="#" @click="switchKeyMap(mode)">{{ mode }}</a></li>
    </ul>
  </div>
</template>

<script>
  export default {
    props: {
      value: String
    },
    data () {
      return {
        modes: ['sublime', 'emacs', 'vim', 'default']
      }
    },
    methods: {
      switchKeyMap(new_mode_name) {
        this.$emit('input', new_mode_name)
        this.$emit('change')
      }
    }
  }
</script>

<style>
  .dropup > a, .dropup > .dropdown-menu > li > a {
    text-transform: capitalize;
  }
</style>
