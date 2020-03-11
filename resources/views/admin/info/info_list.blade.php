@extends('admin.base')

@section('content')
@include('admin.breadcrumb')

<div class="layui-card">
    <div class="layui-form layui-card-header light-search">
        <form>
            <input type="hidden" name="action" value="search">
            @include('admin.searchField', ['data' => App\Model\Admin\Information::$searchField])
            <div class="layui-inline">
                <button class="layui-btn layuiadmin-btn-list" lay-filter="form-search" id="submitBtn">
                    <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="layui-card-body">
        <table class="layui-table" lay-data="{url:'{{ route('admin::information.list') }}?{{ request()->getQueryString() }}', page:true, limit:50, id:'test'}" lay-filter="test">
            <thead>
            <tr>
                <th lay-data="{width:50, type:'checkbox'}"></th>
                <th lay-data="{field:'info_id', width:80, sort: true}">ID</th>
                <th lay-data="{field:'info_title'}">标题</th>
                <th lay-data="{field: 'info_linkman'}">联系人</th>
                <th lay-data="{field:'info_mobile'}">手机号</th>
                <th lay-data="{field:'info_audit'}">审核</th>
                <th lay-data="{field:'created_at'}">创建时间</th>
                <th lay-data="{width:200, templet:'#action'}">操作</th>
            </tr>
            <tr>

            </tr>
            </thead>
        </table>
    </div>
</div>

@endsection
<script type="text/html" id="action">
    <a href="<% d.editUrl %>" class="layui-table-link" title="审核"><i class="layui-icon layui-icon-edit">审核</i></a>
    <a href="javascript:;" class="layui-table-link" title="删除" style="margin-left: 10px" onclick="deleteMenu('<% d.deleteUrl %>')"><i class="layui-icon layui-icon-delete">删除</i></a>
</script>
@section('js')
    <script>
        var laytpl = layui.laytpl;
        laytpl.config({
            open: '<%',
            close: '%>'
        });

        var laydate = layui.laydate;
        laydate.render({
            elem: '#created_at',
            range: '~'
        });
        function deleteMenu (url) {
            console.log(url);
            layer.confirm('确定删除？', function(index){
                $.ajax({
                    url: url,
                    data: {},
                    success: function (result) {
                        if (result.code !== 0) {
                            layer.msg(result.msg, {shift: 6});
                            return false;
                        }
                        layer.msg(result.msg, {icon: 1}, function () {
                            if (result.reload) {
                                location.reload();
                            }
                            if (result.redirect) {
                                location.href = '{!! url()->previous() !!}';
                            }
                        });
                    }
                });

                layer.close(index);
            });
        }
    </script>
@endsection