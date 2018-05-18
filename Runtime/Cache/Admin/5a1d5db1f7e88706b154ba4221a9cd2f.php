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
            <div class="page-content">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="portlet-config"
                     class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                                <h4 class="modal-title">Modal title</h4>
                            </div>
                            <div class="modal-body">
                                Widget settings form goes here
                            </div>
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
                <!-- <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="#">竞猜</a>
                        <i class="fa fa-circle"></i>
                    </li>
                </ul> -->
                <!-- END PAGE BREADCRUMB -->
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <!-- 注释 查询开始  -->
                <!--<div class="row">
                    <div class="col-md-12">
                        <div class="portlet box">
                            <div class="portlet-body form">

                                <form role="form" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">题目时间校准：</label>
                                            <div class="col-md-7">
                                                <input type="text" name="qa-time-check-start" class="form-control input-medium qa-check-time" placeholder="初始时间" style="display: inline-block;">到
                                                <input type="text" name="qa-time-check-end" class="form-control input-medium qa-check-time" placeholder="目标时间" style="display: inline-block;">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn blue" type="button" stage_id="<?php echo ($data['pageParam']['stage_id']); ?>" id="checkQaTime">校准</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>-->
                <!-- 注释 查询结束  -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-edit"></i><?php echo ($data['pageTitle']); ?>
                                </div>
                            </div>
                            <style>
                                .table-bordered th {
                                    text-align: center
                                }
                            </style>
                            <div class="portlet-body">
                                <button style="margin-bottom:5px;" class="btn blue" type="button" id="qa-add">新建问答
                                </button>
                                <button style="margin-bottom:5px;" class="btn blue" type="button" id="qa-backDb">备份数据库
                                </button>
                                <button style="margin-bottom:5px;" class="btn blue" type="button" id="qa-init">重置题目
                                </button>
                                <button style="margin-bottom:5px;" class="btn blue" type="button" id="qa-sync" qa-sync-status="1">预热缓存
                                </button>
                                <button style="margin-bottom:5px;" class="btn blue" type="button" id="qa-cancelSync" qa-sync-status="0">撤销预热
                                </button>

                                <span class="qa-backDb-info"></span>
                                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                    <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>问答ID</th>
                                        <th>所属期数</th>
                                        <th>所属分组</th>
                                        <th>问答类型</th>
                                        <th width="180px;">答题时区</th>
                                        <th>问答计时</th>
                                        <th width="90px;">答案推送时间</th>
                                        <th width="150px;">问答题面</th>
                                        <!--<th width="150px;">二级题面</th>-->
                                        <!--<th>选手得分</th>-->
                                        <th>备注</th>
                                        <!--<th>问答题面图片</th>-->
                                        <!--<th>问答选项</th>-->
                                        <!--<th>问答选项图片</th>-->
                                        <!--<th>问答答案</th>-->
                                        <th>题目序号</th>
                                        <!--<th width="90px;">更新时间</th>-->
                                        <th width="60px;">是否预热</th>
                                        <th width="60px;">题目是否推送</th>
                                        <th width="60px;">答案是否推送</th>
                                        <!--<th width="60px;">选手问答状态</th>-->
                                        <!--<th width="60px;">百人团问答状态</th>-->
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($data['pageInfo'])): if(is_array($data['pageInfo'])): foreach($data['pageInfo'] as $key=>$vo): ?><tr>
                                                <td><?php echo ($key + 1); ?></td>
                                                <td><?php echo ($vo["id"]); ?></td>
                                                <td><?php echo ($data['stage_info']['stage_name']); ?></td>
                                                <td><?php echo ($data['group_info']['group_title']); ?></td>
                                                <td><?php echo ($vo["qa_type_name"]); ?></td>
                                                <td><?php echo ($vo["qa_time"]); ?></td>
                                                <td><?php echo ($vo["qa_countdown"]); ?></td>
                                                <td><?php echo ($vo["qa_res_time"]); ?></td>
                                                <td><?php echo ($vo["qa_subject"]); ?></td>
                                                <!--<td><?php echo ($vo["qa_title"]); ?></td>-->
                                                <!-- <td>
                                                     <?php if($vo["qa_is_used"] == '1'): if($vo["qa_xs_right"] == '1'): echo ($vo["qa_xs_name"]); ?>：<?php echo ($vo["qa_xs_score"]); ?>
                                                             <?php elseif($vo["qa_xs_right"] == '0'): ?>
                                                             选手答错：<?php echo ($vo["qa_xs_score"]); ?>
                                                             <?php else: ?>
                                                             选手未答题：<?php echo ($vo["qa_xs_score"]); endif; ?>
                                                         <?php else: ?>
                                                         未开始<?php endif; ?>
                                                 </td>-->
                                                 <td><?php echo ($vo["qa_remark"]); ?></td>
                                                <!--<?php if($vo["qa_subject_img"] != '0'): ?><td><a target="_blank" href="<?php echo ($vo["qa_subject_img"]); ?>"><img src="<?php echo ($vo["qa_subject_img"]); ?>" style="width: 50px;height: 50px;" /></a></td>
                                                <?php else: ?>
                                                    <td></td><?php endif; ?>-->
                                               <!-- <td style="text-align: left">
                                                    <?php if(is_array($vo["qa_options"])): foreach($vo["qa_options"] as $k=>$v): if($v["option_title"] != null): echo ($v["option_number"]); ?>.<?php echo ($v["option_title"]); endif; ?>
                                                        <br><?php endforeach; endif; ?>
                                                </td>-->
                                                <!--<td style="text-align: left">
                                                    <?php if(is_array($vo["qa_options"])): foreach($vo["qa_options"] as $k=>$v): if($v["option_img"] != '0'): echo ($v["option_number"]); ?>.<a target="_blank" href="<?php echo ($v["option_img"]); ?>"><img src="<?php echo ($v["option_img"]); ?>" style="width: 50px;height: 50px;" /></a><?php endif; ?>
                                                        <br><?php endforeach; endif; ?>
                                                </td>-->
                                                <!--<td><?php echo ($vo["qa_right_key"]); ?></td>-->
                                                <td><?php echo ($vo["qa_extend"]); ?></td>
                                                <!--<td><?php echo (date("Y-m-d H:i:s",$vo["qa_updated"])); ?></td>-->
                                                <td>
                                                    <?php if($vo["qa_sync_status"] == '0'): ?>未预热
                                                        <?php else: ?>
                                                        <span style="color: red;">已预热</span><?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($vo["qa_is_used"] == '0'): ?>未推送
                                                        <?php else: ?>
                                                        <span style="color: red;">已推送</span><?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($vo["qa_res_is_pushed"] == '0'): ?>未推送
                                                        <?php else: ?>
                                                        <span style="color: red;">已推送</span><?php endif; ?>
                                                </td>
                                                <!--<td>
                                                    <?php if($vo["qa_player_status"] == '0'): ?>未开启
                                                        <br>
                                                        <a><i qa_id="<?php echo ($vo["id"]); ?>" qa_status="1" class="glyphicon glyphicon-play qa-switch" status_type="1" title="点击开启选手答题"></i></a>
                                                        <?php else: ?>
                                                        <span style="color: red;">已开启</span>
                                                        <br>
                                                        <a><i qa_id="<?php echo ($vo["id"]); ?>" qa_status="0" class="glyphicon glyphicon-stop qa-switch" status_type="1" title="点击关闭选手答题"></i></a><?php endif; ?>
                                                </td>-->
                                                <!--<td>
                                                    <?php if($vo["qa_normal_status"] == '0'): ?>未开启
                                                        <br>
                                                        <a><i qa_id="<?php echo ($vo["id"]); ?>" qa_status="1" class="glyphicon glyphicon-play qa-switch" status_type="2" title="点击开启百人团答题"></i></a>
                                                        <?php else: ?>
                                                        <span style="color: red;">已开启</span>
                                                        <br>
                                                        <a><i qa_id="<?php echo ($vo["id"]); ?>" qa_status="0" class="glyphicon glyphicon-stop qa-switch" status_type="2" title="点击关闭百人团答题"></i></a><?php endif; ?>
                                                </td>-->
                                                <td style="width:150px;">
                                                    <?php if($vo["qa_player_status"] == '0' and $vo["qa_normal_status"] == '0'): ?><a><i qa_id="<?php echo ($vo["id"]); ?>" qa_status="1" class="glyphicon glyphicon-play qa-switch" status_type="0" title="点击开启答题"></i></a>
                                                        <?php else: ?>
                                                        <a><i qa_id="<?php echo ($vo["id"]); ?>" qa_status="0" class="glyphicon glyphicon-stop qa-switch" status_type="0" title="点击关闭答题"></i></a><?php endif; ?>
                                                    <a><i qa_id="<?php echo ($vo["id"]); ?>" class="glyphicon glyphicon-edit qa-edit" title="编辑"></i></a>
                                                    <a><i qa_id="<?php echo ($vo["id"]); ?>" stage_id="<?php echo ($vo["stage_id"]); ?>" column_id="<?php echo ($data["column_info"]["column_id"]); ?>" group_id="<?php echo ($vo["group_id"]); ?>" class="glyphicon glyphicon-send qa-send" title="推送题目"></i></a>
                                                    <a><i qa_id="<?php echo ($vo["id"]); ?>" stage_id="<?php echo ($vo["stage_id"]); ?>" column_id="<?php echo ($data["column_info"]["column_id"]); ?>" group_id="<?php echo ($vo["group_id"]); ?>" class="glyphicon glyphicon-plane qa-send-res" title="推送答案"></i></a>
                                                    <a><i qa_id="<?php echo ($vo["id"]); ?>" class="glyphicon glyphicon-resize-full qa-full" title="详细展开"></i></a>
                                                    <!--<a><i qa_id="<?php echo ($vo["id"]); ?>" class="glyphicon glyphicon-list-alt qa-detail" title="答题详情"></i></a>-->
                                                    <a><i qa_id="<?php echo ($vo["id"]); ?>" class="glyphicon glyphicon-refresh qa-refresh" title="刷新题目"></i></a>
                                                    <a><i qa_id="<?php echo ($vo["id"]); ?>" qa_player_status="<?php echo ($vo["qa_player_status"]); ?>" qa_normal_status="<?php echo ($vo["qa_normal_status"]); ?>" class="glyphicon glyphicon-trash qa-delete" title="删除"></i></a>
                                                </td>
                                            </tr><?php endforeach; endif; ?>
                                        <?php else: ?>
                                        <td colspan="24" class="text-center"> aOh! 暂时还没有内容!</td><?php endif; ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-5 col-sm-12">
                                        <div class="dataTables_info" id="sample_editable_1_info" role="status"
                                             aria-live="polite">
                                            当前是第 <?php echo ($data['page']['p']); ?> 页 总页数 <?php echo ($data['page']['totalPage']); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-12">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                             id="sample_editable_1_paginate">
                                            <?php echo ($data['page']['show']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>

                <!-- END PAGE CONTENT-->
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        //添加题目
        $("#qa-add").on('click', function () {
            var url = "<?php echo U('Qa/addEdit');?>" + '&stage_id=' + "<?php echo ($data['pageParam']['stage_id']); ?>" + '&group_id=' + "<?php echo ($data['pageParam']['group_id']); ?>";
            window.location.href = url;
        })
        //编辑数据
        $(".qa-edit").on('click', function () {
            var qa_id = $(this).attr('qa_id');
            var url = "<?php echo U('Qa/addEdit');?>";
            url = url + '&stage_id=' + "<?php echo ($data['pageParam']['stage_id']); ?>" + '&group_id=' + "<?php echo ($data['pageParam']['group_id']); ?>" + '&qa_id=' + qa_id;
            window.location.href = url;
        })
        //刷新题目
        $(".qa-refresh").on('click', function () {
            var qa_id = $(this).attr('qa_id');
            $.confirm({
                title: '确认刷新当前问答题目吗？',
                level: 'warning',
                buttons: {
                    "确定": {
                        class: "blue",
                        action: function () {
                            $.ajax({
                                url: "<?php echo U('Qa/refresh');?>",
                                type: 'GET',
                                data: {qa_id: qa_id},
                                dataType: 'JSON',
                                success: function (msg) {
                                    console.log(msg);
                                    $.confirm({
                                        title: msg.info,
                                        level: 'success',
                                        buttons: {
                                            "确定": {
                                                class: "blue",
                                                action: function () {
                                                    msg.status == 1 && window.location.reload();
                                                }
                                            }
                                        }
                                    })
                                },
                                error: function () {
                                    console.log('refresh error');
                                }
                            })
                        }
                    },
                    "取消": {
                        "class": "green",
                        "action": function () {
                        }
                    }
                }
            })

        })
        //答题详情
        $(".qa-detail").on('click', function () {
            var qa_id = $(this).attr('qa_id');
            var timer = null;
            var flag = true;
            var options = {
                title: '问答详细信息',
                id: 'qa-detail-table',
                width: 1200,
                height: 550,
                border: 0,
                top: '10%',
                buttons: {'自动刷新': true},
                submit: function () {
                    $("#qa-detail-table .jbox-button").attr('disabled', true);
                    timer = setInterval(function () {
                        getDetail();
                    }, 1000);
                    return false;
                },
                closed: function () {
                    clearInterval(timer);
                }
            }
            getDetail();

            function getDetail() {
                if (!flag) return;
                flag = false;
                $.ajax({
                    url: "<?php echo U('Qa/detail');?>",
                    type: 'GET',
                    data: {qa_id: qa_id},
                    dataType: 'JSON',
                    success: function (msg) {
                        console.log(msg);
                        if (msg.status == 1) {
                            var html = '<div class="qa-brt">百人团：</div>';
                            if (msg.data['brt']) {
                                var v = msg.data['brt'];
                                var count = 0;
                                html += '<table class="table table-striped table-hover table-bordered"><thead>';
                                html += '<tr><th>ID</th><th>ID</th><th>ID</th><th>ID</th><th>ID</th><th>ID</th><th>ID</th><th>ID</th><th>ID</th><th>ID</th></tr>';
                                html += '</thead><tbody>';
                                for (var i = 1; i <= 80;) {
                                    html += '<tr>';
                                    for (var j = 0; j < 10; j++) {
                                        if (v[i + j]) {
                                            count++;
                                            var is_right = v[i + j]["is_right"] == 1 ? '对' : '错';
                                            html += '<td style="width:75px;height:35px;">' + v[i + j]["user_id"] + '：' + is_right + '</td>';
                                        } else {
                                            html += '<td style="width:75px;height:35px;"></td>';
                                        }
                                    }
                                    html += '</tr>';
                                    i = i + 10;
                                }
                                html += '</tbody></table>';
                            } else {
                                html += "百人团未答题<br>";
                            }
                            html += '<div class="qa-xs">选手：</div>';
                            if (msg.data['xs']) {
                                var v = msg.data['xs'];
                                $.each(v, function (item, val) {
                                    var is_right = val["is_right"] == 1 ? '对' : '错';
                                    html += val['user_id'] + '：' + is_right + "<br>";
                                })
                            } else {
                                html += "选手未答题<br>";
                            }
                            html += '<div class="qa-ysj">艺术家：</div>';
                            if (msg.data['ysj']) {
                                var v = msg.data['ysj'];
                                $.each(v, function (item, val) {
                                    var is_right = val["is_right"] == 1 ? '对' : '错';
                                    html += val['user_id'] + '：' + is_right + "<br>";
                                })
                            } else {
                                html += '艺术家未答题';
                            }
                            $("#qa-detail-table").length > 0 ? $("#jbox-content").html(html) : $.jBox(html, options);
                            $(".qa-brt").append(count);
                            flag = true;
                        } else {
                            $.confirm({
                                title: '该题无答题数据',
                                level: 'warning',
                                buttons: {
                                    "确定": {
                                        class: "blue"
                                    }
                                }
                            })
                        }
                    },
                    error: function () {
                        console.log('get detail error');
                    }
                })
            }
        })
        //详细展开
        $(".qa-full").on('click', function () {
            var qa_id = $(this).attr('qa_id');
            var options = {
                title: '问答详细信息',
                width: 1100,
                border: 0,
                top: '25%'
            }
            $.ajax({
                url: "<?php echo U('Qa/getQaInfo');?>",
                type: 'GET',
                data: {qa_id: qa_id},
                dataType: 'JSON',
                success: function (msg) {
                    console.log(msg);
                    if (msg.status == 1) {
                        var v = msg.data;
                        var html = '<table class="table table-striped table-hover table-bordered"><thead>';
                        html += '<tr><th>问答题面</th><th>二级题面</th><th>问答题面图片</th><th style="width:150px;">问答选项</th><th>问答选项图片</th><th style="width:150px;">问答答案</th><th>绑定模块</th><th>备注</th><th>嘉宾扩展</th><th>主持人点评</th></tr>';
                        html += '</thead><tbody>';
                        html += '<tr>';
                        html += '<td>' + v.qa_subject + '</td>';
                        html += '<td>' + v.qa_title + '</td>';
                        if (v.qa_subject_img != 0) {
                            html += '<td><a target="_blank" href="' + v.qa_subject_img + '"><img src="' + v.qa_subject_img + '" style="width: 50px;height: 50px;" /></a></td>';
                        } else {
                            html += '<td></td>';
                        }
                        html += '<td>';
                        if (v.qa_options) {
                            $.each(v.qa_options, function (key, val) {
                                if (val.option_title) {
                                    html += val.option_number + '.' + val.option_title + '<br>';
                                } else {
                                    html += '';
                                }
                            })
                        }
                        html += '</td><td>';
                        if (v.qa_options) {
                            $.each(v.qa_options, function (key, val) {
                                if (val.option_img != 0) {
                                    html += val.option_number + '.<a target="_blank" href="' + val.option_img + '"><img src="' + val.option_img + '" style="width: 50px;height: 50px;" /></a><br>';
                                } else {
                                    html += '';
                                }
                            })
                        }
                        html += '</td><td>';
                        if (v.qa_right_key) {
                            $.each(v.qa_right_key, function (key, val) {
                                if (v.qa_type == 7 || v.qa_type == 14) {
                                    html += key + '---' + val + '<br>';
                                } else {
                                    html += val + '<br>';
                                }
                            })
                        }
                        html += '</td><td>';
                        if (v.qa_bind_modules) {
                            $.each(v.qa_bind_modules, function (key, val) {
                                $.each(val, function (k, v) {
                                    html += k + '：' + v + '<br>';
                                })
                            })
                        }
                        html += '</td><td>' + v.qa_remark + '</td>';
                        html += '</td><td>' + v.qa_extend + '</td>';
                        html += '</td><td>' + v.qa_extend_zcr + '</td>';
                        html += '</tbody></table>';
                        $.jBox(html, options);
                    } else {
                        $.confirm({
                            title: msg.info,
                            level: 'warning',
                            buttons: {
                                "确定": {
                                    class: "blue"
                                }
                            }
                        })
                    }
                },
                error: function () {
                    console.log('get error');
                }
            })
        })

        //开启关闭分组
        $(".qa-switch").on('click', function () {
            var this_flag = true;
            var data = {
                qa_id: $(this).attr('qa_id'),
                qa_status: $(this).attr('qa_status'),
                status_type: $(this).attr('status_type')
            }

            if (data['status_type'] == 1 || data['status_type'] == 2) {
                var type = data['status_type'] == 1 ? '选手' : '百人团';
            } else {
                var type = '';
            }
            var title = data['qa_status'] == 1 ? '确认开启当前' + type + '问答？' : '确认关闭当前' + type + '问答？';

            if (data['qa_status'] == 1) {
                $('.qa-switch').each(function (k, v) {
                    if ($(this).attr('qa_status') == 0 && $(this).attr('qa_id') != data['qa_id']) {
                        this_flag = false;
                        $.confirm({
                            title: '当前已有其他开启问答,点击"确定"将强制关闭已开启问答,然后开启当前' + type + '问答!',
                            level: 'danger',
                            buttons: {
                                "确定": {
                                    class: "blue",
                                    action: function () {
                                        $.ajax({
                                            url: "<?php echo U('Qa/switchQa');?>",
                                            type: 'POST',
                                            dataType: 'JSON',
                                            data: data,
                                            timeout: 20000,
                                            success: function (msg) {
                                                console.log(msg);
                                                if (msg.status == 1) {
                                                    $.cookie('do_qa_status', data['qa_status']);
                                                    window.location.reload();
                                                } else if (msg.status == -2) {
                                                    $.confirm({
                                                        title: msg.info,
                                                        level: 'warning',
                                                        buttons: {
                                                            "确定": {
                                                                class: "blue",
                                                                action: function () {
                                                                    window.location.href = "<?php echo U('Stage/index');?>";
                                                                }
                                                            }
                                                        }
                                                    })
                                                } else {
                                                    $.confirm({
                                                        title: '操作失败，请重新操作',
                                                        level: 'warning',
                                                        buttons: {
                                                            "确定": {
                                                                class: "blue",
                                                                action: function () {
                                                                    window.location.reload();
                                                                }
                                                            }
                                                        }
                                                    })
                                                }
                                            },
                                            error: function () {
                                                $.confirm({
                                                    title: '操作失败，请联系开发人员',
                                                    level: 'warning',
                                                    buttons: {
                                                        "确定": {
                                                            class: "blue"
                                                        }
                                                    }
                                                })
                                            }
                                        })
                                    }
                                },
                                "取消": {
                                    "class": "green",
                                    "action": function () {
                                    }
                                }
                            }
                        })
                        return false;
                    }
                })
            }

            if (!this_flag) {
                return false;
            }

            $.confirm({
                title: title,
                level: 'warning',
                buttons: {
                    "确定": {
                        class: "blue",
                        action: function () {
                            $.ajax({
                                url: "<?php echo U('Qa/switchQa');?>",
                                type: 'POST',
                                dataType: 'JSON',
                                data: data,
                                timeout: 20000,
                                success: function (msg) {
                                    console.log(msg);
                                    if (msg.status == 1) {
                                        $.cookie('do_qa_status', data['qa_status']);
                                        window.location.reload();
                                    } else if (msg.status == -2) {
                                        $.confirm({
                                            title: msg.info,
                                            level: 'warning',
                                            buttons: {
                                                "确定": {
                                                    class: "blue",
                                                    action: function () {
                                                        window.location.href = "<?php echo U('Stage/index');?>";
                                                    }
                                                }
                                            }
                                        })
                                    } else {
                                        $.confirm({
                                            title: '操作失败，请重新操作',
                                            level: 'warning',
                                            buttons: {
                                                "确定": {
                                                    class: "blue",
                                                    action: function () {
                                                        window.location.reload();
                                                    }
                                                }
                                            }
                                        })
                                    }
                                },
                                error: function () {
                                    $.confirm({
                                        title: '操作失败，请联系开发人员',
                                        level: 'warning',
                                        buttons: {
                                            "确定": {
                                                class: "blue"
                                            }
                                        }
                                    })
                                }
                            })
                        }
                    },
                    "取消": {
                        "class": "green",
                        "action": function () {
                        }
                    }
                }
            })
        })
        //手动备库
        $("#qa-backDb").on('click', function () {
            $.ajax({
                url: "<?php echo U('Qa/bakDb');?>",
                type: 'POST',
                dataType: 'JSON',
                timeout: 20000,
                success: function (msg) {
                    console.log(msg);
                    if (msg.status == 1) {
                        $(".qa-backDb-info").text(new Date());
                    } else {
                        $(".qa-backDb-info").text('备份失败');
                    }
                },
                error: function () {
                    console.log('back error');
                }
            })
        })

        //删除
        $(".qa-delete").on('click', function () {
            var qa_normal_status = $(this).attr('qa_normal_status');
            var qa_player_status = $(this).attr('qa_player_status');
            var this_qa_id = $(this).attr('qa_id');
            var this_flag = true;
            var $this = this;

            if (qa_normal_status == 1 || qa_player_status == 1) {
                this_flag = false;
                $.confirm({
                    title: '当前题目正在开启中，请关闭后再执行删除操作',
                    level: 'danger',
                    buttons: {
                        "确定": {
                            class: "blue"
                        }
                    }
                })
            }
            if (!this_flag) {
                return false;
            }

            $.confirm({
                title: '确认删除当前题目吗？',
                level: 'warning',
                buttons: {
                    "确定": {
                        class: "blue",
                        action: function () {
                            $.ajax({
                                url: "<?php echo U('Qa/deleteQa');?>",
                                type: 'GET',
                                data: {qa_id: this_qa_id},
                                dataType: 'JSON',
                                success: function (msg) {
                                    console.log(msg);
                                    if (msg.status == 1) {
                                        $($this).parent().parent().parent().remove();
                                    } else if (msg.status == -2) {
                                        $.confirm({
                                            title: '当前题目正在开启中，请关闭后再执行删除操作!',
                                            level: 'danger',
                                            buttons: {
                                                "确定": {
                                                    class: "blue"
                                                }
                                            }
                                        })
                                    } else {
                                        $.confirm({
                                            title: '删除失败，请重新尝试',
                                            level: 'warning',
                                            buttons: {
                                                "确定": {
                                                    class: "blue"
                                                }
                                            }
                                        })
                                    }
                                },
                                error: function () {
                                    $.confirm({
                                        title: '删除失败，请刷新后重新尝试',
                                        level: 'warning',
                                        buttons: {
                                            "确定": {
                                                class: "blue"
                                            }
                                        }
                                    })
                                }
                            })
                        }
                    },
                    "取消": {
                        "class": "green",
                        "action": function () {
                        }
                    }
                }
            })
        })

        //推送题目
        $(".qa-send").on('click', function () {
            var column_id = $(this).attr('column_id');
            var stage_id = $(this).attr('stage_id');
            var group_id = $(this).attr('group_id');
            var qa_id = $(this).attr('qa_id');
            $.confirm({
                title: '您确认立即推送该题目吗？',
                level: 'warning',
                buttons: {
                    "确定": {
                        class: "blue",
                        action: function () {
                            $.ajax({
                                url: "<?php echo U('Qa/sendQa');?>",
                                type: 'POST',
                                data: {column_id: column_id, stage_id: stage_id, group_id:group_id,qa_id: qa_id},
                                dataType: 'json',
                                success: function (res) {
                                    $.confirm({
                                        title: res.msg,
                                        level: 'success',
                                        buttons: {
                                            "确定": {
                                                class: "blue",
                                                action: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        }
                                    })
                                },
                                error: function (e) {
                                    alert(e.statusText);
                                }
                            })
                        }
                    },
                    "取消": {
                        "class": "green",
                        "action": function () {
                        }
                    }
                }
            })
        })

        //推送答案
        $(".qa-send-res").on('click', function () {
            var column_id = $(this).attr('column_id');
            var stage_id = $(this).attr('stage_id');
            var group_id = $(this).attr('group_id');
            var qa_id = $(this).attr('qa_id');
            $.confirm({
                title: '您确认立即推送该题目答案吗？',
                level: 'warning',
                buttons: {
                    "确定": {
                        class: "blue",
                        action: function () {
                            $.ajax({
                                url: "<?php echo U('Qa/sendQaRes');?>",
                                type: 'POST',
                                data: {column_id: column_id, stage_id: stage_id, group_id:group_id,qa_id: qa_id},
                                dataType: 'json',
                                success: function (res) {
                                    $.confirm({
                                        title: res.msg,
                                        level: 'success',
                                        buttons: {
                                            "确定": {
                                                class: "blue",
                                                action: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        }
                                    })
                                },
                                error: function (e) {
                                    alert(e.statusText);
                                }
                            })
                        }
                    },
                    "取消": {
                        "class": "green",
                        "action": function () {
                        }
                    }
                }
            })
        })

        //重置题目
        $("#qa-init").on('click', function () {
            var stage_id = "<?php echo ($data["stage_info"]["stage_id"]); ?>";
            var group_id = "<?php echo ($data["group_info"]["id"]); ?>";
            $.confirm({
                title: '(谨慎操作)您确认重置当前组所有题目状态吗？',
                level: 'warning',
                buttons: {
                    "确定": {
                        class: "blue",
                        action: function () {
                            $.ajax({
                                url: "<?php echo U('Qa/initQa');?>",
                                type: 'POST',
                                data: {stage_id: stage_id, group_id: group_id},
                                dataType: 'json',
                                success: function (res) {
                                    $.confirm({
                                        title: res.msg,
                                        level: 'success',
                                        buttons: {
                                            "确定": {
                                                class: "blue",
                                                action: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        }
                                    })
                                },
                                error: function (e) {
                                    alert(e.statusText);
                                }
                            })
                        }
                    },
                    "取消": {
                        "class": "green",
                        "action": function () {
                        }
                    }
                }
            })
        })

        //预热，撤销预热
        $("#qa-sync,#qa-cancelSync").on('click', function () {
            var sync_status = $(this).attr('qa-sync-status');
            var stage_id = "<?php echo ($data["stage_info"]["stage_id"]); ?>";
            var group_id = "<?php echo ($data["group_info"]["id"]); ?>";
            //var title = sync_status == 1 ? '确认预热当前组题目吗？' : '确认撤销当前组所有预热题目吗？';
            var title = sync_status == 1 ? '确认预热所有已开启分组的题目吗？' : '确认撤销所有预热题目吗？';
            $.confirm({
                title: title,
                level: 'warning',
                buttons: {
                    "确定": {
                        class: "blue",
                        action: function () {
                            $.ajax({
                                url: "<?php echo U('Qa/sync');?>",
                                type: 'POST',
                                data: {sync_status: sync_status, stage_id: stage_id, group_id: group_id},
                                dataType: 'json',
                                success: function (res) {
                                    $.confirm({
                                        title: res.msg,
                                        level: 'success',
                                        buttons: {
                                            "确定": {
                                                class: "blue",
                                                action: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        }
                                    })
                                },
                                error: function (e) {
                                    alert(e.statusText);
                                }
                            })
                        }
                    },
                    "取消": {
                        "class": "green",
                        "action": function () {
                        }
                    }
                }
            })
        })
    })
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