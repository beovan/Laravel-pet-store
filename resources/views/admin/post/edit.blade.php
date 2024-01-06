@extends('admin.main')

@section('head')
{{--    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>--}}
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST">
    <div class="card-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="menu">Tiêu đề</label>
                    <input type="text" name="title" value="{{ $post->title }}" class="form-control"  placeholder="Nhập tiêu đề">
                </div>
            </div>
        <div class="form-group">
            <label>Mô Tả Chi Tiết</label>
            <textarea name="content" id="content" class="form-control">{{ $post->content }}</textarea>
        </div>
        <div class="form-group">
            <label for="menu" >Ảnh bài viết</label>
            <input type="file" class="form-control" id="upload">
            <div id="image_show">
                <a href="{{ $post->thumb }}" target="_blank">
                    <img src="{{ $post->thumb }}" width="100px">
                </a>
            </div>
            <input type="hidden" value="{{ $post->thumb }}" name="thumb" id="thumb">
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
    @csrf
</form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
