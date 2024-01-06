@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tiêu đề</th>
                <th>Nội dung </th>
                <th>Ảnh bài viết</th>
                <th>Thời gian</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $key => $post)
                <tr>
                    <td  class="d-inline-block text-truncate" style="max-width: 150px;">{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td class="d-inline-block text-truncate" style="max-width: 150px;">
                        {{ $post->content }}</td>
                    <td>
                        <a href=" {{ $post->thumb }}" target="_blank">
                            <img src="{{ $post->thumb }}" height="100px">
                        </a>
                       </td>
                    <td>{{ $post->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/posts/edit/{{ $post->id }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow({{ $post->id }}, '/admin/posts/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $posts->links() !!}
    </div>
@endsection
