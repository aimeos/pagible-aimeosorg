@pushOnce('foot', 'css:image')
<link href="{{ cmstheme($page, 'image.css') }}" rel="preload" as="style">
@endPushOnce
@pushOnce('foot')
<link href="{{ cmstheme($page, 'feature.css') }}" rel="preload" as="style">
@endPushOnce

@php($position = in_array($data->position ?? '', ['start', 'end'], true) ? $data->position : 'start')

<div class="feature-content {{ $position }}">
    @if($file = cms($files, $data->file?->id ?? null))
        <div class="feature-visual">
            @include('cms::pic', [
                'file' => $file,
                'class' => 'feature-image',
                'sizes' => '(max-width: 767px) 100vw, 50vw',
            ])
        </div>
    @endif

    <div class="feature-copy">
        <h2>{{ $data->title ?? '' }}</h2>
        <div class="cms-text">@markdown($data->text ?? '')</div>
    </div>
</div>
