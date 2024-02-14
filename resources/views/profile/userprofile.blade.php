@include('layouts.header')

<style>
    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
    }

    .tab-content {
        padding: 2rem;
    }
</style>

<div class="-fluid py-5 mb-4 d-flex justify-content-center" style="background-image: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1124&q=100'); background-position: center; background-size:cover; background-repeat:no-repeat;">
    <div class="p-3 mb-2 lc-block col-xxl-7 col-lg-8 col-12" style="backdrop-filter: blur(6px) saturate(102%); -webkit-backdrop-filter: blur(6px) saturate(102%); background-color: rgba(255, 255, 255, 0.45); border-radius: 12px; border: 1px solid rgba(209, 213, 219, 0.3);">
        <h3 class="text-center">Perfil de</h3>
        <h1 class="text-center">{{$user->name}}</h1>
    </div>
</div>

<div class="container border rounded">
    <div class="row justify-content-center align-items-center">
        <!-- Avatar, siempre arriba para móviles y a la izquierda para pantallas más grandes -->
        <div class="col-12 col-md-3 text-center text-md-right mb-3 mb-md-0">
            <img src="{{$user->avatar}}" class="rounded-circle" style="width: 100px; height: 100px;">
        </div>
        <!-- Información del usuario -->
        <div class="col-12 col-md-9">
            <div class="row">
                <div class="col-3 col-md-1"><b>Nombre:</b></div>
                <div class="col-9 col-md-11">{{$user->name}}</div>
            </div>
            <div class="row">
                <div class="col-3 col-md-1"><b>Email:</b></div>
                <div class="col-9 col-md-11">{{$user->email}}</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-1"><b>Rol(es):</b></div>
                <div class="col-12 col-md-11">
                    <ul>
                        @foreach ($roles as $role)
                            <li>{{ $role }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Colaboraciones</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Suscripciones</button>
  </li>
</ul>

<div class="tab-content border" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Home content</div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Profile content</div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Contact content</div>
</div>

@include('layouts.footer')