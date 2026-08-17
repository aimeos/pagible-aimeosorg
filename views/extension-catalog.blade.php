@pushOnce('foot')
<link href="{{ cmstheme($page, 'extension-catalog.css') }}" rel="preload" as="style">
@endPushOnce

<div class="extension-catalog-grid">
    @foreach($data->items ?? [] as $item)
        <article class="extension-card" data-code="{{ cmsattr($item->code ?? '') }}">
            <a href="{{ cmslink($item->url ?? '') }}">
                <div class="extension-card-icon">
                    <img src="{{ cmslink($item->icon ?? '') }}" alt="{{ cmsattr($item->icon_alt ?? $item->title ?? '') }}" loading="lazy">
                </div>
                <h2>{{ $item->title ?? '' }}</h2>
                <p>{{ $item->text ?? '' }}</p>
                <span class="btn extension-details">{{ $data->details_label ?? 'Details' }}</span>
            </a>
        </article>
    @endforeach
</div>
