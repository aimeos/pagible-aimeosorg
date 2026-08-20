<div class="partnering row">
    <div class="col-sm-12 header">
        <h2>{{ $data->title ?? '' }}</h2>
    </div>
    <div class="col-md-7 intro">
        <div class="cms-text">@markdown($data->text ?? '')</div>
    </div>
    <div class="col-md-5 button">
        @if($url = cmslink($data->url ?? null))
            <a class="btn btn-primary" href="{{ $url }}">{{ $data->label ?? '' }}</a>
        @endif
    </div>
</div>
