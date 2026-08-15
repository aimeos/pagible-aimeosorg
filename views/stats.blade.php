@pushOnce('foot')
<link href="{{ cmstheme($page, 'stats.css') }}" rel="preload" as="style">
@endPushOnce

@if($data->title ?? null)
    <h2 class="title">{{ $data->title }}</h2>
@endif

<ul class="stats-list" aria-label="{{ $data->title ?? __('Key figures') }}">
    @foreach($data->items ?? [] as $item)
        @php
            $kind = $item->kind ?? match (strtolower((string) ($item->label ?? ''))) {
                'github stars' => 'github',
                'capterra reviews' => 'capterra',
                'downloads' => 'downloads',
                'code quality' => 'code',
                default => '',
            };
        @endphp
        <li class="stats-item{{ $kind ? ' stats-item-'.$kind : '' }}">
            @if($url = cmslink($item->url ?? null))
                <a href="{{ $url }}">
            @else
                <div>
            @endif
                @if($file = cms($files, $item->file?->id ?? null))
                    @include('cms::pic', [
                        'file' => $file,
                        'class' => 'logo',
                        'sizes' => '(max-width: 767px) 100vw, 33vw',
                    ])
                @endif
                <span class="label">{{ $item->label ?? '' }}</span>
                <strong class="value">{{ $item->value ?? '' }}</strong>
                @if($item->text ?? null)
                    <span class="text">{{ $item->text }}</span>
                @endif
            @if($url)
                </a>
            @else
                </div>
            @endif
        </li>
    @endforeach
</ul>
