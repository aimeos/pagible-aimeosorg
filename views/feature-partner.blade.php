<div class="partnering row">
    <div class="col-sm-12 header">
        <h2>{{ $data->title ?? '' }}</h2>
    </div>
    <div class="col-md-7 intro">
        @markdown($data->text ?? '')
    </div>
    <div class="col-md-5 button">
        <a href="{{ cmslink($data->button_url ?? '') }}" class="btn btn-primary btn-block">
            {{ $data->button_label ?? '' }}
        </a>
    </div>
</div>
