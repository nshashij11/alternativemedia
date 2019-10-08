@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Category List <a href="category_add" class="pull-right">Add Category</a></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Category Name</th>
                              <th>Status</th>
                              <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($categories))
                                @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$category->category_name}}</td>
                                    <td>{{($category->category_status == 1) ? 'Active' : 'Inactive'}}</td>
                                    <td><a href="category_edit?id={{$category->id}}">Edit</a></td>
                                    <td><a onClick="onDelete({{$category->id}})">Delete</a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr align="center"><td colspan="5">There is no categories found!</td></tr>
                            @endif
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function onDelete(id){
        var del = confirm("Do you want to delete?");
        if (del == true) {
            window.location.href ="category_delete?id="+id;
        } 
        return false;
    }
</script>
@endsection
