<template>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">
          <i class="fa fa-file-o"></i>
          &nbsp;UniMD
        </a>
        <div class="btn-group navbar-btn" role="group" aria-label="...">
          <a class="btn btn-default"><i class="fa fa-eye"></i></a>
          <a class="btn btn-default"><i class="fa fa-columns"></i></a>
          <a class="btn btn-default"><i class="fa fa-pencil"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><i class="fa fa-question-circle"></i></a></li>
          <li><a href="#"><i class="fa fa-camera"></i></a></li>
        </ul>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><i class="fa fa-plus"></i> 新增</a></li>
        <li><a href="#"><i class="fa fa-share-alt"></i> 發表</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">選單 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">增益</li>
            <li><a href="#"><i class="fa fa-history"></i> 修訂版本</a></li>
            <li><a href="#"><i class="fa fa-television"></i> 簡報模式</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">匯出</li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">匯入</li>
            <li><a href="#"><i class="fa fa-github"></i> Gist</a></li>
            <li><a href="#"><i class="fa fa-clipboard"></i> 剪貼簿</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">下載</li>
            <li><a href="#"><i class="fa fa-file-text"></i> Markdown</a></li>
            <li><a href="#"><i class="fa fa-code"></i> HTML</a></li>
            <li><a href="#"><i class="fa fa-code"></i> 純 HTML</a></li>
            <li><a href="#"><i class="fa fa-file-pdf-o"></i> PDF (Beta)</a></li>
          </ul>
        </li>
        <a href="#" class="btn btn-primary btn-sm navbar-btn" id="online-btn"><i class="fa fa-users"><strong> 1 ONLINE</strong></i></a>
      </ul>
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
  #online-btn {
    margin-right: 20px;
  }
</style>
