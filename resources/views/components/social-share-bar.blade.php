<aside class="barra-flotante" style="border: 1px solid grey; padding: 10px; text-align: center;">
    <div style="background-color: grey; color: white; padding: 2px; margin-bottom: 1rem; font-size: 0.7rem;">
        COMPARTE
    </div>

    @php
    $url = urlencode(request()->fullUrl());
    $socialNetworks = [
    'facebook' => ['icon' => 'fa-facebook-f', 'color' => '#3b5998', 'name' => 'Facebook', 'shareUrl' => "https://www.facebook.com/sharer/sharer.php?u={$url}"],
    'whatsapp' => ['icon' => 'fa-whatsapp', 'color' => '#25D366', 'name' => 'WhatsApp', 'shareUrl' => "https://api.whatsapp.com/send?text={$url}"],
    'twitter' => ['icon' => 'fa-twitter', 'color' => '#1DA1F2', 'name' => 'Twitter', 'shareUrl' => "https://twitter.com/intent/tweet?url={$url}&text=Título del Artículo"],
    'messenger' => ['icon' => 'fa-facebook-messenger', 'color' => '#00B2FF', 'name' => 'Messenger', 'shareUrl' => "https://www.facebook.com/dialog/send?link={$url}&app_id={tu_app_id}&redirect_uri={tu_redirect_uri}"],
    'pinterest' => ['icon' => 'fa-pinterest-p', 'color' => '#BD081C', 'name' => 'Pinterest', 'shareUrl' => "http://pinterest.com/pin/create/button/?url={$url}"],
    'gmail' => ['icon' => 'fa-envelope', 'color' => '#D44638', 'name' => 'Gmail', 'shareUrl' => "https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=&su=Título del Artículo&body={$url}"],
    'reddit' => ['icon' => 'fa-reddit-alien', 'color' => '#FF4500', 'name' => 'Reddit', 'shareUrl' => "https://reddit.com/submit?url={$url}&title=Título del Artículo"],
    ];
    @endphp

    @foreach ($socialNetworks as $network => $data)
    <a href="{{ $data['shareUrl'] ?? '#' }}" class="btn" title="{{ $data['name'] }}" target="_blank" style="background-color: {{ $data['color'] }}; border-radius: 50%; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: .5rem;">
        <i class="{{ $network === 'gmail' ? 'fas' : 'fab' }} {{ $data['icon'] }} text-white" style="font-size: 1.2rem;"></i>
    </a>
    @endforeach
</aside>