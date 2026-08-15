@pushOnce('foot')
<link href="{{ cmstheme($page, 'showcases.css') }}" rel="preload" as="style">
@endPushOnce

<div class="showcase-grid">
    @foreach($data->items ?? [] as $item)
        @if($file = cms($files, $item->file?->id ?? null))
            <figure class="showcase-card">
                @if($url = cmslink($item->url ?? null))
                    <a href="{{ $url }}" target="_blank" rel="noreferrer noopener" aria-label="{{ $item->name ?? cms($file, 'name') }}">
                @endif
                    @include('cms::pic', [
                        'file' => $file,
                        'class' => 'showcase-image',
                        'sizes' => '(max-width: 767px) 100vw, 542px',
                    ])
                @if($url)
                    </a>
                @endif
                @if(($item->name ?? null) || ($item->text ?? null))
                    <figcaption>
                        @if($item->name ?? null)
                            <span class="showcase-name">{{ $item->name }}</span>
                        @endif
                        @if($item->text ?? null)
                            <span class="showcase-segment">{{ $item->text }}</span>
                        @endif
                    </figcaption>
                @endif
            </figure>
        @endif
    @endforeach
</div>
