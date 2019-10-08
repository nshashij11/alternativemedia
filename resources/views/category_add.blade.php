@extends('layouts.app')

@section('content')
<div class="container">    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Category</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{url('/category_save')}}">
                        <div class="col-md-12">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                    <label for="category_name">Category Name <span class="red">*</span></label>
                                    <input type="text" class="form-control" name="category_name" onChange="checkName()" required value="" autofocus="" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category_status">Category Status <span class="red">*</span></label>
                                    <div class="form-group">
                                        <input type="radio" class="" name="category_status" value="1" checked>Active
                                        <input type="radio" class="" name="category_status" value="0">Inactive
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" align="right">
                                <button type="button" onClick="cancel()" class="btn btn-danger" >Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function checkName(){
        var name = $.trim($('category_name').val());
        if(name == ''){
            alert("Please enter the valid value");
            $('#category_name').val('');
            $('#category_name').focus();
            return false;
        }
    }

    function cancel(){
        window.location.href = "category_list";
    }
</script>
@endsection
