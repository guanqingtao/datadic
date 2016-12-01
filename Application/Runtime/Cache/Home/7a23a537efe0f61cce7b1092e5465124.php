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
		<table class="table table-bordered ">
			<tr class="active">
				<td colspan="7" style="text-align:center;">
					<h3><?php echo ($table_info['table_name']); ?>[db:<?php echo ($table_info['table_schema']); ?>]</h3>
					<p class="text-right">
						<a href="<?php echo U('index/table_sync',array('table_id'=>$table_info['id']));?>" type="button" class="btn btn-default">结构同步</a>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" >额外说明</button>
						<a href="<?php echo U('index/table_edit',array('table_id'=>$table_info['id']));?>" type="button" class="btn btn-default">编辑</a>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="1">表名称:</td>
				<td colspan="3" class="table_name"><?php echo ($table_info['table_name']); ?></td>
				<td colspan="1">含义:</td>
				<td colspan="2" class="table_comment">
					<?php echo ($table_info['table_comment']); ?>
				</td>
				
			</tr>
			<tr>
				<td colspan="1">开发人员:</td>
				<td colspan="3">
					<?php if($table_info['developer']): echo ($table_info['developer']); ?>
					<?php else: ?>
						未定义<?php endif; ?>
				</td>
				<td colspan="1">创建时间:</td>
				<td colspan="2">
					<?php if($table_info['create_time']): echo ($table_info['create_time']); ?>
					<?php else: ?>
						未定义<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td colspan="7">表结构</td>
			</tr>
			<tr class="active">
				<td>字段名称</td>
				<!--<td class="warning">字段名称(R)</td>-->
				<td>默认值</td>
				<!--<td class="warning">默认值(R)</td>-->
				<td>是否为空</td>
				<!--<td class="warning">是否为空(R)</td>-->
				<td>字段类型</td>
				<!--<td class="warning">字段类型(R)</td>-->
				<td>关键字（索引）</td>
				<!--<td class="warning">关键字(R)</td>-->
				<td>格外</td>
				<!--<td class="warning">格外(R)</td>-->
				<td>数据项说明</td>
				<!--<td class="warning">数据项说明(R)</td>-->
			</tr>
			<?php if(is_array($columns_info)): $i = 0; $__LIST__ = $columns_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td><?php echo ($vo['column_name']); ?></td>
				<!--<td class="warning"><?php echo ($vo['column_name_']); ?></td>-->
				<td><?php echo ($vo['column_default']); ?></td>
				<!--<td class="warning"><?php echo ($vo['column_default_']); ?></td>-->
				<td><?php echo ($vo['is_nullable']); ?></td>
				<!--<td class="warning"><?php echo ($vo['is_nullable_']); ?></td>-->
				<td><?php echo ($vo['column_type']); ?></td>
				<!--<td class="warning"><?php echo ($vo['column_type_']); ?></td>-->
				<td><?php echo ($vo['column_key']); ?></td>
				<!--<td class="warning"><?php echo ($vo['column_key_']); ?></td>-->
				<td><?php echo ($vo['extra']); ?></td>	
			    <!--<td class="warning"><?php echo ($vo['extra_']); ?></td>-->
				<td><?php echo ($vo['column_comment']); ?></td>
				<!--<td class="warning"><?php echo ($vo['column_comment_']); ?></td>-->
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
		<div>
			<p>
				<a title="<?php echo ($Prev['table_name']); ?>" href="<?php echo U('index/table_info',array('table_id'=>$Prev['id']));?>" type="button" class="btn btn-default">上一个表</a>
				<a title="<?php echo ($Next['table_name']); ?>" href="<?php echo U('index/table_info',array('table_id'=>$Next['id']));?>" type="button" class="btn btn-default">下一个表</a>
			</p>
		</div>
	</div> <!-- /container -->
	

	<!-- Modal -->
	<div class="modal fade  bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content">
		    <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">内容说明：（对该表的内容的说明）</h4>
		    </div>
			
			<div class="modal-body" style="margin:10px;">
				<?php echo ($table_info['extra_des']); ?>
			</div>			
	    </div>
	  </div>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>