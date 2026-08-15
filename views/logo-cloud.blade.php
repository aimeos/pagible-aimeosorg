@pushOnce('foot')
<link href="{{ cmstheme($page, 'logo-cloud.css') }}" rel="preload" as="style">
@endPushOnce

@if($data->title ?? null)
    <h2 class="title">{{ $data->title }}</h2>
@endif

<ul class="logo-cloud-list" aria-label="{{ $data->title ?? __('Organizations using Aimeos') }}">
    @foreach($data->items ?? [] as $item)
        @if($file = cms($files, $item->file?->id ?? null))
            <li class="logo-cloud-item">
                @if($url = cmslink($item->url ?? null))
                    <a href="{{ $url }}" aria-label="{{ $item->name ?? cms($file, 'name') }}">
                @else
                    <div role="img" aria-label="{{ $item->name ?? cms($file, 'name') }}">
                @endif
                    @include('cms::pic', [
                        'file' => $file,
                        'class' => 'logo',
                        'sizes' => '(max-width: 576px) 50vw, 20vw',
                    ])
                @if($url)
                    </a>
                @else
                    </div>
                @endif
            </li>
        @endif
    @endforeach
</ul>
