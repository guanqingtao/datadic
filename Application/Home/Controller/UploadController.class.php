<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
class UploadController extends Controller {
	Public function upload($ftype = 'image'){
		if ($ftype == 'image') {
            $ftype = array('jpg', 'gif', 'png', 'jpeg');
        } else if ($ftype == 'file') {
            $ftype = array('zip', 'doc', 'rar', 'xls');
        }

        $setting = array(
            'mimes' => '', //允许上传的文件MiMe类型
            'maxSize' => 6 * 1024 * 1024, //上传的文件大小限制 (0-不做限制)
            'exts' => $ftype, //允许上传的文件后缀
            'autoSub' => true, //自动子目录保存文件
            'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath' => 'Public/upload/', //保存根路径
            'savePath' => '', //保存路径
        );

        /* 调用文件上传组件上传文件 */
        //实例化上传类，传入上面的配置数组
        $this->uploader = new Upload($setting, 'Local');
        $info = $this->uploader->upload($_FILES);

        //这里判断是否上传成功
        if ($info) {
            //// 上传成功 获取上传文件信息
            foreach ($info as &$file) {
                //拼接出上传目录
                $file['rootpath'] = __ROOT__ .'/'. ltrim($setting['rootPath'], ".");
                //拼接出文件相对路径
                $file['filepath'] = $file['rootpath'] . $file['savepath'] . $file['savename'];
            }
            //这里可以输出一下结果,相对路径的键名是$info['upload']['filepath']
			//dump($info['imgFile']['rootpath']);exit;
			echo json_encode(array('error' => 0, 'url' => $info['imgFile']['filepath']));
            //dump($info['upload']);
            exit();
        } else {
            //输出错误信息
            exit($this->uploader->getError());
        }
    }
		
		/*
		vendor("UploadFile");
		//导入上传类
		$upload = new \UploadFile();
		 //设置上传文件大小
		$upload->maxSize = 1097400;
		 //设置上传文件类型
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		 //设置附件上传目录
		$upload->savePath = 'Public/upload/';
		//设置需要生成缩略图，仅对图像文件有效
		$upload->thumb = true;
		// 缩略图生成方式 1 按设置大小截取 0 按原图等比例缩略
		$upload->thumbType = 0;
		 // 设置引用图片类库包路径
		$upload->imageClassPath = 'ORG.Util.Image';
		 
		 //设置需要生成缩略图的文件后缀
		$upload->thumbPrefix = 'm_';  //生产1张缩略图
		 //设置缩略图最大宽度
		$upload->thumbMaxWidth = '600';
		 //设置缩略图最大高度
		$upload->thumbMaxHeight = '600';
		 //设置上传文件规则
		$upload->saveRule = 'uniqid';
		 //删除原图
		$upload->thumbRemoveOrigin = false;
		if (!$upload->upload()) {
			//捕获上传异常
			$info = $upload->getErrorMsg();
			echo  json_encode(array('success' => 0, 'message' => $info ));
		} else {
			//取得成功上传的文件信息
			$info = $upload->getUploadFileInfo();
			$imgurl = $info[0]['savename'];
			$imgurl_m = C('TMPL_PARSE_STRING.__UPLOAD__').'m_'.$info[0]['savename'];
			$type = intval(I("get.type"));    //2为在线编辑器传入
			if($type == 2){
				echo json_encode(array('error' => 0, 'url' => $imgurl_m));
			}else{
				$imgurl_ = C('UPLOADPATH').'m_'.$info[0]['savename'];
				$image_m = getimagesize($imgurl_);
				echo json_encode(array('error' => 0, 'url' => $imgurl_m, 'width'=>$image_m[0],'height'=>$image_m[1], 'title'=>$imgurl,'border'=>C('TMPL_PARSE_STRING.__UPLOAD__')));
			}
			//import("ORG.Util.Image");
			//给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
			//Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], APP_PATH.'Tpl/Public/Images/logo.png');
			//$_POST['image'] = $uploadList[0]['savename'];
		}
		exit;
		
		*/
	
	
	
}