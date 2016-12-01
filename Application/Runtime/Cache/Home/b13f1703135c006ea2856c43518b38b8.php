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

	<link href="/datadic/Public/js/kindeditor/themes/default/default.css" rel="stylesheet" >
	
    <title>Fixed Top Navbar Example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-fixed-top.css" rel="stylesheet">

	<link href="/datadic/Public/css/jquery.datetimepicker.css" rel="stylesheet">
	
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
          <a class="navbar-brand" href="/datadic/index.php">数据字典</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/datadic/index.php">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">databases <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!--
				<li><a href="<?php echo U('index/db_info',array('table_schema'=>'sit0828'));?>">sit0828</a></li>
                <li><a href="<?php echo U('index/db_info',array('table_schema'=>'iflashbuy_sit'));?>">iflashbuy_sit</a></li>
				-->
				<li><a href="<?php echo U('index/db_info',array('table_schema'=>'iflashbuy'));?>">iflashbuy（测试机244）</a></li>
              </ul>
            </li>
          </ul>
		  <ul class="nav navbar-nav navbar-right">
            <li class="active"><a  href="<?php echo U('index/table_info',array('table_id'=>$table_info['id']));?>"><span calss="glyphicon glyphicon-chevron-left">返回</span></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
		<form class="form-inline" action="<?php echo U('index/table_edit1Post');?>" method="post">
		<input id="t_id" name="post[id]" type="hidden" value="<?php echo ($table_info['id']); ?>" />
		<table class="table table-bordered ">
			<tr class="active">
				<td colspan="8" style="text-align:center;">
					<h3><?php echo ($table_info['table_name']); ?>db:<?php echo ($table_info['table_schema']); ?></h3>
				</td>
			</tr>
			<tr>
				<td colspan="1">表名称:</td>
				<td colspan="3" class="table_name">
					<input name="post[table_name]" class='form-control' value="<?php echo ($table_info['table_name']); ?>"/>
				</td>
				<td colspan="1">含义:</td>
				<td colspan="3" class="table_comment">
					<input name="post[table_comment]" class='form-control' value="<?php echo ($table_info['table_comment']); ?>" />
				</td>
				
			</tr>
			<tr>
				<td colspan="1">开发人员:</td>
				<td colspan="3">
					<input name="post[developer]" class='form-control' value="<?php echo ($table_info['developer']); ?>" />
				</td>
				<td colspan="1">创建时间:</td>
				<td colspan="3">
					<input type="text" name="post[create_time]"  class="form-control" value="<?php echo ($table_info['create_time']); ?>" id="datetimepicker"/>
				</td>
			</tr>
		</table>
		<p class="text-right">
			
			<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" >添加额外说明</button>
			<button type="submit" class="btn btn-default">Submit</button>
		</p>
		</form>	
		<table class="table table-bordered ">
			<tr>
				<td colspan="8">表结构</td>
			</tr>
			<tr class="active">
				<td>字段名称</td>
				<td>默认值</td>
				<td>是否为空</td>
				<td>字段类型</td>
				<td>关键字（索引）</td>
				<td>格外</td>
				<td>数据项说明(直接双击表格修改)</td>
				<td>创建时间</td>
			</tr>
			<?php if(is_array($columns_info)): $i = 0; $__LIST__ = $columns_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td>
					<span class="column_id" style="display:none;"><?php echo ($vo['id']); ?></span>
					<?php echo ($vo['column_name']); ?>
				</td>			
				<td><?php echo ($vo['column_default']); ?></td>			
				<td><?php echo ($vo['is_nullable']); ?></td>			
				<td><?php echo ($vo['column_type']); ?></td>			
				<td><?php echo ($vo['column_key']); ?></td>			
				<td><?php echo ($vo['extra']); ?></td>			
				<td class="comment"><?php echo ($vo['column_comment']); ?></td>
				<td><?php echo ($vo['create_time']); ?></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div> <!-- /container -->
	
	<!-- Modal -->
	<form action="<?php echo U('index/table_edit3Post');?>" method="post">
	
	<div class="modal fade  bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content">
		    <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">内容说明：（对该表的内容的说明）</h4>
		    </div>
			
			<div class="modal-body" style="margin:10px;">
				<input id="t_id" name="id" type="hidden" value="<?php echo ($table_info['id']); ?>" />
				<textarea id="ke_demo" name="extra_des"  style="width:100%;margin-top:5px;height:300px;"><?php echo ($table_info['extra_des']); ?></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
	    </div>
	  </div>
	</div>
	</form>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
	<script src="/datadic/Public/js/jquery.datetimepicker.js"></script>
	
	<!-- Kideditor croe JS -->
    <script charset="utf-8" src="/datadic/Public/js/kindeditor/kindeditor-min.js"></script>
    <script charset="utf-8" src="/datadic/Public/js/kindeditor/lang/zh_CN.js"></script>
	<script>
		$('#datetimepicker10').datetimepicker({
			step:5,
			inline:true
		});
		$('#datetimepicker_mask').datetimepicker({
			mask:'9999/19/39 29:59'
		});
		$('#datetimepicker').datetimepicker();
		$('#datetimepicker').datetimepicker({value:"<?php echo ($table_info['create_time']); ?>",step:10});
		$('#datetimepicker1').datetimepicker({
			datepicker:false,
			format:'H:i',
			step:5
		});
		$('#datetimepicker2').datetimepicker({
			yearOffset:222,
			lang:'ch',
			timepicker:false,
			format:'d/m/Y',
			formatDate:'Y/m/d',
			minDate:'-1970/01/02', // yesterday is minimum date
			maxDate:'+1970/01/02' // and tommorow is maximum date calendar
		});
		$('#datetimepicker3').datetimepicker({
			inline:true
		});
		$('#datetimepicker4').datetimepicker();
		$('#open').click(function(){
			$('#datetimepicker4').datetimepicker('show');
		});
		$('#close').click(function(){
			$('#datetimepicker4').datetimepicker('hide');
		});
		$('#reset').click(function(){
			$('#datetimepicker4').datetimepicker('reset');
		});
		$('#datetimepicker5').datetimepicker({
			datepicker:false,
			allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00']
		});
		$('#datetimepicker6').datetimepicker();
		$('#destroy').click(function(){
			if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
				$('#datetimepicker6').datetimepicker('destroy');
				this.value = 'create';
			}else{
				$('#datetimepicker6').datetimepicker();
				this.value = 'destroy';
			}
		});
		var logic = function( currentDateTime ){
			if( currentDateTime.getDay()==6 ){
				this.setOptions({
					minTime:'11:00'
				});
			}else
				this.setOptions({
					minTime:'8:00'
				});
		};
		$('#datetimepicker7').datetimepicker({
			onChangeDateTime:logic,
			onShow:logic
		});
		$('#datetimepicker8').datetimepicker({
			onGenerate:function( ct ){
				$(this).find('.xdsoft_date')
					.toggleClass('xdsoft_disabled');
			},
			minDate:'-1970/01/2',
			maxDate:'+1970/01/2',
			timepicker:false
		});
		$('#datetimepicker9').datetimepicker({
			onGenerate:function( ct ){
				$(this).find('.xdsoft_date.xdsoft_weekend')
					.addClass('xdsoft_disabled');
			},
			weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
			timepicker:false
		});
		$(".comment").dblclick(function(){
			var v = $(this).text();
			$(this).text("");
			var column_id = $(this).parent().first("td").find("span").text();
			//return false;
			var input = "<input class='form-control' id='temp' type='text' value='"+v+"'/>"
			$(this).append(input);
			$("input#temp").focus();
			$("input").blur(function(){ 
                if($(this).val()==""){ 
                    $(this).remove(); 
                }else{
					var column_comment = $(this).val();
					$.post("<?php echo U('index/aj_columns_post');?>", { column_id: column_id, column_comment: column_comment },
						function(data){														
							if(data.success == 0){								
								window.location.reload();
							}						
					},"json");	
                    $(this).closest("td").text($(this).val()); 
                }
            })
		});
		/*
		$('.check_table').click(function(){
			
			$.get("<?php echo U('index/aj_check_table_post');?>", { column_id: column_id, column_comment: column_comment },
						function(data){														
							if(data.success == 0){								
								window.location.reload();
							}						
					},"json");
		});
		*/
		var editor;
		KindEditor.ready(function(K) {
			editor = K.create('textarea[id="ke_demo"]', {
				allowFileManager : true,
				autoHeightMode : true,
				uploadJson : "<?php echo U('Upload/upload');?>",
				//items : ['fullscreen','|','fontname', '|', 'forecolor', 'hilitecolor', 'italic', 'underline','removeformat', '|', 'emoticons'],
							
			});
		});
		
	</script>

  </body>