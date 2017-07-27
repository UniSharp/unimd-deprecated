<template>
  <div class="editor">
    <!-- header start -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">
            <i class="fa fa-file-o"></i>
            &nbsp;UniMD
          </a>

          <modeswitcher v-model="viewMode" @change="showMode"></modeswitcher>

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
          <a href="#" class="btn btn-primary navbar-btn" id="online-btn"><i class="fa fa-users"></i> 1 ONLINE</a>
        </ul>
      </div>
    </nav>
    <!-- header end -->

    <!-- header start -->
    <codemirror v-model="code" :options="editorOptions"></codemirror>
    <!-- header end -->

    <!-- header start -->
    <div class="configbar">
      <div class="cursor-info">
        Line 10, Column 8 - 30 Lines
      </div>
      <div class="pull-right config-items">
        <div class="config-item"><a href="#"><i class="fa fa-check"></i></a></div>
        <div class="config-item"><a href="#"><i class="fa fa-sun-o"></i></a></div>
        <div class="config-item">Tab Size: 4</div>
        <div class="btn-group dropup config-item">
          <a class="dropdown-toggle" data-toggle="dropdown">
            Sublime
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="#">Sublime</a></li>
            <li><a href="#">Emacs</a></li>
            <li><a href="#">Vim</a></li>
          </ul>
        </div>
        <div class="config-item"><a href="#"><i class="fa fa-wrench"></i></a></div>
        <div class="config-item">Length: 150</div>
      </div>
    </div>
    <!-- header end -->
  </div>
</template>

<script>
  export default {
    methods: {
      showMode() {
        // console.log(123);
        console.log(this.viewMode)
      }
    },
    mounted() {
      console.log('Editor mounted.')
    },
    data() {
      return {
        viewMode: "456",
        code: "Welcome to UniMD!\n\n## How we built this app:\n * Vue\n * Swoole\n * Laravel\n\n> Feel free to send pull requests!",
        editorOptions: {
          // codemirror options
          // tabSize: 4,
          mode: 'text/x-markdown',
          // theme: 'base16-dark',
          // // sublime、emacs、vim三种键位模式，支持你的不同操作习惯
          // keyMap: "sublime",
          // // 按键映射，比如Ctrl键映射autocomplete，autocomplete是hint代码提示事件
          // extraKeys: { "Ctrl": "autocomplete" },
          // // 代码折叠
          // foldGutter: true,
          // gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
          // // 选中文本自动高亮，及高亮方式
          // styleSelectedText: true,
          // highlightSelectionMatches: { showToken: /\w/, annotateScrollbar: true },
          // more codemirror config...
          // 如果有hint方面的配置，也应该出现在这里
        }
      }
    }
  }
</script>

<style>
  .navbar {
    margin-bottom: 0px;
  }
  #online-btn {
    margin-left: 20px;
    margin-right: 20px;
    text-transform: uppercase;
    font-weight: bold;
  }
  .CodeMirror {
    height: calc(100vh - 50px - 2px - 20px - 10px) !important;
    background-color: #444;
    color: white;
  }
  .configbar {
    background-color: #222;
    color: white;
    font-size: 8px;
    border-top: 1px solid #666;
    width: 100vw;
  }
  .cursor-info {
    padding: 5px 10px;
    display: inline-block;
  }
  .config-items {
    display: flex;
    flex-direction: row;
  }
  .config-item {
    cursor: pointer;
    padding: 5px 10px;
    border-left: 1px solid #666;
  }
  .config-item a {
    color: white;
  }
  .config-item a:hover {
    text-decoration: none;
  }
  .config-item .dropdown-menu {
    background-color: #222;
    min-width: 0px;
  }
  .config-item .dropdown-menu > li > a {
    color: white;
  }
</style>
