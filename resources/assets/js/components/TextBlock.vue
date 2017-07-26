<template>
  <codemirror v-model="code" :options="editorOptions"></codemirror>
</template>

<script>
  export default {
    data () {
      return {
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
  .CodeMirror {
    height: calc(100vh - 50px - 2px - 20px - 10px) !important;
    background-color: #444;
    color: white;
  }
</style>
