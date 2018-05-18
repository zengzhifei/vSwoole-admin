<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>互动平台</title>
<link href="/studio-v3/Public/Home/static/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="/studio-v3/Public/Home/static/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/studio-v3/Public/Home/static/theme/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<link href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-summernote/summernote.css">
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery-nestable/jquery.nestable.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/select2/select2.css"/>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
<!-- BEGIN THEME STYLES -->
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="/studio-v3/Public/Home/static/theme/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<link href="/studio-v3/Public/Home/static/theme/assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="/studio-v3/Public/Home/static/theme/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="/studio-v3/Public/Home/static/theme/assets/admin/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="/studio-v3/Public/Home/static/theme/assets/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css"/>
<link href="/studio-v3/Public/Home/static/theme/assets/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>
<link href="/studio-v3/Public/Home/static/css/tools.css" rel="stylesheet" type="text/css"/>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<!-- 图集弹窗所需js、css -->
<link id="skin" rel="stylesheet" href="/studio-v3/Public/static/jq_plugins/jBox/Skins2/Blue/jbox.css" />
<script type="text/javascript" src="/studio-v3/Public/static/jq_plugins/jBox/jquery.jBox-2.3.min.js"></script>
<script type="text/javascript" src="/studio-v3/Public/static/jq_plugins/jBox/i18n/jquery.jBox-zh-CN.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/interact/js/common.js"></script>
<style>
    .table-bordered th,td{text-align:center}
    .modal-header{background-color:#3598dc;color:#fff;padding:10px;}
    .interact_close{float:right;display:inline-block;padding:3px 0 8px;}
    .interact_close .interact_remove{cursor:pointer;display:inline-block;height:16px;width:11px;opacity:1;background:url(/studio-v3/Public/Home/interact/images/portlet-remove-icon-white.png);background-repeat:non-repeat;}
    .modal-footer{border-top:1px solid #3598dc;text-align:center;}
</style>
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo ">
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="javascript:void(0);">
            <img src="/studio-v3/Public/Home/interact/images/logo-light.png" alt="logo" class="logo-default" style="margin-top:19px"/>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->
        <!-- <div class="page-actions">
            <div class="btn-group">
                <button type="button" class="btn red-haze btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <span class="hidden-sm hidden-xs">Actions&nbsp;</span><i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="javascript:;">
                        <i class="icon-docs"></i> New Post </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                        <i class="icon-tag"></i> New Comment </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                        <i class="icon-share"></i> Share </a>
                    </li>
                    <li class="divider">
                    </li>
                    <li>
                        <a href="javascript:;">
                        <i class="icon-flag"></i> Comments <span class="badge badge-success">4</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                        <i class="icon-users"></i> Feedbacks <span class="badge badge-danger">2</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div> -->
        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
            <!-- <form class="search-form" action="extra_search.html" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" placeholder="Search..." name="query">
                    <span class="input-group-btn">
                    <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                    </span>
                </div>
            </form> -->
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide">
                    </li>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-success">
                        7 </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3><span class="bold">12 pending</span> notifications</h3>
                                <a href="extra_profile.html">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <li>
                                        <a href="javascript:;">
                                        <span class="time">just now</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-success">
                                        <i class="fa fa-plus"></i>
                                        </span>
                                        New user registered. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <span class="time">3 mins</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-danger">
                                        <i class="fa fa-bolt"></i>
                                        </span>
                                        Server #12 overloaded. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">

                                        <span class="time">10 mins</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-warning">
                                        <i class="fa fa-bell-o"></i>
                                        </span>
                                        Server #2 not responding. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <span class="time">14 hrs</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-info">
                                        <i class="fa fa-bullhorn"></i>
                                        </span>
                                        Application error. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <span class="time">2 days</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-danger">
                                        <i class="fa fa-bolt"></i>
                                        </span>
                                        Database overloaded 68%. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <span class="time">3 days</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-danger">
                                        <i class="fa fa-bolt"></i>
                                        </span>
                                        A user IP blocked. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <span class="time">4 days</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-warning">
                                        <i class="fa fa-bell-o"></i>
                                        </span>
                                        Storage Server #4 not responding dfdfdfd. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <span class="time">5 days</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-info">
                                        <i class="fa fa-bullhorn"></i>
                                        </span>
                                        System Error. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <span class="time">9 days</span>
                                        <span class="details">
                                        <span class="label label-sm label-icon label-danger">
                                        <i class="fa fa-bolt"></i>
                                        </span>
                                        Storage server failed. </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    <!-- END NOTIFICATION DROPDOWN -->
                    <li class="separator hide">
                    </li>
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark">
                        <a href="javascript:;" title="用户" class="dropdown-toggle">
                            <i class="icon-user"></i>
                        </a>
                    </li>
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark">
                        <a class="dropdown-toggle" title="系统" href="javascript:;">
                            <i class="icon-bell"></i>
                        </a>
                    </li>
                    <li class="dropdown dropdown-extended dropdown-tasks dropdown-dark">
                        <a class="dropdown-toggle" title="内容" href="javascript:;">
                            <i class="icon-calendar"></i>
                        </a>
                    </li>--><!-- <?php if($v["title"] == '系统'): ?>class="icon-bell"<?php endif; if($v["title"] == '内容'): ?>class="icon-calendar"<?php endif; ?> --> 
                    <?php if(is_array($__MENU__["main"])): foreach($__MENU__["main"] as $k=>$v): if($v["title"] == '用户' ): ?><li class="dropdown dropdown-extended dropdown-inbox dropdown-dark">
		                        <a href="<?php echo (U($v["url"])); ?>" title="<?php echo ($v["title"]); ?>" class="dropdown-toggle">
		                            <i class="icon-user"></i>
		                        </a>
	                        </li><?php endif; ?>
	                    <?php if($v["title"] == '扩展' ): ?><li class="dropdown dropdown-extended dropdown-inbox dropdown-dark">
                                <a href="<?php echo (U($v["url"])); ?>" title="<?php echo ($v["title"]); ?>" class="dropdown-toggle">
                                    <i class="icon-wrench"></i>
                                </a>
                            </li><?php endif; ?>
                        <?php if($v["title"] == '系统' ): ?><li class="dropdown dropdown-extended dropdown-inbox dropdown-dark">
                                <a href="<?php echo (U($v["url"])); ?>" title="<?php echo ($v["title"]); ?>" class="dropdown-toggle">
                                    <i class="icon-bell"></i>
                                </a>
                            </li><?php endif; ?> 
                        <?php if($v["title"] == '栏目管理' ): ?><li class="dropdown dropdown-extended dropdown-inbox dropdown-dark">
                                <a href="<?php echo (U($v["url"])); ?>" title="<?php echo ($v["title"]); ?>" class="dropdown-toggle">
                                    <i class="icon-home"></i>
                                </a>
                            </li><?php endif; endforeach; endif; ?>
                    <!-- END INBOX DROPDOWN -->
                    <li class="separator">
                    </li>
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="margin-top:-10px;">
                        <span class="username username-hide-on-mobile">
                        <h4 >
                        <?php echo session('user_auth.username');?>
                        </h4></span>
                        <i class="fa fa-angle-down"></i>
                        <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                        <!-- <img alt="" class="img-circle" src="/studio-v3/Public/Home/static/theme/assets/admin/layout4/img/avatar9.jpg"/> -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">

                            <li>
                                <a href="<?php echo U('Public/logout');?>">
                                <i class="fa fa-sign-out"></i> 退出 </a>
                            </li>
                            <li>
                                <a href="<?php echo U('User/updateNickname');?>">
                                <i class="fa fa-user"></i> 修改昵称 </a>
                            </li>
                            <li>
                                <a href="<?php echo U('User/updatePassword');?>">
                                <i class="fa fa-key"></i> 修改密码 </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="clearfix">
    <div class="page-container">
        <div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <?php if(!empty($__MENU__["child"])): ?><ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <?php if(is_array($__MENU__["child"])): foreach($__MENU__["child"] as $k=>$v): ?><li class="active">
                        <a href="javascript:;">
                            <i class="icon icon-unfold"></i>
                            <?php if(!empty($k)): ?><span class="title"><?php echo ($k); ?></span><?php endif; ?>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu" style="display: none;">
                            <?php if(is_array($v)): foreach($v as $key=>$sk): if($menuname == $sk[title]): ?><li class="myApp active">
                                        <?php else: ?>
                                    <li><?php endif; ?>
                                <?php if($sk["title"] == '节目期数'): ?><a href="<?php echo (U($sk["url"])); ?>">
                                    <?php else: ?>
                                    <a href="<?php echo U($sk['url'],array('stage_id'=>$stage_id));?>"><?php endif; ?>

                                <i class="icon icon-unfold"></i>
                                <?php echo ($sk["title"]); ?></a>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </li>
                    </if><?php endforeach; endif; ?>
            </ul><?php endif; ?>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<script>
    $(function () {
        var local_url = window.location.href;
        if (local_url.indexOf("&ticket=") != -1) {
            local_url = local_url.split("&ticket=");
            local_url = local_url[0];
        } else if (local_url.indexOf("/ticket/") != -1) {
            local_url = local_url.split("/ticket/");
            local_url = local_url[0] + ".html"
        } else {
            local_url = local_url.split("/admin.php?s=");
            var local_url1 = local_url[0];
            var local_url2 = local_url[1].split("/");
            if (local_url2[0] != '') {
                var url = local_url2[0];
            } else {
                var url = local_url2[1];
            }
            local_url = local_url[0] + '/admin.php?s=' + url;
        }
        $('.sub-menu').each(function () {
            $(this).children('li').each(function () {
                var href = $(this).find('a').attr('href');
                if (href.indexOf("/admin.php?s=") != -1) {
                    href = href.split("/admin.php?s=");
                    var href1 = href[0];
                    var href2 = href[1].split("/");
                    if (href2[0] != '') {
                        var newurl = href2[0]
                    } else {
                        var newurl = href2[1];
                    }
                    href = href[0] + '/admin.php?s=' + newurl;
                }
                if (local_url.toLowerCase() == href.toLowerCase()) {
                    $(this).parent().show();
                    $(this).parents('li').addClass('active on open');
                    $(this).parents('li').find('.arrow').addClass('open');
                }
            });
        });
    });
</script>
        <div class="page-content-wrapper">
            <!--图片上传需要引入的js-->
            <script type="text/javascript" src="/studio-v3/Public/static/uploadify/jquery.uploadify.min.js"></script>
            <script src="/studio-v3/Public/Home/interact/js/jquery.form.js" type="text/javascript"></script>
            <style>
                .qa-btn-select-img-div {
                    float: left;
                    position: relative;
                }
                .qa-btn-select-img {
                    cursor: pointer;
                    font-size: 30px;
                    height: 30px;
                    left: 0;
                    opacity: 0;
                    outline: medium none;
                    position: absolute;
                    top: 0;
                    width: 81px;
                }
                /*问答内容*/
                .qa-content {
                    display: none;
                }
                /*新增选项*/
                .qa-options-table {
                    margin: 10px 0px 5px 0px;
                    display: table;
                }
                .qa-options td {
                    padding: 10px 5px;
                    background-color: #f4f4f4;
                }
                .qa-options input {
                    margin-bottom: 0;
                }

                .jbox-body {
                    z-index: 99999;
                !important
                }
            </style>
            <!-- BEGIN CONTAINER -->
            <!-- <div class="page-container"> -->
            <!-- <div class="page-content-wrapper"> -->
            <div class="page-content">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Modal title</h4>
                            </div>
                            <div class="modal-body">
                                Widget settings form goes here
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn blue">Save changes</button>
                                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN VALIDATION STATES-->
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i><?php echo ($data['pageTitle']); ?>
                                </div>
                                <div class="tools">
                                    <button class="btn btn-default" id="qa-btn-goBack" type="button">返回</button>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form id="qa-form" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="alert alert-danger display-hide" style="margin-bottom: 15px;">
                                            <button data-close="alert" class="close"></button>
                                            <span></span>
                                        </div>
                                        <!--
                                            qa_options_type : 1 纯文字单选
                                            qa_options_type : 2 纯文字多选
                                            qa_options_type : 3 纯图片单选
                                            qa_options_type : 4 纯图片多选
                                            qa_options_type : 5 图文单选
                                            qa_options_type : 6 图文多选
                                            qa_options_type : 7 连线单连
                                            qa_options_type : 8 连线多连
                                            qa_options_type : 9 联想题
                                            qa_options_type : 10 图文无选项题
                                            qa_options_type : 11 填空题
                                            qa_options_type : 12 宫格题

                                        -->
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">问答类型<span class="required"> * </span></label>
                                            <div class="col-md-9">
                                                <select class="form-control input-inline input-small" name="qa-select-type">
                                                    <option value="1" qa_options_type="1" qa_Type="qa-trueFalse">对错题</option>
                                                    <option value="2" qa_options_type="1" qa_Type="qa-chooseOne">单选题</option>
                                                    <option value="3" qa_options_type="1" qa_Type="qa-distinguish">辨识题</option>
                                                    <option value="4" qa_options_type="5" qa_Type="qa-imageText">图文题</option>
                                                    <option value="5" qa_options_type="2" qa_Type="qa-choose">多选题</option>
                                                    <option value="6" qa_options_type="1" qa_Type="qa-audioVisual">视听题</option>
                                                    <option value="7" qa_options_type="7" qa_Type="qa-line">文字连线</option>
                                                    <option value="8" qa_options_type="9" qa_Type="qa-association">联想题</option>
                                                    <option value="9" qa_options_type="10" qa_Type="qa-notOption">无选项题</option>
                                                    <option value="10" qa_options_type="11" qa_Type="qa-fillBlank">填空题</option>
                                                    <option value="11" qa_options_type="12" qa_Type="qa-square">宫格题</option>
                                                    <!--<option value="12" qa_options_type="12" qa_Type="qa-square">十二宫格</option>
                                                    <option value="13" qa_options_type="12" qa_Type="qa-square">填字宫格</option>-->
                                                    <option value="14" qa_options_type="7" qa_Type="qa-line">图文连线</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">答题时区<span class="required"> * </span></label>
                                            <div class="col-md-9">
                                                <input type="text" name="dateRangePicker" class="form-control input-inline input-large"  placeholder="答题时间区间"  readonly="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">答题时长<span class="required"> * </span></label>
                                            <div class="col-md-9">
                                                <input type="text" name="qa-countdown" class="form-control input-inline input-medium" value="0" style="width: 220px !important;" />S
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">答案公布<span class="required"> * </span></label>
                                            <div class="col-md-9">
                                                <input type="text" name="qa-res-time" class="form-control input-inline input-large"  placeholder="答案公布时间"  readonly="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">问答题面<span class="required"> * </span></label>
                                            <div class="col-md-9">
                                                <textarea name="qa-subject" cols="40" rows="3" class="form-control input-inline input-medium"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">二级题面<span class="required"> &nbsp;</span></label>
                                            <div class="col-md-9">
                                                <textarea name="qa-title" cols="40" rows="3" class="form-control input-inline input-medium"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group" id="qa-subject-img-area" style="display: none;">
                                            <label class="control-label col-md-3">问答图片<span class="required"> &nbsp; </span></label>
                                            <div class="col-md-9">
                                                <!--<button style="float:left;" data-toggle="modal" class="btn btn-default qa-btn-select-img qa-btn-select-subject" type="button">浏览</button>-->
                                                <div class="qa-btn-select-img-div">
                                                    <img alt="" src="Public/Home/interact/images/liune.jpg">
                                                    <input type="file" file_type="img" name="download" class="qa-btn-select-img qa-btn-select-img-subject" />
                                                    <input type="hidden" name="qa-subject-img-id" value="" />
                                                    <span class="qa-upload-progress"></span>
                                                </div>
                                                <img style="width:50px;height:50px;" class="qa-subject-img-view">
                                                <button data-toggle="modal" class="btn qa-btn-subject-img-delete" type="button">删除</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">问答选项<span class="required"> * </span></label>
                                            <div class="col-md-9">
                                                <button class="btn btn-default" id="qa-btn-addOptions" type="button">添加选项</button>
                                                <button class="btn btn-default" id="qa-btn-lineSelectOptions" type="button" style="display: none;">配对选项</button>
                                                <button class="btn btn-default" id="qa-btn-addAnswer" type="button" style="display: none;">添加答案</button>
                                                <div id="qa-options-area"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">答案排序<span class="required"> * </span></label>
                                            <div class="col-md-9">
                                                <label for="qa-answer-sort-yes">
                                                    <input type="radio" id="qa-answer-sort-yes" name="qa-answer-sort" value="1">可以排序
                                                </label>
                                                <label for="qa-answer-sort-no">
                                                    <input type="radio" id="qa-answer-sort-no" name="qa-answer-sort" value="0" checked>不可排序
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">题目序号<span class="required"> &nbsp; </span></label>
                                            <div class="col-md-9">
                                                <textarea name="qa-extend" cols="40" rows="3" class="form-control input-inline input-medium"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">主持人点评<span class="required"> &nbsp; </span></label>
                                            <div class="col-md-9">
                                                <textarea name="qa-extend-zcr" cols="40" rows="3" class="form-control input-inline input-medium"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">备注<span class="required"> &nbsp; </span></label>
                                            <div class="col-md-9">
                                                <!--<textarea name="qa-remark" cols="40" rows="3" class="form-control input-inline input-medium"></textarea>-->
                                                <select class="form-control input-inline input-small" name="qa-remark">
                                                    <option value="">选择是否最末题</option>
                                                    <option value="END">本组最后一题</option>
                                                    <option value="STAGE_END">本期最后一题</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--模块绑定-->
<div class="modules-bind">
    <div class="modules-bind-row">
        <div class="form-group">
            <label class="col-md-3 control-label">绑定模块<span class="required"> &nbsp; </span></label>
            <div class="col-md-9">
                <select class="form-control input-inline input-small" name="modules-bind-name">
                    <?php if(!empty($modules)): ?><option value="">选择绑定模块名称</option>
                        <?php if(is_array($modules)): foreach($modules as $key=>$vo): ?><option value="<?php echo ($vo["module_code"]); ?>"><?php echo ($vo["module_name"]); ?></option><?php endforeach; endif; endif; ?>
                </select>
                <button class="btn btn-default modules-bind-add" type="button">追加</button>
                <button class="btn btn-default modules-bind-delete" type="button">删除</button>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">模块ID<span class="required"> &nbsp; </span></label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium" name="modules-bind-id">
                    <option value="">选择绑定模块ID</option>
                </select>
            </div>
        </div>
    </div>
</div>
<script>
    $(".modules-bind").on('click', ".modules-bind-add", function () {
        var html = $(".modules-bind-row").eq(0).clone();
        html.each(function () {
            var self = $(this);
            self.find("select[name='modules-bind-id']").empty();
        })
        $(".modules-bind").append(html);
    })
    $(".modules-bind").on('click', ".modules-bind-delete", function () {
        if ($(".modules-bind-row").length > 1) {
            $(this).parents('.modules-bind-row').remove();
        }
    })
    $(".modules-bind").on('change', "select[name='modules-bind-name']", function () {
        var modules_bind_name = $(this).val();
        var stage_id = "<?php echo ($stage_id); ?>";
        $.ajax({
            url: "<?php echo U('Module/selectModule');?>",
            type: 'GET',
            data: {module_code: modules_bind_name, stage_id: stage_id},
            dataType: 'json',
            context:this,
            success: function (res) {
                if (res.status == 1) {
                    var option = '';
                    $.each(res.data, function (k, v) {
                        option += '<option value="' + v.id + '">' + v.id + '</option>';
                    })
                    $(this).parents('.modules-bind-row').find("select[name='modules-bind-id']").html('').append(option);
                } else {
                    var option = '<option value="">'+res.msg+'</option>'
                    $(this).parents('.modules-bind-row').find("select[name='modules-bind-id']").html('').append(option);
                }
            },
            error: function (e) {
                alert(e.statusText);
            }
        })
    })

</script>

                                        <input type="hidden" name="stage-id" value="<?php echo ($data['pageParam']['stage_id']); ?>" />
                                        <input type="hidden" name="group-id" value="<?php echo ($data['pageParam']['group_id']); ?>" />
                                        <input type="hidden" name="qa-id" value="<?php echo ($data['pageInfo']['id']); ?>" />
                                        <input type="hidden" name="qa-created" value="<?php echo ($data['pageInfo']['qa_created']); ?>" />

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-4  col-md-7">
                                                    <button type="button" id="qa-btn-submit" class="btn blue">保存</button>
                                                    <button type="reset" class="btn default">重置</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                        <!-- END VALIDATION STATES-->
                    </div>
                </div>
                <!-- END PAGE CONTENT-->

                <!-- 创建浮层的html start -->
                <!-- javascript生成弹窗HTML -->
                <!-- 创建浮层的html end -->
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
<!-- END CONTENT -->
<!-- </div> -->
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<script type="text/javascript"
        src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<!-- END PAGE LEVEL STYLES -->
<script>

    $(function () {
        $('[name=qa-res-time]').daterangepicker({
            timePicker: true,
            timePickerIncrement: 1,
            timePicker24Hour:true,
            timePickerSeconds:true,
            linkedCalendars:false,
            singleDatePicker:true,
            locale : {
                applyLabel : '确定',
                cancelLabel : '取消',
                format: 'YYYY/MM/DD HH:mm:ss',
            },
        });
        //自动获取答题时间
        $("input[name='dateRangePicker']").on('apply.daterangepicker',function (m,e) {
            var qa_countdown = (new Date(e.endDate._d)).getTime() - (new Date(e.startDate._d)).getTime();
            $("input[name='qa-countdown']").val(Math.floor(qa_countdown / 1000));
        })
        //选项区域初始化
        $("select[name='qa-select-type']").on('change',function () {
            $("#qa-options-area").empty();
            var qaOptionType = $("select[name='qa-select-type']").find("option:selected").attr('qa_options_type');
            qaOptionType = Number(qaOptionType);
            //连线
            $.inArray(qaOptionType,[7,8]) != -1 ? $("#qa-btn-lineSelectOptions").show() && $(".col-md-3").css('width','11%') : $("#qa-btn-lineSelectOptions").hide() && $(".col-md-3").css('width','25%');
            //图片
            $.inArray(qaOptionType,[5,6]) != -1 ? $("#qa-subject-img-area").show() : $("#qa-subject-img-area").hide();
            //添加答案
            $.inArray(qaOptionType,[9,10,11]) != -1 ? $("#qa-btn-addAnswer").show() : $("#qa-btn-addAnswer").hide();
        })

        //添加选项
        $("#qa-btn-addOptions").on('click',function () {
            var qaOptionType = $("select[name='qa-select-type']").find("option:selected").attr('qa_options_type');
            if ($("#qa-options-area .qa-options-table").length < 1) {
                var optionsTable = getQaOptionsTable(qaOptionType);
                $("#qa-options-area").append(optionsTable);
            }

            if (qaOptionType == 12) {
                var initNumber = 0;
            } else {
                var initNumber = '@';
            }
            var thisNumber = $("#qa-options-area .qa-options-table .qa-options-number").length > 0 ? $("#qa-options-area .qa-options-table .qa-options-number:last").val() : initNumber;
            if ($.isNumeric(thisNumber) && thisNumber%1 == 0) {
                var nextNumber = Number(thisNumber) + 1;
            } else {
                var thisNumberCode = thisNumber.charCodeAt(0);
                var nextNumberCode = Number(thisNumberCode) + 1;
                var nextNumber = String.fromCharCode(nextNumberCode);
                var nextNumber_2 = nextNumber.toLowerCase();
            }
            var options = getQaOptions(qaOptionType,nextNumber,nextNumber_2);
            $("#qa-options-area .qa-options-table tbody").append(options);
        })

        //修改选项序号
        $(".qa-options-number").live('blur',function () {
            var newOptionNumber = $(this).val();
            $(this).parents('tr').find("input[name='qa-options-title']").attr('this_qa_options_number',newOptionNumber);
            $(this).parents('tr').find("input[name='qa-options-checkbox']").val(newOptionNumber);
        })

        //删除选项
        $(".qa-btn-options-delete").live('click',function () {
            $(this).parent().parent().remove();
        })

        //删除题目图片
        $(".qa-btn-subject-img-delete").on('click',function() {
            $("input[name='qa-subject-img-id']").val('');
            $(".qa-subject-img-view").attr('src','');
        })

        //连线配对项展示
        $("#qa-btn-lineSelectOptions").on('click',function () {
            var qaLineOptions = $("#qa-options-area .qa-options-table .qa-options-number-right");
            var lineSelectOptions = '<option>请配对右编号</option>';
            $(qaLineOptions).each(function (k,v) {
                lineSelectOptions += '<option class="qa-line-options" value="' + $(v).val() + '">' + $(v).val() + '</option>';
            })
            $("#qa-options-area .qa-options-table select[name='qa-line-select']").html(lineSelectOptions);
        })

        //添加答案
        $("#qa-btn-addAnswer").on('click',function () {
            var answerNumber = $("#qa-options-area .qa-addAnswer .qa-addAnswer-number:last").attr('qa-addAnswer-number');
                answerNumber = answerNumber ? Number(answerNumber) + 1 : 1;
            var answerDivHtml = '<div class="qa-addAnswer"></div>';
            var answerHtml  = '<div style="margin-top: 10px;">';
                answerHtml += '<span class="qa-addAnswer-number" qa-addAnswer-number="'+answerNumber+'">答案'+answerNumber+'：</span>';
                answerHtml += '<input type="text" class="form-control input-inline input-medium" name="qa-options-answer" value="" />';
                answerHtml += '<span><button class="btn btn-danger qa-btn-options-delete" type="button">删除</button></span></div>';
            $("#qa-options-area .qa-addAnswer").length == 0 &&  $("#qa-options-area").append(answerDivHtml);
            $("#qa-options-area .qa-addAnswer").append(answerHtml);
        })
        
        //上传图片
        $(".qa-btn-select-img").live('change',function () {
            uploadFile(this);
        })

        //宫格题答案展示
        $("input[name='qa-options-checkbox']").live('click',function () {
            var thisValue = $(this).parents('tr').find(".qa-options-number").val();
            var thisTitle = $(this).parents('tr').find("input[name='qa-options-title']").val();
            if ($(this).attr('checked') == 'checked') {
                $("#qa-btn-addAnswer").click();
                $("#qa-options-area .qa-addAnswer .qa-btn-options-delete").hide();
                $("#qa-options-area .qa-addAnswer input[name='qa-options-answer']:last").val(thisValue).attr('disabled','disabled');
                var answerView = '<span class="qa-options-answer-view" style="margin-left: -150px;">'+thisTitle+'<span>';
                $("#qa-options-area .qa-addAnswer input[name='qa-options-answer']:last").after(answerView);
            } else {
                $("#qa-options-area .qa-addAnswer input[name='qa-options-answer']").each(function(k,v) {
                    $(v).val() == thisValue && $(v).parent().remove();
                })
            }
        })

        //返回首页
        $("#qa-btn-goBack").on('click',function () {
            //var url = "<?php echo U('Qa/index');?>" + '&stage_id=' + "<?php echo ($data['pageParam']['stage_id']); ?>" + '&group_id=' + "<?php echo ($data['pageParam']['group_id']); ?>";
            window.location.href = document.referrer;
        })

        //编辑页面初始化
        initEditPage();

        //提交表单
        $("#qa-btn-submit").on('click',function () {
            var data = getQaData();
            if (data) {
                $.ajax({
                    url: "<?php echo U('Qa/saveQa');?>",
                    type: 'POST',
                    dataType: 'JSON',
                    data: data,
                    context: this,
                    timeout: 20000,
                    beforeSend: function () {
                        $(this).attr('disabled', true).text('保存中...');
                    },
                    complete: function () {
                        $(this).attr('disabled', false).text('保存');
                    },
                    success: function (res) {
                        console.log(res);
                        if (res.status == 1) {
                            $.confirm({
                                title: '保存成功',
                                level: 'success',
                                buttons: {
                                    "确定": {
                                        class:"blue",
                                        action:function() {
                                            //var url = "<?php echo U('Qa/index');?>" + '&stage_id=' + "<?php echo ($data['pageParam']['stage_id']); ?>" + '&group_id=' + "<?php echo ($data['pageParam']['group_id']); ?>";
                                            window.location.href = document.referrer;
                                        }
                                    }
                                }
                            })
                        } else {
                            $.confirm({
                                title: res.info,
                                level: 'warning',
                                buttons: {
                                    "确定": {
                                        class:"blue"
                                    }
                                }
                            })
                        }

                    },
                    error: function (e) {
                        $.confirm({
                            title: e.statusText,
                            level: 'danger',
                            buttons: {
                                "确定": {
                                    class:"blue"
                                }
                            }
                        })
                    }
                })
            }
        })

    })

    //初始化编辑页面
    function initEditPage() {
        var pageInfo = '<?php echo ($data["pageInfo"]); ?>';
        if (pageInfo) {
            pageInfo = JSON.parse(pageInfo);
            console.log(pageInfo);
            //类型
            $("select[name='qa-select-type'] option").each(function (key,value) {
                $(this).val() == pageInfo['qa_type'] && $(this).attr('selected',true);
            })
            var qaOptionType = $("select[name='qa-select-type']").find("option:selected").attr('qa_options_type');
            //答题时区
            $("input[name='dateRangePicker']").val(pageInfo['qa_time']);
            //时长
            $("input[name='qa-countdown']").val(pageInfo['qa_countdown']);
            //答案公布时间
            $("input[name='qa-res-time']").val(pageInfo['qa_res_time']);
            //题面
            $("textarea[name='qa-subject']").val(pageInfo['qa_subject']);
            //二级题面
            $("textarea[name='qa-title']").val(pageInfo['qa_title']);
            //题面图片
            if (qaOptionType == 5 || qaOptionType == 6) {
                $("#qa-subject-img-area").show();
                pageInfo['qa_subject_img'] != 0 && $("#qa-subject-img-area .qa-subject-img-view").attr('src',pageInfo['qa_subject_img_view']);
                pageInfo['qa_subject_img'] != 0 && $("#qa-subject-img-area input[name='qa-subject-img-id']").val(pageInfo['qa_subject_img']);
            }
            //问答选项按钮
            if (qaOptionType == 7 || qaOptionType == 8) {
                $("#qa-btn-lineSelectOptions").show() && $(".col-md-3").css('width','11%');
            } else if (qaOptionType == 9 || qaOptionType == 10 || qaOptionType == 11) {
                $("#qa-btn-addAnswer").show();
            }
            //答案排序
            $("input:radio[name='qa-answer-sort'][value='"+pageInfo['qa_answer_sort']+"']").attr('checked',true);
            //嘉宾扩展信息
            $("textarea[name='qa-extend']").val(pageInfo['qa_extend']);
            //主持人扩展信息
            $("textarea[name='qa-extend-zcr']").val(pageInfo['qa_extend_zcr']);
            //备注
            $("[name='qa-remark']").val(pageInfo['qa_remark']);
            //选项
            if (qaOptionType != 10) {
                var optionsTable = getQaOptionsTable(qaOptionType);
                $("#qa-options-area").append(optionsTable);
                if (qaOptionType == 7 || qaOptionType == 8) {
                    var upperCase_of_options = [];
                    var lowerCase_of_options = [];
                    for (var i = 0; i < pageInfo['qa_options'].length;i++) {
                        var option_number = pageInfo['qa_options'][i]['option_number'];
                        if (option_number.charCodeAt(0) >= 65 && option_number.charCodeAt(0) <= 90) {
                            upperCase_of_options.push(pageInfo['qa_options'][i]);
                        } else if (option_number.charCodeAt(0) >= 97 && option_number.charCodeAt(0) <= 122) {
                            lowerCase_of_options.push(pageInfo['qa_options'][i]);
                        }
                    }
                    for (var i = 0,j = 0; i < upperCase_of_options.length;) {
                        var optionsHtml = getQaOptions(qaOptionType,upperCase_of_options[i]['option_number'],lowerCase_of_options[i]['option_number']);
                        $("#qa-options-area .qa-options-table tbody").append(optionsHtml);

                        upperCase_of_options[i]['option_title'] && $("#qa-options-area .qa-options-table input[name='qa-options-title']").eq(j).val(upperCase_of_options[i]['option_title']);
                        upperCase_of_options[i]['option_img'] != 0 && $("#qa-options-area .qa-options-table .qa-options-img-view").eq(j).attr('src',upperCase_of_options[i]['option_img_view']);
                        upperCase_of_options[i]['option_img'] != 0 && $("#qa-options-area .qa-options-table input[name='qa-options-img-id']").eq(j).val(upperCase_of_options[i]['option_img']);

                        lowerCase_of_options[i]['option_title'] && $("#qa-options-area .qa-options-table input[name='qa-options-title']").eq(j+1).val(lowerCase_of_options[i]['option_title']);
                        lowerCase_of_options[i]['option_img'] != 0 && $("#qa-options-area .qa-options-table .qa-options-img-view").eq(j+1).attr('src',lowerCase_of_options[i]['option_img_view']);
                        lowerCase_of_options[i]['option_img'] != 0 && $("#qa-options-area .qa-options-table input[name='qa-options-img-id']").eq(j+1).val(lowerCase_of_options[i]['option_img']);
                        
                        i++;
                        j = j + 2;
                    }

                } else {
                    for (var i = 0; i < pageInfo['qa_options'].length;i++) {
                        var optionsHtml = getQaOptions(qaOptionType,pageInfo['qa_options'][i]['option_number'],pageInfo['qa_options'][i]['option_number'].toLowerCase());
                        $("#qa-options-area .qa-options-table tbody").append(optionsHtml);
                        pageInfo['qa_options'][i]['option_title'] && $("#qa-options-area .qa-options-table input[name='qa-options-title']:last").val(pageInfo['qa_options'][i]['option_title']);
                        pageInfo['qa_options'][i]['option_img'] != 0 && $("#qa-options-area .qa-options-table .qa-options-img-view:last").attr('src',pageInfo['qa_options'][i]['option_img_view']);
                        pageInfo['qa_options'][i]['option_img'] != 0 && $("#qa-options-area .qa-options-table input[name='qa-options-img-id']:last").val(pageInfo['qa_options'][i]['option_img']);
                    }
                }
            }

            //选项答案
            if (qaOptionType == 7 || qaOptionType == 8) {
                $("#qa-btn-lineSelectOptions").click();
                $.each(pageInfo['qa_right_key'],function (k,v) {
                    $.each(v,function (ke,vo) {
                        $("#qa-options-area .qa-options-table select[name='qa-line-select']").each(function (key,value) {
                            if ($(value).attr('this_qa_options_number') == ke) {
                                $(value).find('option').each(function () {
                                    $(this).val() == vo && $(this).attr('selected',true);
                                })
                            }
                        })
                    })
                })
            } else if (qaOptionType == 9 || qaOptionType == 10 || qaOptionType == 11) {
                if (pageInfo['qa_right_key']) {
                    $.each(pageInfo['qa_right_key'],function (k,v) {
                        $("#qa-btn-addAnswer").click();
                        $("#qa-options-area .qa-addAnswer input[name='qa-options-answer']:last").val(v);
                    })
                }
            } else if (qaOptionType == 12) {
                if (pageInfo['qa_right_key']) {
                    $.each(pageInfo['qa_right_key'],function (k,v) {
                        console.log();
                        $("#qa-options-area .qa-options-table input[name='qa-options-checkbox'][value="+v+"]").each(function () {
                            if (!$(this).is(':checked')){
                                $(this).click();
                                return false;
                            }
                        })
                    })
                }
            } else {
                if (pageInfo['qa_right_key']) {
                    $.each(pageInfo['qa_right_key'],function (k,v) {
                        $("#qa-options-area .qa-options-table input[name='qa-options-answer'][value="+v+"]").attr('checked',true);
                    })
                }
            }

            //绑定模块
            if(pageInfo['qa_bind_modules'] && pageInfo['qa_bind_modules'].length > 0) {
                $.each(pageInfo['qa_bind_modules'],function (k,v) {
                    $.each(v,function (module_name,module_id) {
                        $("select[name='modules-bind-name']").eq(k).find("option").each(function (key,vo) {
                            if ($(vo).val() == module_name) {
                                $(vo).attr('selected',true) && $(vo).parents('select').trigger('change');
                            }
                        })
                        var timer = setTimeout(function () {
                            $("select[name='modules-bind-id']").eq(k).find("option").each(function (key,vo) {
                                if ($(vo).val() == module_id) {
                                    $(vo).attr('selected',true);
                                }
                            })
                        },1500);
                    })
                    if (k < pageInfo['qa_bind_modules'].length -1) {
                        $(".modules-bind-add").click();
                    }
                })
            }

            //隐藏域赋值
            $("input[name='qa-created']").val(pageInfo['qa_created']);
            $("input[name='qa-id']").val(pageInfo['id']);
        }
    }

    //获取问答选项表格
    function getQaOptionsTable(optionsTableType) {
        var html = '<table cellspacing="1" cellpadding="0" class="qa-options-table">';
        html += '<tbody>';
        html += '<tr class="qa-options-table-head">';

        //纯文字单选 / 多选
        if (optionsTableType == 1 || optionsTableType == 2) {
            html += '<td>序号</td><td>标题</td><td>是否正确</td><td>操作</td>';

            //纯图片单选 / 多选
        } else if (optionsTableType == 3 || optionsTableType == 4) {
            html += '<td>序号</td><td>图片链接地址</td><td>预览</td><td>是否正确</td><td>操作</td>';

            //图文单选 / 多选
        } else if (optionsTableType == 5 || optionsTableType == 6) {
            html += '<td>序号</td><td>标题</td><td>图片链接地址</td><td>预览</td><td>是否正确</td><td>操作</td>';

            //连线单连 / 多连
        } else if (optionsTableType == 7 || optionsTableType == 8) {
            html += '<td>左序号</td><td>左标题</td><td>左图片</td><td>右序号</td><td>右标题</td><td>右图片</td><td>配对答案</td><td>操作</td>';

            //联想
        } else if (optionsTableType == 9) {
            html += '<td>序号</td><td>提示</td><td>操作</td>';

            //填空
        } else if (optionsTableType == 11) {
            html += '<td>序号</td><td>内容</td><td>操作</td>';
            
            //宫格
        } else if (optionsTableType == 12) {
             html += '<td>序号</td><td>宫格内容(从上到下从左至右)</td><td>是否正确</td><td>操作</td>';
        }
            html += '</tbody>';
        html += '</table>';
        return html;
    }

    //获取问答选项
    function getQaOptions(optionType,nextNumber,nextNumber_2) {
        //纯文字单选 / 多选
        if (optionType == 1 || optionType == 2) {
            var html  = '<tr class="qa-options">';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number" value="'+nextNumber+'" /></td>';
            html += '<td><input type="text" class="form-control input-inline input-medium" name="qa-options-title" this_qa_options_number="'+nextNumber+'" value="" /></td>';
            if (optionType == 1) {
                html += '<td><input type="radio" name="qa-options-answer" style="width: 20px;height: 20px;" value="'+nextNumber+'"></td>';
            } else if (optionType == 2) {
                html += '<td><input type="checkbox" class="form-control input-xsmall" name="qa-options-answer" value="'+nextNumber+'"></td>';
            }
            html += '<td><button class="btn btn-danger qa-btn-options-delete" type="button">删除</button></td>';
            html += '</tr>';

            //纯图片单选 / 多选
        } else if (optionType == 3 || optionType == 4) {
            var html  = '<tr class="qa-options">';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number" value="'+nextNumber+'" /></td>';
            html += '<td>';
            /*html += '<input type="text" class="form-control input-xsmall" style="float:left">';*/
            /*html += '<button style="float:left;" data-toggle="modal" class="btn btn-default qa-btn-select-img qa-btn-select-img-options" type="button">浏览</button>';*/
            html += '<div class="qa-btn-select-img-div">';
            html += '<img alt="" src="Public/Home/interact/images/liune.jpg">';
            html += '<input type="file" file_type="img" name="download" class="qa-btn-select-img qa-btn-select-img-options" />';
            html += '<input type="hidden" name="qa-options-img-id" this_qa_options_number="'+nextNumber+'" />';
            html += '<span class="qa-upload-progress"></span>';
            html += '</div>';
            html += '</td>';
            html += '<td><img style="width:50px;height:50px;" class="qa-options-img-view"></td>';
            if (optionType == 3) {
                html += '<td><input type="radio" name="qa-options-answer" style="width: 20px;height: 20px;" value="'+nextNumber+'"></td>';
            } else if (optionType == 4) {
                html += '<td><input type="checkbox" class="form-control input-xsmall" name="qa-options-answer" value="'+nextNumber+'"></td>';
            }
            html += '<td><button class="btn btn-danger qa-btn-options-delete" type="button">删除</button></td>';
            html += '</tr>';

            // 图文单选 / 多选
        } else if (optionType == 5 || optionType == 6) {
            var html  = '<tr class="qa-options">';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number" value="'+nextNumber+'" /></td>';
            html += '<td><input type="text" class="form-control input-inline input-medium" name="qa-options-title" this_qa_options_number="'+nextNumber+'" value="" /></td>';
            html += '<td>';
            /*html += '<input type="text" class="form-control input-xsmall" style="float:left">';*/
            /*html += '<button style="float:left;" data-toggle="modal" class="btn btn-default" type="button">浏览</button>';*/
            html += '<div class="qa-btn-select-img-div">';
            html += '<img alt="" src="Public/Home/interact/images/liune.jpg">';
            html += '<input type="file" file_type="img" name="download" class="qa-btn-select-img qa-btn-select-img-options" />';
            html += '<input type="hidden" name="qa-options-img-id" this_qa_options_number="'+nextNumber+'" />';
            html += '<span class="qa-upload-progress"></span>';
            html += '</div>';
            html += '</td>';
            html += '<td><img style="width:50px;height:50px;" class="qa-options-img-view"></td>';
            if (optionType == 5) {
                html += '<td><input type="radio" name="qa-options-answer" style="width: 20px;height: 20px;" value="'+nextNumber+'"></td>';
            } else if (optionType == 6) {
                html += '<td><input type="checkbox" class="form-control input-xsmall" name="qa-options-answer" value="'+nextNumber+'"></td>';
            }
            html += '<td><button class="btn btn-danger qa-btn-options-delete" type="button">删除</button></td>';
            html += '</tr>';

            // 连线单连 / 多连
        } else if (optionType == 7 || optionType == 8) {
            var html  = '<tr class="qa-options">';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number qa-options-number-left" style="width: 40px !important;height: 40px !important;" disabled value="'+nextNumber+'" /></td>';
            html += '<td><input type="text" class="form-control input-inline input-medium" name="qa-options-title" this_qa_options_number="'+nextNumber+'" style="width: 140px !important;height: 40px !important;" value="" /></td>';
            html += '<td>';
            html += '<div class="qa-btn-select-img-div">';
            html += '<img alt="" src="Public/Home/interact/images/liune.jpg" style="display:block;">';
            html += '<input type="file" file_type="img" name="download" class="qa-btn-select-img qa-btn-select-img-line qa-btn-select-img-options" />';
            html += '<input type="hidden" name="qa-options-img-id" this_qa_options_number="'+nextNumber+'" />';
            html += '<img style="width:50px;height:50px;" class="qa-options-img-view">';
            html += '<span class="qa-upload-progress"></span>';
            html += '</div>';
            html += '</td>';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number qa-options-number-right" style="width: 40px !important;height: 40px !important;" disabled value="'+nextNumber_2+'" /></td>';
            html += '<td><input type="text" class="form-control input-inline input-medium" name="qa-options-title" this_qa_options_number="'+nextNumber_2+'" style="width: 140px !important;height: 40px !important;" value="" /></td>';
            html += '<td>';
            html += '<div class="qa-btn-select-img-div">';
            html += '<img alt="" src="Public/Home/interact/images/liune.jpg" style="display:block;">';
            html += '<input type="file" file_type="img" name="download" class="qa-btn-select-img qa-btn-select-img-line qa-btn-select-img-options" />';
            html += '<input type="hidden" name="qa-options-img-id" this_qa_options_number="'+nextNumber_2+'" />';
            html += '<img style="width:50px;height:50px;" class="qa-options-img-view">';
            html += '<span class="qa-upload-progress"></span>';
            html += '</div>';
            html += '</td>';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number" style="width: 40px !important;height: 40px !important;display: inline-block" disabled value="'+nextNumber+'" />';
            html += '--';
            if (optionType == 7) {
                html += '<select class="form-control input-inline input-small" name="qa-line-select" this_qa_options_number="'+nextNumber+'" style="width: 130px !important;height: 40px !important;">';
            } else if (optionType == 8) {
                html += '<select class="form-control input-inline input-small" name="qa-line-select" this_qa_options_number="'+nextNumber+'" multiple="multiple" style="width: 130px !important;height: 40px !important;">';
            }
            html += '<option value="">请配对右编号</option>';
            html += '</select></td>';
            html += '<td><button class="btn btn-danger qa-btn-options-delete" type="button">删除</button></td>';
            html += '</tr>';

            //联想
        } else if(optionType == 9) {
            var html  = '<tr class="qa-options">';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number" style="width: 40px !important;height: 40px !important;" value="'+nextNumber+'" /></td>';
            html += '<td><input type="text" class="form-control input-inline input-medium" name="qa-options-title" this_qa_options_number="'+nextNumber+'" style="height: 40px !important;" value="" /></td>';
            html += '<td><button class="btn btn-danger qa-btn-options-delete" type="button">删除</button></td>';
            html += '</tr>';

            //填空
        } else if(optionType == 11) {
            var html  = '<tr class="qa-options">';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number" style="width: 40px !important;height: 40px !important;" value="'+nextNumber+'" /></td>';
            html += '<td><input type="text" class="form-control input-inline input-medium" name="qa-options-title" this_qa_options_number="'+nextNumber+'" style="height: 40px !important;" value="" /></td>';
            html += '<td><button class="btn btn-danger qa-btn-options-delete" type="button">删除</button></td>';
            html += '</tr>';
        
            //宫格
        } else if(optionType == 12) {
            var html  = '<tr class="qa-options">';
            html += '<td><input type="text" class="form-control input-xsmall qa-options-number" value="'+nextNumber+'" /></td>';
            html += '<td><input type="text" class="form-control input-inline input-medium" name="qa-options-title" this_qa_options_number="'+nextNumber+'" value="" /></td>';
            html += '<td><input type="checkbox" class="form-control input-xsmall" name="qa-options-checkbox" value="'+nextNumber+'"></td>';
            html += '<td><button class="btn btn-danger qa-btn-options-delete" type="button">删除</button></td>';
            html += '</tr>';
        }
        return html;
    }
    
    //获取表单数据
    function getQaData() {
        var data = {
            stageId : $("input[name='stage-id']").val(),
            groupId : $("input[name='group-id']").val(),
            qaType : $("select[name='qa-select-type']").val(),
            qaTypeName : $("select[name='qa-select-type'] option:selected").text(),
            qaTime: $("input[name='dateRangePicker']").val(),
            qaResTime: $("input[name='qa-res-time']").val(),
            qaCountdown : $("input[name='qa-countdown']").val(),
            qaSubject : $("textarea[name='qa-subject']").val(),
            qaTitle : $("textarea[name='qa-title']").val(),
            qaSubjectImg : $("input[name='qa-subject-img-id']").val(),
            qaOptions : [],
            qaOptionsImg : [],
            qaAnswer : [],
            qaAnswerSort : $("input[name='qa-answer-sort']:checked").val(),
            qaExtend : $("textarea[name='qa-extend']").val(),
            qaExtendZcr : $("textarea[name='qa-extend-zcr']").val(),
            qaRemark : $("[name='qa-remark']").val(),
            qaBindModules : [],
            qaCreated : $("input[name='qa-created']").val(),
            qaId : $("input[name='qa-id']").val(),
        }
        $("#qa-options-area .qa-options-table input[name='qa-options-title']").each(function (k,v) {
            var qa_options_title = {};
            qa_options_title[$(v).attr('this_qa_options_number')] = $(v).val();
            data['qaOptions'].push(qa_options_title);
        })
        $("#qa-options-area .qa-options-table input[name='qa-options-img-id']").each(function (k,v) {
            if ($(v).val().replace(/\s+/g, "").length > 0) {
                var qa_options_img = {};
                qa_options_img[$(v).attr('this_qa_options_number')] = $(v).val();
                data['qaOptionsImg'].push(qa_options_img);
            }
        })
        var qaOptionType = $("select[name='qa-select-type']").find("option:selected").attr('qa_options_type');
        if (qaOptionType == 7 || qaOptionType == 8) {
            $("#qa-options-area .qa-options-table select[name='qa-line-select']").each(function (k,v) {
                var qa_line_select = {};
                var qa_line_select_val = $(v).val();
                if (qa_line_select_val) {
                    qa_line_select[$(v).attr('this_qa_options_number')] = qa_line_select_val;
                    data['qaAnswer'].push(qa_line_select);
                }
            })
        } else if (qaOptionType == 9 || qaOptionType == 10 || qaOptionType == 11 || qaOptionType == 12) {
            $("#qa-options-area .qa-addAnswer input[name='qa-options-answer']").each(function (k,v) {
                data['qaAnswer'].push($(v).val());
            })
        } else {
            $("#qa-options-area .qa-options-table input[name='qa-options-answer']:checked").each(function (k,v) {
                data['qaAnswer'].push($(v).val());
            })
        }
        $("select[name='modules-bind-name']").each(function (k,v) {
            var modules_bind = {};
            var module_bind_name = $(this).val();
            var module_bind_id = $(this).parents('.modules-bind-row').find("select[name='modules-bind-id']").val();
            if (module_bind_name && module_bind_id) {
                modules_bind[module_bind_name] = module_bind_id;
                data['qaBindModules'].push(modules_bind);
            }
        })

        console.log(data);

        if (data.qaSubject.replace(/\s+/g, "").length === 0) {
            $(".display-hide").show().find('span').html('请输入有效问答题面!');
            $("textarea[name='qa-subject']").focus();
            return false;
        }
        if (qaOptionType != 10 && $.isEmptyObject(data.qaOptions) && $.isEmptyObject(data.qaOptionsImg)) {
            $(".display-hide").show().find('span').html('请输入有效问答选项!');
            return false;
        }
        if (qaOptionType != 9 && qaOptionType != 10 && qaOptionType != 11 && $.isEmptyObject(data.qaAnswer)) {
            $(".display-hide").show().find('span').html('请选择有效问答答案!');
            return false;
        }

        $(".display-hide").hide();

        return data;
    }

    //异步上传文件
    function uploadFile(obj){
        var file = $(obj).val();
        var fileType = $(obj).attr('file_type').toLowerCase();
        var fileExtension = file.substr(file.indexOf(".") + 1).toLowerCase();
        var fileFormat = {
            img : ['png','jpg','gif','jpeg'],
            audio : ['mp3','aac'],
            video : ['mp4','avi','mov'],
            txt : ['txt']
        }

        if (fileFormat.hasOwnProperty(fileType) && $.inArray(fileExtension,fileFormat[fileType]) >= 0) {
            $("#qa-form").ajaxSubmit({
                url: "<?php echo U('File/uploadPicture');?>",
                type: 'POST',
                data:{uid:'scdh'},
                dataType: 'JSON',
                beforeSend: function() {
                    $(obj).parent().find(".qa-upload-progress").html("0%");
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    $(obj).parent().find(".qa-upload-progress").html(percentComplete+"%");
                },
                complete: function () {
                    $(obj).parent().find(".qa-upload-progress").html('');
                },
                success: function(msg) {
                    console.log(msg);
                    if (msg.status == 1) {
                        if ($(obj).hasClass('qa-btn-select-img-subject')) {
                            $("input[name='qa-subject-img-id']").val(msg.id);
                            $(".qa-subject-img-view").attr('src','/studio-v3' + msg.path);
                        } else if ($(obj).hasClass('qa-btn-select-img-options')) {
                            $(obj).parent().find("input[name='qa-options-img-id']").val(msg.id);
                            var imgViewObj = $(obj).hasClass('qa-btn-select-img-line') ? $(obj).parent().find(".qa-options-img-view") : $(obj).parent().parent().parent().find(".qa-options-img-view");
                            imgViewObj.attr('src','/studio-v3' + msg.path);
                        }
                    } else {
                        $.confirm({
                            title: '上传失败，请重新尝试！',
                            level: 'warning',
                            buttons: {
                                "确定": {
                                    class:"blue"
                                }
                            }
                        })
                    }
                },
                error:function(e){
                    $.confirm({
                        title: e.statusText,
                        level: 'warning',
                        buttons: {
                            "确定": {
                                class:"blue"
                            }
                        }
                    })
                }
            });
        } else {
            $.confirm({
                title: '上传文件格式有误！',
                level: 'warning',
                buttons: {
                    "确定": {
                        class:"blue"
                    }
                }
            })
        }
    }


</script>


<!--[if lt IE 9]>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/respond.min.js"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<!-- BEGIN PAGE LEVEL PLUGINS  公用-->
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS  图表-->
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS  下拉列表（特殊）-->
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS 日期-->
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- <script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> -->
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script type="text/javascript" src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS  弹出层-->
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS  树形-->
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jstree/dist/jstree.js"></script>
<!-- END PAGE LEVEL SCRIPTS
<script src="/studio-v3/Public/Home/static/theme/assets/admin/pages/scripts/ui-tree.js"></script> -->

<!-- BEGIN PAGE LEVEL PLUGINS  文本编辑器-->
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->


<script src="/studio-v3/Public/Home/static/js/ui-tree-test.js" type="text/javascript"></script><!--树形-->

<script src="/studio-v3/Public/Home/static/js/list.js" type="text/javascript"></script><!--图片列表插件（自己封装）-->
<script src="/studio-v3/Public/Home/static/js/addtest.js" type="text/javascript"></script><!--点击插入插件（自己封装）-->

<script src="/studio-v3/Public/Home/static/js/metronictest.js" type="text/javascript"></script>

<!--<script src="/studio-v3/Public/Home/static/js/components-dropdowns-test.js"></script> 下拉-->
<!--<script src="/studio-v3/Public/Home/static/theme/assets/global/scripts/metronic.js" type="text/javascript"></script>-->
<script src="/studio-v3/Public/Home/static/theme/assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<!--<script src="/studio-v3/Public/Home/static/theme/assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>-->
<!--<script src="/studio-v3/Public/Home/static/theme/assets/admin/pages/scripts/ecommerce-index.js"></script>-->
<script src="/studio-v3/Public/Home/static/theme/assets/admin/pages/scripts/components-pickers.js"></script><!--日期-->

<script src="/studio-v3/Public/Home/static/theme/assets/admin/pages/scripts/ui-alert-dialog-api.js"></script><!--弹出层-->

<script src="/studio-v3/Public/Home/static/theme/assets/global/plugins/jquery-nestable/jquery.nestable.js"></script><!--拖动-->

<script src="/studio-v3/Public/Home/static/theme/assets/admin/pages/scripts/components-editors.js"></script><!--文本编辑器-->

<script src="/studio-v3/Public/Home/static/js/ui-nestabletest.js"></script><!--拖动-->




<!-- <script src="/studio-v3/Public/Home/static/js/jquery.tablednd.js"></script><!--拖动--> 
<!--测试-->
<!--<script src="metronictest.js" type="text/javascript"></script>-->
<script src="/studio-v3/Public/Home/static/js/test_datatable.js" type="text/javascript"></script><!--表格-->
<script src="/studio-v3/Public/Home/static/js/testui-alert-dialog-api.js" type="text/javascript"></script><!--弹出层-->
<script src="/studio-v3/Public/Home/static/js/tools.js" type="text/javascript"></script><!--弹出层-->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
        	$('[name=dateRangePicker]').daterangepicker({
    		    timePicker: true,
    		    timePickerIncrement: 1,
                timePicker24Hour:true,
                timePickerSeconds:true,
                linkedCalendars:false,
                locale : {
                    applyLabel : '确定',
                    cancelLabel : '取消',
                    format: 'YYYY/MM/DD HH:mm:ss',
                },
    		});
            ComponentsPickers.init();
            Layout.init(); // init current layout
            Metronic.init(); // init metronic core components
            /*
           //Demo.init(); // init demo features
           //EcommerceIndex.init();
           ComponentsPickers.init();
           TableEditable.init();
           UIAlertDialogApi.init();
           TestUIAlertDialogApi.init();
           UITree.init();
          // ComponentsDropdowns.init();
           ComponentsEditors.init();
           UINestable.init();
          
            
          
           new $.listtest({  
               url:"tab_content.json",
               container:"#tab_2_1",
               pagesize:"4"
            });
            
            $.addtest({
                container:".autoadd",
                addcontainer:"#addclick",
                addbutton:"#add",
                bgcolor:"alert-info",
                inputname:"addname",
                defaultname:"请填写",
                listnum:[
                    {cont:"123"},
                    {cont:"234"}
                ]
            })
            */
            
            $("#select2_sample5").click(function(){
                $.flowWindow({
                    "src":"treetest.html",
                    "cancel":function(){},
                    "successAction":function(data){
                        var text = "";
                        for(var i = 0;i<data.length;i++){
                            if(i>=data.length-1){
                                text+=data[i];
                            }else{
                                text+=data[i]+",";
                            }
                            
                        };
                        $("#select2_sample5").val(text)
                    }
                });
            });
        });
        

        function testConfirm() {
            $.confirm({  
               title:"确定要删除这条信息？",
               modal: true,  
               level:"warning",
               buttons: {  
                   "确定": {
                       "class":"blue",
                       "action":function() {
                           alert('确定');
                       }
                   },
                   "取消": {
                       "class":"blue",
                       "action":function() {
                           alert('取消');
                       }
                   }
               }  
            });
            
        }
        
        //选择图片
        function selectPicture(sfile,op) {
            $.jBox.tip("选择文件成功");
            $.jBox.close(true);
            if(op == ''){
                $("#litpic").val(sfile);
            }else{
                $("#tip_"+op).val(sfile);
            }
            $.post("/studio-v3/Admin/Public/getImgId",{img:sfile}, function(data) {
                
                if (data.status == 'succ') {
                    if(op){
                        $("#tip_url_"+op).val(data.id);
                    }else{
                        $("#pic_id").val(data.id);
                    }
                    
                }
            },'json');
            if(op == ''){
                $('#litpic_show').html("<img src='"+sfile+"' width='120'>");
            }
        }
        $(function(){
            $('.BrowerPicture').click(function(){
                var uid = $(this).attr("rel");
                var op = '';
                op = $(this).attr("op");
                var url = '/studio-v3/Admin/Public/browseFile?stype=picture&uid='+uid;
                if(op){
                    var url = '/studio-v3/Admin/Public/browseFile?stype=picture&uid='+uid+'&op='+op;
                }
                $.jBox("iframe:"+url,{
                            title:'图集',
                            width: 650,
                            height: 380,
                            buttons: { '关闭': true }
                            }
                        );      
            }); 
            //全选/取消
            $("#check").click(function(){
                if($(this).attr("checked")=="checked"){
                    setCheckbox(true);
                }else{
                    setCheckbox(false);
                }

            });
                     
            
            /*
              列表中全选的js 和获取checkbox选中的值
            */
            $(function(){
                $("#checkAll").click(function(){
                     if($(this).attr("checked")=="checked"){
                        //$("input[name='checkList']").attr("checked",$(this).attr("checked"));
                        $("input[name='checkList']").parent().addClass("checked");
                     }else{
                         $("input[name='checkList']").parent().removeClass("checked");
                     }
                });
            });
            function getCheckBoxValue(){
                var str='';
                $(".checked>input").each(function(){
                    if($(this).attr('id') != 'checkAll'){
                        str+=$(this).val()+',';
                    }
                });
                str = str.substr(0,str.length-1);
                return str;
            }
        }); 
		/*
		  列表中全选的js 和获取checkbox选中的值
		*/
		$(function(){
			$("#checkAll").click(function(){
				 if($(this).attr("checked")=="checked"){
			     	//$("input[name='checkList']").attr("checked",$(this).attr("checked"));
			     	$("input[name='checkList']").parent().addClass("checked");
				 }else{
					 $("input[name='checkList']").parent().removeClass("checked");
				 }
			});
		});
		function getCheckBoxValue(){
			var str='';
			$(".checked>input").each(function(){
				if($(this).attr('id') != 'checkAll'){
					str+=$(this).val()+',';
				}
			});
			str = str.substr(0,str.length-1);
			return str;
		}
</script>
</body>
</html>