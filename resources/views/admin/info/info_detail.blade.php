@extends('admin.base')

@section('content')
    <div class="layui-card">

        @include('admin.breadcrumb')

<div class="layui-card-body">
    <form class="layui-form" action="{{ route('admin::information.save', ['info_id' => $id]) }}" method="post">
        {{--<input type="hidden" name="_method" value="PUT"> --}}
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="info_title" required  lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->info_title ?? ''  }}">
            </div>
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">资源图片</label>
            @foreach($info_resource_image as $val)
            <p class="imglogo-box" style="width: 66px;display:inline-block;margin-left:40px">
                <img id="img_logo" class="imglogo img-size" style='width:100px;height:100px' src="{{asset($val)}}">
            </p>
            @endforeach
        </div>
        <div class="layui-form-item" >
            <label class="layui-form-label">合作方图片</label>
            @foreach($info_partner_image as $val)
                <p class="imglogo-box" style="width: 66px;display:inline-block;margin-left:40px">
                    <img id="img_logo" class="imglogo img-size" style='width:100px;height:100px' src="{{asset($val)}}">
                </p>
            @endforeach
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">结算方式</label>
            <div class="layui-input-block">
                <select name="clearing_form" lay-verify="required">
                    <option value="1" @if($model['clearing_form']==1) selected @endif>CPS模式</option>
                    <option value="2" @if($model['clearing_form']==2) selected @endif>CPA模式</option>
                    <option value="3" @if($model['clearing_form']==3) selected @endif>CPT模式</option>
                    <option value="4" @if($model['clearing_form']==4) selected @endif>CPC模式</option>
                    <option value="5" @if($model['clearing_form']==5) selected @endif>CPM模式</option>
                    <option value="6" @if($model['clearing_form']==6) selected @endif>ROI</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">联系人</label>
            <div class="layui-input-block">
                <input type="text" name="info_linkman" autocomplete="off" class="layui-input" value="{{ $model->info_linkman ?? ''  }}">
            </div>
        </div> <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-block">
                <input type="text" name="info_mobile" autocomplete="off" class="layui-input" value="{{ $model->info_mobile ?? ''  }}">
            </div>
        </div> <div class="layui-form-item">
            <label class="layui-form-label">合作区域</label>
            <div class="layui-input-block">
                <input type="text" name="cooperation_area" autocomplete="off" class="layui-input" value="{{ $model->cooperation_area ?? ''  }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">审核不成功原因</label>
            <div class="layui-input-block">
                <textarea name="audit_cause" id="audit_cause" class="layui-textarea">{{ $model->audit_cause ?? ''  }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formAdminUser" id="submitBtn">审核通过</button>
                <button type="reset" class="layui-btn layui-btn-primary" onclick="postsubmit(3)">审核不通过</button>
            </div>
        </div>
    </form>
</div>
</div>


@endsection

@section('js')
    <script>

        var form = layui.form;
        //监听提交
        form.on('submit(formAdminUser)', function(data){
            window.form_submit = $('#submitBtn');
            form_submit.prop('disabled', true);
            var start=2;
            $.ajax({
                url: data.form.action,
                data: {"number":start,"keyword":'info_audit','_token':'{{csrf_token()}}'},
                success: function (result) {
                    if (result.code !== 0) {
                        form_submit.prop('disabled', false);
                        layer.msg(result.msg, {shift: 6});
                        return false;
                    }
                    layer.msg(result.msg, {icon: 1}, function () {
                        if (result.reload) {
                            location.href = '{!! url()->previous() !!}';
                            // location.reload();
                        }
                        if (result.redirect) {
                            location.href = '{!! url()->previous() !!}';
                        }
                    });
                }
            });

            return false;
        });
       function postsubmit(start){
           remake=$('#audit_cause').val();
           var url=$('.layui-form').attr('action');
            $.ajax({
                url: url,
                data: {"number":start,"remake":remake,"keyword":'info_audit','_token':'{{csrf_token()}}'},
                success: function (result) {
                    console.log(result);
                    if (result.code !== 0) {
                        layer.msg(result.msg, {shift: 6});
                        return false;
                    }

                    layer.msg(result.msg, {icon: 1}, function () {
                        if (result.reload) {
                            location.href = '{!! url()->previous() !!}';
                            location.href = '{{route("admin::Information.index")}}';
                            return ;
                        }
                        if (result.redirect) {
                            location.href = '{!! url()->previous() !!}';
                        }
                    });
                }
            });

            return false;
        };
    </script>
@endsection