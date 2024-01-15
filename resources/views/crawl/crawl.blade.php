@extends('main')
@section('content')
<h1>{{ $title }}</h1>
    <div class="row isotope-grid">
        @if (!empty($data))
            @foreach ($data as $item)
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ $item['image'] }}" alt="{{ $item['text'] }}" style="max-width: 100%;">
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="{{ $item['link'] }}" style="text-decoration: none; font-weight: bold; color: #333;">
                                    {{ $item['text'] }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No data available</p>
        @endif
    </div>
@endsection
