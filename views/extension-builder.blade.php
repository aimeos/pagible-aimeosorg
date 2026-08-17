@pushOnce('foot')
<link href="{{ cmstheme($page, 'extension-builder.css') }}" rel="preload" as="style">
<script defer src="{{ cmstheme($page, 'extension-builder.js') }}"></script>
@endPushOnce

@php($builderId = 'extension-builder-'.($data->id ?? cms($page, 'id')))
<div class="extension-builder">
    <div class="extension-builder-actions">
        <button type="button" class="btn btn-primary createext" aria-expanded="false" aria-controls="{{ cmsattr($builderId) }}">
            {{ $data->create_label ?? 'Create own extension' }}
        </button>
        <a href="{{ cmslink($data->submit_url ?? null) ?: '/contact' }}" class="btn submitext">
            {{ $data->submit_label ?? 'Submit your extension' }}
        </a>
    </div>

    <div id="{{ cmsattr($builderId) }}" class="extension-builder-details" hidden>
        <h2>{{ $data->title ?? 'Create your own extension' }}</h2>

        @if($data->text ?? null)
            <div class="cms-text">@markdown($data->text)</div>
        @endif

        <form action="{{ cmsroute('aimeos.api.extension-builder') }}" method="POST">
            <input type="hidden" name="_token" value="">
            <div class="extension-builder-fields">
                <div class="extension-builder-field">
                    <label for="{{ cmsattr($builderId) }}-name">{{ $data->name_label ?? 'Project name *' }}</label>
                    <input id="{{ cmsattr($builderId) }}-name" type="text" name="name" maxlength="64" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" autocomplete="off" required>
                </div>
                <div class="extension-builder-field">
                    <label for="{{ cmsattr($builderId) }}-type">{{ $data->type_label ?? 'Package type *' }}</label>
                    <select id="{{ cmsattr($builderId) }}-type" name="type" required>
                        @foreach(\Aimeos\Cms\ExtensionBuilder::types() as $type => $label)
                            <option value="{{ $type }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary download">
                {{ $data->download_label ?? 'Download' }}
            </button>
        </form>
    </div>
</div>
