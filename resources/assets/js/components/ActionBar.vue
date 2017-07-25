<template>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">
          <i class="fa fa-file-o"></i>
          &nbsp;UniMD
        </a>
        <div class="btn-group navbar-btn" role="group" aria-label="...">
          <button type="button" class="btn btn-default"><i class="fa fa-eye"></i></button>
          <button type="button" class="btn btn-default"><i class="fa fa-columns"></i></button>
          <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i></button>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </nav>
</template>

<script>
  export default {
    mounted() {
      console.log('ok.')
    }
  }
</script>

<style scoped>
  .navbar {
    margin-bottom: 0px;
  }
</style>
