<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>互动平台</title>
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-summernote/summernote.css">
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery-nestable/jquery.nestable.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/select2/select2.css"/>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
<!-- BEGIN THEME STYLES -->
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css"/>
<link href="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>
<link href="/demo/vSwoole-admin/Public/Home/static/css/tools.css" rel="stylesheet" type="text/css"/>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<!-- 图集弹窗所需js、css -->
<link id="skin" rel="stylesheet" href="/demo/vSwoole-admin/Public/static/jq_plugins/jBox/Skins2/Blue/jbox.css" />
<script type="text/javascript" src="/demo/vSwoole-admin/Public/static/jq_plugins/jBox/jquery.jBox-2.3.min.js"></script>
<script type="text/javascript" src="/demo/vSwoole-admin/Public/static/jq_plugins/jBox/i18n/jquery.jBox-zh-CN.js"></script>
<script type="text/javascript" src="/demo/vSwoole-admin/Public/Home/interact/js/common.js"></script>

<!--echats-->
<script type="text/javascript" src="/demo/vSwoole-admin/Public/static/echarts.common.min.js"></script>
<style>
    .table-bordered th,td{text-align:center}
    .modal-header{background-color:#3598dc;color:#fff;padding:10px;}
    .interact_close{float:right;display:inline-block;padding:3px 0 8px;}
    .interact_close .interact_remove{cursor:pointer;display:inline-block;height:16px;width:11px;opacity:1;background:url(/demo/vSwoole-admin/Public/Home/interact/images/portlet-remove-icon-white.png);background-repeat:non-repeat;}
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
            <img src="/demo/vSwoole-admin/Public/Home/interact/images/logo-light.png" alt="logo" class="logo-default" style="margin-top:19px"/>
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
                        <?php if($v["title"] == '服务管理' ): ?><li class="dropdown dropdown-extended dropdown-inbox dropdown-dark">
                                <a href="<?php echo (U($v["url"])); ?>" title="<?php echo ($v["title"]); ?>" class="dropdown-toggle">
                                    <i class="icon-list"></i>
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
                        <!-- <img alt="" class="img-circle" src="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/layout4/img/avatar9.jpg"/> -->
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
    var local_url = window.location.href;
    var getUrlParam = function(url,param) {
        if (!url || !param) return null;
        var reg = new RegExp("(^|&|/|\\?)" + param + "=([/]?)([^&]*)(&|$)");
        var r = url.match(reg);
        if (r != null) {
            r[3] = r[3].indexOf('/') == -1 ? r[3]+'/index' : r[3];
            var reg = /(\.html)|(\.htm)/g;
            r[3] = r[3].replace(reg,'');
            return decodeURI(r[3]).toLowerCase();
        }
        return null;
    }
    $('.sub-menu').each(function() {
        $(this).children('li').each(function() {
            var href = $(this).find('a').attr('href');
            if(getUrlParam(local_url,'s') == getUrlParam(href,'s')) {
                $(this).addClass('active');
                $(this).parent().parent().addClass('active on open');
                $(this).parent().parent().find('.arrow').addClass('open');
                $(this).parent().show();
            }
        });
    });
</script>

		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
					tabindex="-1" id="portlet-config" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button aria-hidden="true" data-dismiss="modal" class="close"
									type="button"></button>
								<h4 class="modal-title">Modal title</h4>
							</div>
							<div class="modal-body">Widget settings form goes here</div>
							<div class="modal-footer">
								<button class="btn blue" type="button">Save changes</button>
								<button data-dismiss="modal" class="btn default" type="button">Close</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<!-- BEGIN PAGE HEADER-->
				<!-- BEGIN PAGE HEAD -->
				<div class="page-head">
					<!-- BEGIN PAGE TITLE -->
					<!-- END PAGE TITLE -->
					<!-- BEGIN PAGE TOOLBAR -->
					<!--<div class="page-toolbar">
                     BEGIN THEME PANEL 
                    <div class="btn-group btn-theme-panel">
                        <a data-toggle="dropdown" class="btn dropdown-toggle" href="javascript:;">
                        <i class="icon-settings"></i>
                        </a>
                        <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <h3>THEME</h3>
                                    <ul class="theme-colors">
                                        <li data-theme="default" class="theme-color theme-color-default active">
                                            <span class="theme-color-view"></span>
                                            <span class="theme-color-name">Dark Header</span>
                                        </li>
                                        <li data-theme="light" class="theme-color theme-color-light">
                                            <span class="theme-color-view"></span>
                                            <span class="theme-color-name">Light Header</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12 seperator">
                                    <h3>LAYOUT</h3>
                                    <ul class="theme-settings">
                                        <li>
                                             Theme Style
                                            <select class="layout-style-option form-control input-small input-sm">
                                                <option selected="selected" value="square">Square corners</option>
                                                <option value="rounded">Rounded corners</option>
                                            </select>
                                        </li>
                                        <li>
                                             Layout
                                            <select class="layout-option form-control input-small input-sm">
                                                <option selected="selected" value="fluid">Fluid</option>
                                                <option value="boxed">Boxed</option>
                                            </select>
                                        </li>
                                        <li>
                                             Header
                                            <select class="page-header-option form-control input-small input-sm">
                                                <option selected="selected" value="fixed">Fixed</option>
                                                <option value="default">Default</option>
                                            </select>
                                        </li>
                                        <li>
                                             Top Dropdowns
                                            <select class="page-header-top-dropdown-style-option form-control input-small input-sm">
                                                <option value="light">Light</option>
                                                <option selected="selected" value="dark">Dark</option>
                                            </select>
                                        </li>
                                        <li>
                                             Sidebar Mode
                                            <select class="sidebar-option form-control input-small input-sm">
                                                <option value="fixed">Fixed</option>
                                                <option selected="selected" value="default">Default</option>
                                            </select>
                                        </li>
                                        <li>
                                             Sidebar Menu
                                            <select class="sidebar-menu-option form-control input-small input-sm">
                                                <option selected="selected" value="accordion">Accordion</option>
                                                <option value="hover">Hover</option>
                                            </select>
                                        </li>
                                        <li>
                                             Sidebar Position
                                            <select class="sidebar-pos-option form-control input-small input-sm">
                                                <option selected="selected" value="left">Left</option>
                                                <option value="right">Right</option>
                                            </select>
                                        </li>
                                        <li>
                                             Footer
                                            <select class="page-footer-option form-control input-small input-sm">
                                                <option value="fixed">Fixed</option>
                                                <option selected="selected" value="default">Default</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                     END THEME PANEL 
                </div> -->
					<!-- END PAGE TOOLBAR -->
				</div>
				<!-- END PAGE HEAD -->
				<!-- BEGIN PAGE BREADCRUMB -->
				<!-- END PAGE BREADCRUMB -->
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->

				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">
	                                 <i class="fa fa-edit"></i><?php echo isset($info['id'])?'编辑':'新增';?>后台菜单
	                            </div>
							</div>
							<div class="portlet-body form">
								<div class="form-body">
									<div class="alert alert-danger display-hide">
										<button data-close="alert" class="close"></button>
										<span></span>
									</div>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-12">
											<form id="sortform" class="form-horizontal">
												<div class="form-group">
													<label class="control-label col-md-3">标题：<span class="required"> * </span></label>
													<div class="col-md-9">
														<input type="text" name="title" class="form-control input-inline input-medium" value="<?php echo ((isset($info["title"]) && ($info["title"] !== ""))?($info["title"]):''); ?>"/>
														<span class="help-inline">用于后台显示的配置标题</span>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">排序：</label>
													<div class="col-md-9">
														<input type="text" name="sort" class="form-control input-inline input-medium" value="<?php echo ((isset($info["sort"]) && ($info["sort"] !== ""))?($info["sort"]):0); ?>"/>
														<span class="help-inline">用于分组显示的顺序</span>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">链接：<span class="required"> * </span></label>
													<div class="col-md-9">
														<input type="text" name="url" class="form-control input-inline input-medium" value="<?php echo ((isset($info["url"]) && ($info["url"] !== ""))?($info["url"]):''); ?>"/>
														<span class="help-inline">U函数解析的URL或者外链</span>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">上级菜单：</label>
													<div class="col-md-9">
														<select class="form-control input-inline input-medium"  name="pid">
															<?php if(is_array($Menus)): $i = 0; $__LIST__ = $Menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($menu["id"]); ?>" <?php if($menu["id"] == $info['pid']): ?>selected<?php endif; ?>><?php echo ($menu["title_show"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
														</select>
														
														<span class="help-inline">所属的上级菜单</span>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">分组：</label>
													<div class="col-md-9">
														<input type="text" name="group" class="form-control input-inline input-medium" value="<?php echo ((isset($info["group"]) && ($info["group"] !== ""))?($info["group"]):''); ?>"/>
														<span class="help-inline">用于左侧分组二级菜单</span>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">是否隐藏：</label>
													<div class="col-md-9">
                										<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="hide" id="optionsRadios33" value="1" <?php if($info["hide"] == 1): ?>checked<?php endif; ?>>是</label>
															<label class="radio-inline">
															<input type="radio" name="hide" id="optionsRadios34" value="0" <?php if($info["hide"] == 0): ?>checked<?php endif; ?>>否</label>
													    </div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">仅开发者模式可见：</label>
													<div class="col-md-9">
                										<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="is_dev" id="optionsRadios33" value="1" <?php if($info["is_dev"] == 1): ?>checked<?php endif; ?>>是</label>
															<label class="radio-inline">
															<input type="radio" name="is_dev" id="optionsRadios34" value="0" <?php if($info["is_dev"] == 0): ?>checked<?php endif; ?>>否</label>
													    </div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">说明：</label>
													<div class="col-md-9">
														<input type="text" name="tip" class="form-control input-inline input-medium" value="<?php echo ((isset($info["tip"]) && ($info["tip"] !== ""))?($info["tip"]):''); ?>"/>
														<span class="help-inline">菜单详细说明</span>
													</div>
												</div>
												<div class="form-actions">
													<div class="row">
														<div class="col-md-offset-4 col-md-7">
															<input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
															<button type="button" onclick="checkform(this.form)" class="btn blue">提交</button>
															<button class="btn default" onclick="javascript:history.back(-1);return false;">返 回</button>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<script type="text/javascript">
						function checkform(form) {
							if (form.title.value == '') {
								$(".display-hide > span").html("请输入行为名称");
								$(".display-hide").show();
								form.title.focus();
								return false;
							}
							if (form.url.value == '') {
								$(".display-hide > span").html("请输入链接");
								$(".display-hide").show();
								form.url.focus();
								return false;
							}
							
							$(".display-hide").hide();
					        var data=$("#sortform").serialize();
							$.ajax({
					            url:"<?php echo U();?>",
					            data:data,
					            type:"POST",
					            dataType:"json",
					            success:function(msg){
					            	
					                if(msg.status == 1){
					                    var msg = msg.info;
					                    $.confirm({title:msg,modal: true, level:"success",buttons: {  
					                           "确定": {
					                               "class":"blue",
					                               "action":function() {
					                            	   //location.reload();
					                            	   location.href = document.referrer;
					                               }
					                           }
					                       }  
					                    });
					                }else{
					                    var msg=msg.info+",请重新提交";
					                    $.confirm({title:msg,modal: true, level:"danger",buttons: {  
					                           "确定": {
					                               "class":"blue",
					                               "action":function() {
					                               }
					                           }
					                       }  
					                    });
					                }
					            }
					        });
							return false;
							
						}

					</script>

				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>

	<!-- END PAGE CONTENT-->
</div>



<!--[if lt IE 9]>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/respond.min.js"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN PAGE LEVEL PLUGINS  公用-->
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS  图表-->
<script type="text/javascript" src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS  下拉列表（特殊）-->
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS 日期-->
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- <script type="text/javascript" src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> -->
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script type="text/javascript"
        src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS  弹出层-->
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS  树形-->
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jstree/dist/jstree.js"></script>
<!-- END PAGE LEVEL SCRIPTS
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/pages/scripts/ui-tree.js"></script> -->

<!-- BEGIN PAGE LEVEL PLUGINS  文本编辑器-->
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-markdown/lib/markdown.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"
        type="text/javascript"></script>
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/bootstrap-summernote/summernote.min.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->


<script src="/demo/vSwoole-admin/Public/Home/static/js/ui-tree-test.js" type="text/javascript"></script><!--树形-->

<script src="/demo/vSwoole-admin/Public/Home/static/js/list.js" type="text/javascript"></script><!--图片列表插件（自己封装）-->
<script src="/demo/vSwoole-admin/Public/Home/static/js/addtest.js" type="text/javascript"></script><!--点击插入插件（自己封装）-->

<script src="/demo/vSwoole-admin/Public/Home/static/js/metronictest.js" type="text/javascript"></script>

<!--<script src="/demo/vSwoole-admin/Public/Home/static/js/components-dropdowns-test.js"></script> 下拉-->
<!--<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/scripts/metronic.js" type="text/javascript"></script>-->
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<!--<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>-->
<!--<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/pages/scripts/ecommerce-index.js"></script>-->
<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/pages/scripts/components-pickers.js"></script><!--日期-->

<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/pages/scripts/ui-alert-dialog-api.js"></script><!--弹出层-->

<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/global/plugins/jquery-nestable/jquery.nestable.js"></script><!--拖动-->

<script src="/demo/vSwoole-admin/Public/Home/static/theme/assets/admin/pages/scripts/components-editors.js"></script><!--文本编辑器-->

<script src="/demo/vSwoole-admin/Public/Home/static/js/ui-nestabletest.js"></script><!--拖动-->


<!-- <script src="/demo/vSwoole-admin/Public/Home/static/js/jquery.tablednd.js"></script><!--拖动-->
<!--测试-->
<!--<script src="metronictest.js" type="text/javascript"></script>-->
<script src="/demo/vSwoole-admin/Public/Home/static/js/test_datatable.js" type="text/javascript"></script><!--表格-->
<script src="/demo/vSwoole-admin/Public/Home/static/js/testui-alert-dialog-api.js" type="text/javascript"></script><!--弹出层-->
<script src="/demo/vSwoole-admin/Public/Home/static/js/tools.js" type="text/javascript"></script><!--弹出层-->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        $('[name=dateRangePicker]').daterangepicker({
            timePicker: true,
            timePickerIncrement: 1,
            timePicker24Hour: true,
            timePickerSeconds: true,
            linkedCalendars: false,
            locale: {
                applyLabel: '确定',
                cancelLabel: '取消',
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

        $("#select2_sample5").click(function () {
            $.flowWindow({
                "src": "treetest.html",
                "cancel": function () {
                },
                "successAction": function (data) {
                    var text = "";
                    for (var i = 0; i < data.length; i++) {
                        if (i >= data.length - 1) {
                            text += data[i];
                        } else {
                            text += data[i] + ",";
                        }

                    }
                    ;
                    $("#select2_sample5").val(text)
                }
            });
        });
    });


    function testConfirm() {
        $.confirm({
            title: "确定要删除这条信息？",
            modal: true,
            level: "warning",
            buttons: {
                "确定": {
                    "class": "blue",
                    "action": function () {
                        alert('确定');
                    }
                },
                "取消": {
                    "class": "blue",
                    "action": function () {
                        alert('取消');
                    }
                }
            }
        });

    }

    //选择图片
    function selectPicture(sfile, op) {
        $.jBox.tip("选择文件成功");
        $.jBox.close(true);
        if (op == '') {
            $("#litpic").val(sfile);
        } else {
            $("#tip_" + op).val(sfile);
        }
        $.post("/demo/vSwoole-admin/Admin/Public/getImgId", {img: sfile}, function (data) {

            if (data.status == 'succ') {
                if (op) {
                    $("#tip_url_" + op).val(data.id);
                } else {
                    $("#pic_id").val(data.id);
                }

            }
        }, 'json');
        if (op == '') {
            $('#litpic_show').html("<img src='" + sfile + "' width='120'>");
        }
    }

    $(function () {
        $('.BrowerPicture').click(function () {
            var uid = $(this).attr("rel");
            var op = '';
            op = $(this).attr("op");
            var url = '/demo/vSwoole-admin/Admin/Public/browseFile?stype=picture&uid=' + uid;
            if (op) {
                var url = '/demo/vSwoole-admin/Admin/Public/browseFile?stype=picture&uid=' + uid + '&op=' + op;
            }
            $.jBox("iframe:" + url, {
                    title: '图集',
                    width: 650,
                    height: 380,
                    buttons: {'关闭': true}
                }
            );
        });
        //全选/取消
        $("#check").click(function () {
            if ($(this).attr("checked") == "checked") {
                setCheckbox(true);
            } else {
                setCheckbox(false);
            }

        });


        /*
          列表中全选的js 和获取checkbox选中的值
        */
        $(function () {
            $("#checkAll").click(function () {
                if ($(this).attr("checked") == "checked") {
                    //$("input[name='checkList']").attr("checked",$(this).attr("checked"));
                    $("input[name='checkList']").parent().addClass("checked");
                } else {
                    $("input[name='checkList']").parent().removeClass("checked");
                }
            });
        });

        function getCheckBoxValue() {
            var str = '';
            $(".checked>input").each(function () {
                if ($(this).attr('id') != 'checkAll') {
                    str += $(this).val() + ',';
                }
            });
            str = str.substr(0, str.length - 1);
            return str;
        }
    });
    /*
      列表中全选的js 和获取checkbox选中的值
    */
    $(function () {
        $("#checkAll").click(function () {
            if ($(this).attr("checked") == "checked") {
                //$("input[name='checkList']").attr("checked",$(this).attr("checked"));
                $("input[name='checkList']").parent().addClass("checked");
            } else {
                $("input[name='checkList']").parent().removeClass("checked");
            }
        });
    });

    function getCheckBoxValue() {
        var str = '';
        $(".checked>input").each(function () {
            if ($(this).attr('id') != 'checkAll') {
                str += $(this).val() + ',';
            }
        });
        str = str.substr(0, str.length - 1);
        return str;
    }

    var Interact = {
        success_report: function (message) {
            $.confirm({
                title: message,
                level: 'success',
                buttons: {
                    "确定": {
                        class: "blue"
                    }
                }
            })
        },
        error_report: function (message) {
            $.confirm({
                title: message,
                level: 'danger',
                buttons: {
                    "确定": {
                        class: "blue"
                    }
                }
            })
        },
        warning_report: function (message, callback) {
            $.confirm({
                title: message,
                level: 'warning',
                buttons: {
                    "确定": {
                        class: "blue",
                        action: function () {
                            callback && callback();
                        }
                    },
                    "取消": {
                        class: "blue"
                    }
                }
            })
        },
        loading_report: function (message) {
            $.refreshWindow.open(message);
        },
        loading_close: function () {
            $.refreshWindow.close();
        }
    }


</script>
</body>
</html>