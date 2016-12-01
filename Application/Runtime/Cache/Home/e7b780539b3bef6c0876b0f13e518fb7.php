<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Fixed Top Navbar Example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-fixed-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	<!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/datadic/index.php"><?php echo ($headname); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/datadic/index.php">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">databases<span class="caret"></span></a>
              <ul class="dropdown-menu">
				<li><a href="<?php echo U('index/db_info',array('table_schema'=>C('evn.db1_name')));?>"><?php echo C('evn.db1_value');?></a></li>
				<li><a href="<?php echo U('index/db_info',array('table_schema'=>C('evn.db2_name')));?>"><?php echo C('evn.db2_value');?></a></li>
              </ul>
            </li>
			<li ><a href="<?php echo U('slow/index');?>">mysql(244)慢查询语句(1S)</a></li>
			<li ><a href="<?php echo U('slow/mongo_slow');?>">mongo(246)慢查询语句(1S)</a></li>
			<!-- <li ><a href="<?php echo U('ordertest/index');?>">订单二段提交测试</a></li> -->
          </ul>
		  <ul class="nav navbar-nav navbar-right hidden-sm">
            <li><a href="<?php echo U('index/validation_info');?>" onclick="">数据比对</a></li>
          </ul>
		  
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
		<div class="table-responsive">
            <table class="table table-bordered" style="word-break:break-all; word-wrap:break-all;">
              <thead>
				<tr>
					<th colspan="10" >247 explain分析结果</th>
				</tr>
				<tr>
					<td colspan="10"><?php echo ($s); ?></td>
				</tr>
                <tr>
                  <th>id</th>
                  <th>select_type</th>
				  <th>table</th>
                  <th>type</th>
				  <th>possible_key</th> 
                  <th>key</th>
				  <th>key_len</th>
				  <th>ref</th>
				  <th>rows</th>
				  <th>extra</th>
                </tr>
              </thead>
              <tbody>
				
				<?php if(is_array($res)): $k = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
                  <td  width="100">
					<?php echo ($k); ?>
				  </td>
                  <td  width="100"><?php echo ($vo["select_type"]); ?></td>
                  <td  width="50"><?php echo ($vo["table"]); ?></td>
				  <td  width="50"><?php echo ($vo["type"]); ?></td>
                  <td  width="200"><?php echo ($vo["possible_keys"]); ?></td>
				  <td  width="100"><?php echo ($vo["key"]); ?></td>
				  <td  width="50"><?php echo ($vo["key_len"]); ?></td>
				  <td  width="100"><?php echo ($vo["ref"]); ?></td>
				  <td  width="50"><?php echo ($vo["rows"]); ?></td>
				  <td  ><?php echo ($vo["extra"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </tbody>
            </table>
          </div>
      

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
	
  </body>