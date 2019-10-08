@extends('layouts.app')

@section('content')
<div class="container">
    <h3 align="center" class="selectTitle">Gallery Categories</h3>
    <h3 align="center" class="categorytitle"><span id="catTitle"></span> Photo Gallery</h3>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-2 categoriesCls">
            @if(count($categories))
                <ul>
                @foreach($categories as $key => $category)
                    <li><a class="categories" data-id="{{$category->category_name}}">{{$category->category_name}}</a> <span id="star" class="red star_{{$category->category_name}}">*</span></li>
                @endforeach
                </ul>    
            @endif
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-8 categorySelectCls">
            <div id="selectCls">Select a Category from the left to see images here.</div>
            <p></p>
            <div id="results"></div>
            <div id="details">
                <div class="col-sm-7"><img class="viewImg" src=""></div>
                <div class="col-sm-5">
                    <span>Image details</span>
                    <a class="pull-right" onclick="backToResults()"><i class="fa fa-angle-left"></i></a>
                    </br>
                    <div id="viewDesc">
                       Image Details are not found!
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    var apiurl,myresult,apiurl_size,selected_size;
    selected_size=150;
    var description = '';
    var title = '';
    var dataId ='';

    var apiKey = 'e24d3e67cf98d08c5959197d30e17456';
    $(document).ready(function(){
        $('.viewDesc').html('');
         $('.categories').click(function(){
            dataId = $(this).attr('data-id');
            $('.red').hide();
            $('li').removeClass("active");            
            $('.red').removeClass("active");            
            $(this).parent().addClass("active");            
            $("#results").html('');
            apiurl = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key="+apiKey+"&per_page=16&text="+dataId+"&format=json&nojsoncallback=1";
             $.getJSON(apiurl,function(json){
                 $.each(json.photos.photo,function(i,myresult){
                    console.log(myresult);
                     apiurl_size = "https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key="+apiKey+"&photo_id="+myresult.id+"&text="+dataId+"&format=json&nojsoncallback=1";                     
                     $.getJSON(apiurl_size,function(size){
                         $.each(size.sizes.size,function(i,myresult_size){
                            if(myresult_size.width==selected_size){
                                $("#results").append('<div class="col-md-2"><a onclick="viewGallery(this.id)" id="'+myresult.id+'" data-source-id="'+myresult_size.source+'"  ><img data-url ="'+myresult_size.url+'" class="flickrCls" src="'+myresult_size.source+'"/></a></div>');                     
                            }
                            $('.selectTitle').hide();
                            $('#selectCls').hide();
                            $('.categorytitle').show();
                            $('#catTitle').text(dataId);
                            $('.star_'+dataId).show();
                         })
                     })
                 });
             });
         });
    });
$('.categorytitle').hide();
$('.selectTitle').show();
$('#selectCls').show();
$('.red').hide();
$('#details').hide();




function viewGallery(imgId){
    $('#viewDesc').html('');
    description = '';
    title ='';
    var imgUrl = $('#'+imgId).attr('data-source-id');
    apiurl_info = "https://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key="+apiKey+"&photo_id="+imgId+"&text="+dataId+"&format=json&nojsoncallback=1";
    $.getJSON(apiurl_info,function(info){ 
    console.log(info);                       
        if(info.photo.id == imgId){
            description  = $.trim(info.photo.description._content);  
            // title  = $.trim(info.photo.title._content);  
        }
        $('#viewDesc').html(description);
        if(description == ''){
             $('#viewDesc').html('Image Details are not found!');
        }
        $('#details').show();
        $('.viewImg').attr("src",imgUrl);
        $('#results').hide();

     });
    
}

function backToResults(){
    $('#details').hide();
    $('#results').show();
}
</script>

@endsection
