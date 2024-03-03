<div class="barra-flotante" style="border: 1px solid grey; padding: 10px; text-align: center;">
    <div style="background-color: grey; color: white; padding: 2px; margin-bottom: 1rem; font-size: 0.7rem;">
        COMPARTE
    </div>

    @php
    $socialNetworks = [
        'whatsapp' => ['icon' => 'fa-whatsapp', 'color' => '#25D366', 'name' => 'WhatsApp'],
        'facebook' => ['icon' => 'fa-facebook-f', 'color' => '#3b5998', 'name' => 'Facebook'],
        'instagram' => ['icon' => 'fa-instagram', 'color' => '#C13584', 'name' => 'Instagram'],
        'gmail' => ['icon' => 'fa-envelope', 'color' => '#D44638', 'name' => 'Gmail'], // Corregido para usar 'fas' en lugar de 'fab'
        'pinterest' => ['icon' => 'fa-pinterest-p', 'color' => '#BD081C', 'name' => 'Pinterest'],
    ];
    @endphp

    @foreach ($socialNetworks as $network => $data)
    <a href="#" class="btn" title="{{ $data['name'] }}" style="background-color: {{ $data['color'] }}; border-radius: 50%; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
        <i class="{{ $network === 'gmail' ? 'fas' : 'fab' }} {{ $data['icon'] }} text-white" style="font-size: 1.2rem;"></i>
    </a>
    @endforeach
</div>
