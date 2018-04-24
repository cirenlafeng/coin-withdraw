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
               
                <!-- content -->
                <div class="col-md-10">

                    <div class="row bootstrap-admin-no-edges-padding">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">{{ $phone }} 的邀请详情</div>
                                </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>uuid</th>
                                                <th>手机号</th>
                                                <th>区号</th>
                                                <th>邀请人数</th>
                                                <th>父id</th>
                                                <th>金币</th>
                                                <th>创建时间</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $val)
                                            <tr>
                                                <td>{{ $val['uuid'] }}</td>
                                                <td>{{ $val['phone'] }}</td>
                                                <td>{{ $val['country_code'] }}</td>
                                                <td>{{ $val['share_code'] }}</td>
                                                <td>{{ $val['p_id'] }}</td>
                                                <td>{{ $val['coin'] }}</td>
                                                <td>{{ $val['created_at'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <ul class="pager wizard">
                                        @if($page > 1)
                                        <li class="next last" style="float: left;"><a href="/inviteInfo?id={{$id}}&page={{$page - 1}}">上一页</a></li>
                                        @endif
                                        <li class="next"><a href="/inviteInfo?id={{$id}}&page={{$page + 1}}">下一页</a></li>
                                    </ul>
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
        function chulizhong(ids)
        {
            var id = ids;
            $('#'+id).html('处理中..');
            $('#'+id).attr("disabled", true); 
        }
    </script>
    </body>
</html>