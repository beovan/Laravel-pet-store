@if (isset($comments))
    @foreach ($comments as $comment)
        <div>
            <p>{{ $comment->content }}</p>
            <small>by {{ $comment->user->name }} at {{ $comment->created_at }}</small>

            <!-- Display replies recursively -->
            @include('comments', ['comments' => $comment->replies])
        </div>
    @endforeach
@endif
