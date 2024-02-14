@include('layouts.header')

<div lc-helper="background" class="container-fluid py-5 mb-4 d-flex justify-content-center" style="  background-image: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1124&amp;q=100');
    background-position: center;
background-size:cover;
background-repeat:no-repeat">
        <div class="p-3 mb-2 lc-block col-xxl-7 col-lg-8 col-12" style=" backdrop-filter: blur(6px) saturate(102%);
    -webkit-backdrop-filter: blur(6px) saturate(102%);
    background-color: rgba(255, 255, 255, 0.45);
    border-radius: 12px;
    border: 1px solid rgba(209, 213, 219, 0.3);">
    <h3 class="text-center">Perfil de</h3>
<h1 class="text-center">{{$user->name}} </h1>
        </div>
</div>

<div class="row border border-round mt-0 mx-2">
    <div class="col-1 text-right">&nbsp;</div>
    <div class="col-1 text-right"><img src="{{$user->avatar}}" class="rounded-circle"></div>
    <div class="col-10 row">
        <div class="row m-0 p-0">
            <div class="col-1 my-0 p-0"><b>Nombre:</b></div><div class="col-11">{{$user->name}}</div>
        </div>
        <div class="row m-0 p-0">
            <div class="col-1 my-0 p-0"><b>Email:</b></div><div class="col-11">{{$user->email}}</div>
        </div>
        <div class="row m-0 p-0">
            <div class="col-1 my-0 p-0"><b>Rol(es):</b></div><div class="col-11">{{$user->email}}</div>
        </div>
    </div>
</div>

@include('layouts.footer')
