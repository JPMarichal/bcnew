<aside class="barra-flotante" style="border: 1px solid grey; padding: 10px; text-align: center;">
    <div style="background-color: grey; color: white; padding: 2px; margin-bottom: 1rem; font-size: 0.7rem;">
        COMPARTE
    </div>

    @php
    $url = urlencode(request()->fullUrl());
    $socialNetworks = [
    'facebook' => ['icon' => 'fa-facebook-f', 'color' => '#3b5998', 'name' => 'Facebook', 'shareUrl' => "https://www.facebook.com/sharer/sharer.php?u={$url}"],
    'whatsapp' => ['icon' => 'fa-whatsapp', 'color' => '#25D366', 'name' => 'WhatsApp', 'shareUrl' => "https://api.whatsapp.com/send?text=Hola! Descubrí este artículo en el sitio de los Biblicomentarios y quise compartirlo contigo:\n\n**{$title}**\n\n{$description}\n\nLo puedes consultar en la siguiente dirección:\n\n{$url}\n\nEspero te guste.&image={$featuredImage}"],
    'twitter' => ['icon' => 'fa-twitter', 'color' => '#1DA1F2', 'name' => 'Twitter', 'shareUrl' => "https://twitter.com/intent/tweet?url={$url}&text={$title}\n\n{$description}\n&hashtags={$keywords}"],
    'messenger' => ['icon' => 'fa-facebook-messenger', 'color' => '#00B2FF', 'name' => 'Messenger', 'shareUrl' => "https://www.facebook.com/dialog/send?link={$url}&app_id={590703081059319}"],
    'pinterest' => ['icon' => 'fa-pinterest-p', 'color' => '#BD081C', 'name' => 'Pinterest', 'shareUrl' => "http://pinterest.com/pin/create/link/?url={$url}&description={$description}&media={$featuredImage}"],
        'gmail' => ['icon' => 'fa-envelope', 'color' => '#D44638', 'name' => 'Gmail', 'shareUrl' => "https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=&su={$title}&body=Hola! Descubrí este artículo en el sitio de los Biblicomentarios y quise compartirlo contigo:\n\n**{$title}**\n\n{$description}\n\nLo puedes consultar en la siguiente dirección:\n\n{$url}\n\nEspero te guste."],
    'reddit' => ['icon' => 'fa-reddit-alien', 'color' => '#FF4500', 'name' => 'Reddit', 'shareUrl' => "https://reddit.com/submit?url={$url}&title={$title}"],
    ];
    @endphp

    @foreach ($socialNetworks as $network => $data)
    <a href="{{ $data['shareUrl'] ?? '#' }}" class="btn pinitbutton" title="{{ $data['name'] }}" target="_blank" style="background-color: {{ $data['color'] }}; border-radius: 50%; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: .5rem;" data-size:"large">
        <i class="{{ $network === 'gmail' ? 'fas' : 'fab' }} {{ $data['icon'] }} text-white" style="font-size: 1.2rem;"></i>
    </a>
    @endforeach
</aside>