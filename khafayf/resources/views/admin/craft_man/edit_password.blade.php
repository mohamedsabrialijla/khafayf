@extends('admin.layout.admin')
@section('title'){{"Agree Driver User"}}@endsection
@section('page-style')
@endsection
@section('content-header')
    <h1>Agree Driver</h1>
    <ol class="breadcrumb">
        <li><a href="{{url(app()->getLocale().'/admin/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
       
        <li><a href="{{url(app()->getLocale().'/admin/driver_man')}}"><i class="fa fa-th"></i> Drivers</a></li>
         
        <li class="active">Agree Driver </li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
{{--                     <h3 class="box-title">تعديل كلمة المرور</h3>
 --}}                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>{{'Error'}}!</strong>{{' Wrong data entry'}}<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{trans(Session::get('success'))}}
                    </div>               
                @endif
                
                <form class="form-horizontal" method="post" action="{{url(app()->getLocale().'/admin/driver_man')}}/{{$users->id}}/{{'edit_password'}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" required value="{{$users->name}}"
                                       placeholder="Name Craft">
                                <small>{{"* required"}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Email</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" required value="{{$users->email}}"
                                       placeholder="Email Craft">
                                <small>{{"* required"}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Mobile</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="mobile" class="form-control" required value="{{$users->mobile}}"
                                       placeholder="Mobile Craft">
                                <small>{{"* required"}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Detalis</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea name="details" class="form-control"
                                       placeholder="Detalis Craft">{{$users->details}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Password</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="password" name="password" value="" class="form-control" required
                                       placeholder="Password ">
                                <small>{{"* required"}}</small>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Confirm Password</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="password" name="confirm_password" value="" class="form-control" required 
                                       placeholder="Confirm Password">
                                <small>{{"* required"}}</small>
                            </div>
                        </div>

                        
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-plugins')
@endsection
@section('page-script')
    
     <script>
      function readURL(input, target) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    target.attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#thumb_image').on('change', function (e) {
            readURL(this, $('#thumbImage'));
        });

        $('#thumb_image2').on('change', function (e) {
            readURL(this, $('#thumbImage2'));
        });

                                      
</script>
@endsection
