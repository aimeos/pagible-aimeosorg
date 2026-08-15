@pushOnce('foot:grid')
<link href="{{ cmstheme($page, 'pico.grid.min.css') }}" rel="preload" as="style">
@endPushOnce

@pushOnce('foot')
<link href="{{ cmstheme($page, 'contact.css') }}" rel="preload" as="style">
<script defer src="{{ cmstheme($page, 'contact.js') }}"></script>
@endPushOnce

@php($formId = $data->id ?? cms($page, 'id'))

<div class="aimeos-contact-page">
    <section class="contact-band contact-links-band contact-informed">
        <div class="container">
            <h2>{{ $data->informed_title ?? '' }}</h2>
            <div class="landing links">
                @foreach($data->informed_links ?? [] as $link)
                    <a class="link" href="{{ cmslink($link->url ?? '') }}">
                        <i class="fa fa-{{ cmsattr($link->icon ?? '') }}" aria-hidden="true"></i>
                        {{ $link->label ?? '' }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="contact-band contact-links-band contact-support">
        <div class="container">
            <h2>{{ $data->support_title ?? '' }}</h2>
            <div class="landing links">
                @foreach($data->support_links ?? [] as $link)
                    <a class="link" href="{{ cmslink($link->url ?? '') }}">
                        <i class="fa fa-{{ cmsattr($link->icon ?? '') }}" aria-hidden="true"></i>
                        {{ $link->label ?? '' }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="contact-band contact-form-band contact">
        <div class="container">
            <h2>{{ $data->contact_title ?? '' }}</h2>
            <div class="contact-introduction">@markdown($data->contact_text ?? '')</div>

            <form action="{{ route('cms.api.contact') }}" method="POST" aria-describedby="contact-errors-{{ $formId }}" toolname="contact" tooldescription="{{ __('Send a message to the site owner through the contact form') }}">
                <input type="hidden" name="_token" value="">
                <input type="hidden" name="source" value="{{ cmsroute($page) }}">

                <div class="contact-form-head">
                    <h3>{{ $data->form_title ?? '' }}</h3>
                    <p>{{ $data->mandatory_text ?? '' }}</p>
                </div>

                <div class="contact-form-columns">
                    <div>
                        <div class="form-group">
                            <label for="name-{{ $formId }}">{{ __('Full name and surname') }} <span class="required">*</span></label>
                            <input id="name-{{ $formId }}" type="text" name="name" placeholder="{{ __('Full name and surname') }}" required toolparamdescription="{{ __('Full name of the person sending the message') }}">
                        </div>
                        <div class="form-group">
                            <label for="company-{{ $formId }}">{{ __('Company') }}</label>
                            <input id="company-{{ $formId }}" type="text" name="company" placeholder="{{ __('Company') }}">
                        </div>
                        <div class="form-group">
                            <label for="email-{{ $formId }}">{{ __('Email') }} <span class="required">*</span></label>
                            <input id="email-{{ $formId }}" type="email" name="email" placeholder="{{ __('Email') }}" required toolparamdescription="{{ __('E-mail address of the sender for the reply') }}">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="subject-{{ $formId }}">{{ __('Subject') }} <span class="required">*</span></label>
                            <input id="subject-{{ $formId }}" type="text" name="subject" placeholder="{{ __('Subject') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="message-{{ $formId }}">{{ __('Message') }} <span class="required">*</span></label>
                            <textarea id="message-{{ $formId }}" name="message" placeholder="{{ __('Message') }}" required rows="5" toolparamdescription="{{ __('Message text to send to the site owner') }}"></textarea>
                        </div>
                    </div>
                </div>

                <div id="contact-errors-{{ $formId }}" class="errors" role="alert" aria-live="polite" tabindex="-1"></div>
                <div class="submit">
                    @if(!app()->environment('local') && config('services.hcaptcha.sitekey'))
                        <div class="h-captcha" data-sitekey="{{ config('services.hcaptcha.sitekey') }}"></div>
                    @endif
                    <button type="submit" class="btn">
                        <span class="send">{{ __('Submit') }}</span>
                        <span class="sending hidden" aria-busy="true">{{ __('Message will be sent') }}</span>
                        <span class="success hidden">{{ __('Successfully sent') }}</span>
                        <span class="failure hidden">{{ __('Error sending e-mail') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="contact-band contact-legal-band">
        <div class="container">
            <h2>{{ $data->imprint_title ?? '' }}</h2>
            <div class="contact-imprint">@markdown($data->imprint_text ?? '')</div>
            <h2>{{ $data->privacy_title ?? '' }}</h2>
            <div class="contact-privacy">@markdown($data->privacy_text ?? '')</div>
            <h2>{{ $data->credits_title ?? '' }}</h2>
            <div class="contact-credits">@markdown($data->credits_text ?? '')</div>
        </div>
    </section>
</div>
