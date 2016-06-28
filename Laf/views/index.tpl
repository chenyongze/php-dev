<{include file="header.tpl"}>
<!-- Header ends -->
<div class="content">

  	<!-- Sidebar -->
    <{include file="left.tpl"}>
    <!-- Sidebar ends -->

  	<!-- Main bar -->
  	<div class="mainbar">
      
	    <!-- Matter -->

	    <div class="matter">
        <div class="container">

          <div class="row">

            <div class="col-md-12">
              <!-- 获取配置信息 -->
                <{config_load file="../html/views/config/mis.conf" section="baseconfig"}>
              <div class="widget wgreen">
                
                <div class="widget-head">
                  <div class="pull-center">欢迎您</div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                  <div class="padd">
                    <img class="img-polaroid" src="http://liveuser-qa01.xuebadev.com/static/img/banner-bg.c3ed949.png" />
                  </div>
                </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
              </div>  

            </div>
            
          </div>

        </div>
		  </div>

		<!-- Matter ends -->

    </div>
   	
   <div class="clearfix"></div>
<{include file="footer.tpl"}>