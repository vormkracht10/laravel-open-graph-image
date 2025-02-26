@foreach(config('og-image.metatags') as $property => $key)
@if($attributes->has($key))
<meta property="{{ $property }}" content="{{ $attributes->get($key) }}">
@endif
@endforeach

<meta property="og:image" content="{!! og($attributes) !!}">
<meta property="og:image:type" content="{{ Backstage\Laravel\OgImage\Facades\OpenGraphImage::getImageMimeType() }}">
<meta property="og:image:width" content="{{ config('og-image.width') }}">
<meta property="og:image:height" content="{{ config('og-image.height') }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{!! og($attributes) !!}">
