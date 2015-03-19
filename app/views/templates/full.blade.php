<picture>
    @foreach($images as $image)
        <source media="(min-width: {{$image['width']}}px)" srcset="{{$folder}}{{$image['name']}} 1x, {{$folder}}{{$image['name2x']}} 2x, {{$folder}}{{$image['name3x']}} 3x">
    @endforeach
    <img src="{{$folder}}{{$default['name']}}" alt="" srcset="{{$folder}}{{$default['name']}} 1x, {{$folder}}{{$default['name2x']}} 2x, {{$folder}}{{$default['name3x']}} 3x">
</picture>