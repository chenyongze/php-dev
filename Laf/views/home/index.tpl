<{include file="header.tpl"}>
<!-- Header ends -->

<!-- Main content starts -->

<div class="content">

    <!-- Sidebar -->
    <{include file="left.tpl"}>
    <!-- Sidebar ends -->
    <!-- Main bar -->
    <div class="mainbar">
        <div class="container">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>title</th>
                      <th>content</th>
                      <th>操作</th>
                  </tr>
                  </thead>
                  <tbody>
                  <{foreach from=$list key=eachIndex item=eachValue}>
                  <tr>
                      <td><a><{$eachValue.id}></a></td>
                      <td><a><{$eachValue.title}></a></td>
                      <td><a><{$eachValue.content|default:"－－"}></a></td>
                      <td>
                          <a href="#"> 详情 </a>
                      </td>
                  </tr>
                  <{/foreach}>
                  </tbody>
              </table>


          </div>
    </div>
    <!-- Mainbar ends -->
    <div class="clearfix"></div>
</div>
<!-- Content ends -->

<!-- body starts -->
<{include file="footer.tpl"}>
<script src="/js/bootstrap-paginator.js"></script>
<script src="/js/common.js"></script>
<script>

</script>
