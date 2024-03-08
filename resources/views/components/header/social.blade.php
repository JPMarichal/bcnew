{{-- Google --}}
<!-- Tags de uso general para Google -->
<meta itemprop="name" content="@yield('site_name', 'Biblicomentarios.com')">
<meta itemprop="description" content="@yield('description', 'Análisis de la Biblia y de las revelaciones modernas')">
<meta itemprop="image" content="@yield('featured_image', asset('path_to_default_image'))">

{{-- Open Graph / Facebook --}}
<!-- Tags de Open Graph para Facebook y otras redes sociales -->
<meta property="og:site_name" content="@yield('site_name', 'Biblicomentarios.com')">
<meta property="og:title" content="@yield('title', 'Biblicomentarios.com')">
<meta property="og:description" content="@yield('description', 'Análisis de la Biblia y de las revelaciones modernas')">
<meta property="og:image" content="@yield('featured_image', asset('path_to_default_image'))">
<meta property="og:url" content="@yield('url', request()->url())">
<meta property="og:type" content="@yield('type', 'website')">
<meta property="og:locale" content="@yield('locale', 'es_ES')">
<meta property="article:published_time" content="@yield('published_time', 'FECHA_DE_PUBLICACION')">
<meta property="article:modified_time" content="@yield('modified_time', 'FECHA_DE_MODIFICACION')">
<meta property="article:author" content="@yield('author_url', 'URL_DEL_AUTOR')">
<meta property="og:image:width" content="960">
<meta property="og:image:height" content="540">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="@yield('title', 'Biblicomentarios.com')">

<meta property="fb:admins" content="@yield('fb_admins', '590703081059319')">
<meta property="fb:app_id" content="@yield('fb_admins', '590703081059319')">

{{-- Twitter --}}
<!-- Tags específicos de Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@Biblicomentarios">
<meta name="twitter:title" content="@yield('title', 'Biblicomentarios.com')">
<meta name="twitter:creator" content="@Biblicomentarios">
<meta name="twitter:description" content="@yield('description', 'Análisis de la Biblia y de las revelaciones modernas')">
<meta name="twitter:image" content="@yield('featured_image', asset('path_to_default_image'))">
<meta name="author" content="@yield('author', 'Juan Pablo Marichal')">
<meta name="twitter:label1" content="Autor">
<meta name="twitter:data1" content="@yield('twitter_author', 'Juan Pablo Marichal')">

{{-- Etiquetas específicas para producto --}}
@if(trim($__env->yieldContent('type')) === 'product')
    <meta property="og:price:amount" content="15.00" />
    <meta property="og:price:currency" content="USD" />
    <meta name="twitter:data1" content="$3">
    <meta name="twitter:label1" content="Price">
    <meta name="twitter:data2" content="Black">
    <meta name="twitter:label2" content="Color">
@endif

@endif
{{-- URL Canónica --}}
<!-- URL Canónica -->
<link rel="canonical" href="@yield('canonical_url', request()->url())">