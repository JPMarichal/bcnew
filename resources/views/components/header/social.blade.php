{{-- Open Graph / Facebook --}}
<meta property="og:site_name" content="@yield('site_name', 'Biblicomentarios.com')">
<meta property="og:title" content="@yield('title', 'Biblicomentarios.com')">
<meta property="og:description" content="@yield('description', 'Descripción predeterminada de tu sitio')">
<meta property="og:image" content="@yield('featured_image', asset('path_to_default_image'))">
<meta property="og:url" content="@yield('url', request()->url())">
<meta property="og:type" content="@yield('type', 'website')">
<meta property="fb:admins" content="@yield('fb_admins', 'ID_DEL_ADMINISTRADOR')">
<meta property="og:locale" content="@yield('locale', 'es_ES')">
<meta property="article:published_time" content="@yield('published_time', 'FECHA_DE_PUBLICACION')">
<meta property="article:modified_time" content="@yield('modified_time', 'FECHA_DE_MODIFICACION')">
<meta property="article:author" content="@yield('author_url', 'URL_DEL_AUTOR')">
<meta property="og:image:width" content="960">
<meta property="og:image:height" content="540">
<meta property="og:image:type" content="image/jpeg">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', 'Biblicomentarios.com')">
<meta name="twitter:description" content="@yield('description', 'Descripción predeterminada de tu sitio')">
<meta name="twitter:image" content="@yield('featured_image', asset('path_to_default_image'))">
<meta name="author" content="@yield('author', 'Nombre del Autor')">
<meta name="twitter:label1" content="Written by">
<meta name="twitter:data1" content="@yield('twitter_author', 'Nombre del Autor')">
<meta name="twitter:label2" content="Est. reading time">
<meta name="twitter:data2" content="@yield('reading_time', 'Tiempo de lectura')">

{{-- URL Canónica --}}
<link rel="canonical" href="@yield('canonical_url', request()->url())">
