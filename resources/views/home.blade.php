<!DOCTYPE html>
<html>
    <head>
        <title>首页</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/bootstrap-theme.min.css" rel="stylesheet" media="screen">

        <!-- Bootstrap Admin Theme -->
        <link href="css/bootstrap-admin-theme.css" rel="stylesheet" media="screen">

        <!-- Vendors -->
        <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="vendors/easypiechart/jquery.easy-pie-chart_custom.css" rel="stylesheet" media="screen">
<?php


?>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
           <script type="text/javascript" src="js/html5shiv.js"></script>
           <script type="text/javascript" src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bootstrap-admin-with-small-navbar">
    @include('top')

        <div class="container">
            <!-- left, vertical navbar & content -->
            <div class="row">
                <!-- left, vertical navbar -->
                @include('left')
                <!-- content -->
                <div class="col-md-10">

                    <div class="row bootstrap-admin-no-edges-padding">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">列表</div>
                                </div>
<div class="bootstrap-admin-panel-content">
<form action="" method="get">
        申请类型：
        <select id="check_type" name="check_type" >
            <option value="off" @if(Request::input('check_type','off')=='off') selected @endif> - </option>
            <option value="1" @if(Request::input('check_type')==1) selected @endif>自动</option>
            <option value="2" @if(Request::input('check_type')==2) selected @endif>人工</option>
        </select>
        &nbsp;&nbsp;
        申请状态：
        <select id="status" name="status" >
            <option value="off" @if(Request::input('status','off')=='off') selected @endif> - </option>
            <option value="0" @if(null !==Request::input('status') && Request::input('status')=='0') selected @endif>待审核</option>
            <option value="1" @if(Request::input('status')=='1') selected @endif>通过</option>
            <option value="-1" @if(Request::input('status')== '-1') selected @endif>未通过</option>
        </select>
        &nbsp;&nbsp;
        <input type="submit" name="" value="提交">
</form>
<br><br>
</div>
@if (session('statusTask'))
    <div class="alert alert-success">
        {{ session('statusTask') }}
    </div>
@endif
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>区号</th>
                                                <th>手机号</th>
                                                <th>类型</th>
                                                <th>金额</th>
                                                <th>状态</th>
                                                <th>申请时间</th>
                                                <th>审核时间</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($taskList as $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->area }}</td>
                                                <td>{{ $val->phone }}</td>
                                                <td>
                                                    @if($val->check_type == 1)
                                                    自动
                                                    @endif
                                                    @if($val->check_type == 2)
                                                    人工
                                                    @endif
                                                </td>
                                                <td>{{ rtrim(rtrim($val->money, '0'), '.') }}</td>
                                                <td>
                                                    @if($val->status == '0')
                                                    待审核
                                                    @endif
                                                    @if($val->status == '1')
                                                    通过
                                                    @endif
                                                    @if($val->status == '-1')
                                                    未通过
                                                    @endif
                                                </td>
                                                <td>{{ date('Y-m-d H:i:s',$val->create_time) }}</td>
                                                <td>
                                                    @if($val->check_time == 0)
                                                    /
                                                    @endif
                                                    @if($val->check_time > 0)
                                                    {{ date('Y-m-d H:i:s',$val->check_time) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($val->status == '0')
                                                    <a href="/inviteInfo?id={{$val->id}}&page=1" target="_blank">邀请详情</a>
                                                    &nbsp;&nbsp;
<form style="margin:0px;display:inline;" action="/check/pass?id={{$val->id}}" method="post" id="pass_{{$val->id}}">
    {{ csrf_field() }}
<input type="submit" name="pass" value="通过" class="btn btn-sm btn-success" onclick="javascript:{document.pass_{{$val->id}}.submit();this.disabled=true;}">
</form>
&nbsp;&nbsp;
<form style="margin:0px;display:inline;" action="/check/miss?id={{$val->id}}" method="post" id="miss_{{$val->id}}">
    {{ csrf_field() }}
<input type="submit" name="miss" value="拒绝" class="btn btn-sm btn-danger" onclick="javascript:{document.miss_{{$val->id}}.submit();this.disabled=true;}">
</form>
                                                    @endif
                                                    @if($val->status != '0')
                                                    已处理
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $taskList->appends(Request::input())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/twitter-bootstrap-hover-dropdown.min.js"></script>
        <script type="text/javascript" src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="/framework/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            $(function() {
                // Easy pie charts
                $('.easyPieChart').easyPieChart({animate: 1000});
            });
        </script>
        <script type="text/javascript">
       window.onload = function(){ 

        $('#selectDate').datepicker({
            format: 'yyyy-mm-dd'
        });
    };
        $('form').submit(function() {
            $('input[type=submit]').attr('disabled', true);
        });
    </script>
    </body>
</html>