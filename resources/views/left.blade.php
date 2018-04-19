                <div class="col-md-2 bootstrap-admin-col-left">
                    @if(Auth::user()->level >= 1)
                     <ul class="nav navbar-collapse collapse bootstrap-admin-navbar-side">
                         <li @if(request()->getRequestUri() == '/home')class="active"@endif>
                            <a href="/home"><i class="glyphicon glyphicon-chevron-right"></i> 申请列表</a>
                        </li>
                        
                        <li @if(request()->getRequestUri() == '/user')class="active"@endif>
                            <a href="/user"><i class="glyphicon glyphicon-chevron-right"></i> 用户管理</a>
                        </li>
                    </ul>
                    @endif
                </div>