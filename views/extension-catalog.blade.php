@pushOnce('foot')
<link href="{{ cmstheme($page, 'extension-catalog.css') }}" rel="preload" as="style">
@endPushOnce

<div class="extension-catalog-grid">
    @foreach($data->items ?? [] as $item)
        <article class="extension-card" data-code="{{ cmsattr($item->code ?? '') }}">
            <a href="{{ cmslink($item->url ?? '') }}">
                <div class="extension-card-icon">
                    @if($file = cms($files, $item->file?->id ?? null))
                        <picture class="extension-card-image">
                            @if($preview = current(array_reverse((array) cms($file, 'previews', []))) ?: cms($file, 'path'))
                                <img
                                    loading="lazy"
                                    fetchpriority="low"
                                    srcset="{{ cmssrcset($page, $file) }}"
                                    src="{{ cmsasset($page, $file, $preview) }}"
                                    sizes="(max-width: 599px) 70vw, (max-width: 991px) 35vw, 15vw"
                                    alt="{{ $item->icon_alt ?? $item->title ?? '' }}">
                            @endif
                        </picture>
                    @endif
                </div>
                <h2>{{ $item->title ?? '' }}</h2>
                <p>{{ $item->text ?? '' }}</p>
                <span class="btn extension-details">{{ $data->details_label ?? 'Details' }}</span>
            </a>
        </article>
    @endforeach
</div>
