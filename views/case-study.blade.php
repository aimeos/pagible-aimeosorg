@pushOnce('foot')
<link href="{{ cmstheme($page, 'case-study.css') }}" rel="preload" as="style">
@endPushOnce

<article class="case-study-detail">
    <header class="case-study-stage">
        <div class="case-study-stage-inner">
            <h1>{{ $data->title ?? '' }}</h1>

            @if(!empty($data->tags))
                <ul class="case-study-tags" aria-label="{{ __('Case study categories') }}">
                    @foreach($data->tags as $tag)
                        @if($tag->label ?? null)
                            <li>{{ $tag->label }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif

            <div class="case-study-stage-grid">
                <div class="case-study-intro cms-text">@markdown($data->intro ?? '')</div>
                @if($file = cms($files, $data->stage_file?->id ?? null))
                    <div class="case-study-stage-visual">
                        @include('cms::pic', [
                            'file' => $file,
                            'main' => true,
                            'sizes' => '(max-width: 767px) 100vw, 570px',
                        ])
                    </div>
                @endif
            </div>
        </div>
    </header>

    @foreach($data->sections ?? [] as $section)
        @php($sectionFiles = collect((array) ($section->files ?? []))
            ->map(fn ($item) => cms($files, is_scalar($item) ? (string) $item : data_get($item, 'id')))
            ->filter())
        @php($position = ($section->position ?? '') === 'end' ? 'end' : 'start')

        <section class="case-study-section">
            <div class="case-study-section-inner position-{{ $position }}{{ $sectionFiles->isEmpty() ? ' no-image' : '' }}">
                @if($sectionFiles->isNotEmpty())
                    <div class="case-study-section-visual">
                        @foreach($sectionFiles as $file)
                            @if($url = cmslink($section->url ?? null))
                                <a href="{{ $url }}" target="_blank" rel="noreferrer noopener">
                            @endif
                                @include('cms::pic', [
                                    'file' => $file,
                                    'sizes' => '(max-width: 767px) 100vw, 380px',
                                ])
                            @if($url)
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif

                <div class="case-study-section-copy cms-text">
                    @if($section->title ?? null)
                        <h2>{{ $section->title }}</h2>
                    @endif
                    @markdown($section->text ?? '')
                </div>
            </div>
        </section>
    @endforeach

    @if(!empty($data->screenshots))
        <section class="case-study-gallery">
            <div class="case-study-gallery-inner">
                @if($data->gallery_title ?? null)
                    <h2>{{ $data->gallery_title }}</h2>
                @endif
                @include('cms::slideshow', [
                    'data' => (object) [
                        'files' => $data->screenshots,
                        'autoplay' => true,
                        'captions' => false,
                        'main' => false,
                    ],
                    'page' => $page,
                    'files' => $files,
                ])
            </div>
        </section>
    @endif

    @if(($data->implementer_title ?? null) || ($data->implementer_name ?? null) || ($data->implementer_text ?? null))
        <section class="case-study-implementer">
            <div class="case-study-implementer-inner">
                @if($file = cms($files, $data->implementer_file?->id ?? null))
                    <div class="case-study-implementer-visual">
                        @if($url = cmslink($data->implementer_url ?? null))
                            <a href="{{ $url }}" target="_blank" rel="noreferrer noopener">
                        @endif
                            @include('cms::pic', [
                                'file' => $file,
                                'sizes' => '(max-width: 767px) 100vw, 380px',
                            ])
                        @if($url)
                            </a>
                        @endif
                    </div>
                @endif

                <div class="case-study-implementer-copy cms-text">
                    @if($data->implementer_title ?? null)
                        <h2>{{ $data->implementer_title }}</h2>
                    @endif
                    @if($data->implementer_name ?? null)
                        <h3>
                            @if($url = cmslink($data->implementer_url ?? null))
                                <a href="{{ $url }}" target="_blank" rel="noreferrer noopener">{{ $data->implementer_name }}</a>
                            @else
                                {{ $data->implementer_name }}
                            @endif
                        </h3>
                    @endif
                    @markdown($data->implementer_text ?? '')
                </div>
            </div>
        </section>
    @endif

    @if(($data->back_label ?? null) && ($url = cmslink($data->back_url ?? null)))
        <nav class="case-study-back" aria-label="{{ __('Case studies') }}">
            <a class="case-study-back-link" href="{{ $url }}">{{ $data->back_label }}</a>
        </nav>
    @endif
</article>
