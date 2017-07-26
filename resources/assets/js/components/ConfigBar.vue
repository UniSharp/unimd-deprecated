<template>
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
</template>

<script>
  export default {
    mounted() {
      console.log('Component mounted.')
    }
  }
</script>

<style>
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
