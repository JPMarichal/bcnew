@extends('layouts.main')

@section('title', $volumen->title)
@section('description', $volumen->description)
@section('robots', 'index, follow')

@section('featured_image', $volumen->featured_image)
@section('published_time', now()->toIso8601String())
@section('modified_time', now()->toIso8601String())
@section('author', 'Juan Pablo Marichal')
@section('type', 'article')
@section('twitter_author', 'JPMarichal')

@section('content')
<div class="container mt-3">
    <h1>{{$volumen->nombre }}</h1>
    <div class="border border-rounded p-2 bg-success text-white text-center">{{$volumen->description}}</div>
    <P class="mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem et voluptatem necessitatibus magnam facere ex, ipsa doloremque beatae quos perspiciatis possimus pariatur commodi aliquam voluptates, odio iusto eum cum atque!
    Commodi soluta fugit architecto impedit porro doloremque eligendi, modi autem dolore quam, perferendis unde ullam dolores harum neque eius repudiandae necessitatibus quibusdam cupiditate placeat aliquid vel ab ad. Aliquam, perferendis!</p>
    <ul><li>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laborum, enim blanditiis totam unde tempora fugit corporis laudantium voluptate dolor dolores eligendi, pariatur amet quas ducimus. Ipsa quo atque aperiam labore!</li>
    <li>Voluptas earum ipsa asperiores distinctio. Reiciendis illo earum voluptate placeat soluta beatae animi. Corporis totam dolorum exercitationem perspiciatis consectetur ut, quod laboriosam quo vel fugit veniam magni enim placeat deleniti!</li>
    <li>Consectetur accusamus cum, omnis ratione, ullam neque reprehenderit perferendis inventore eum necessitatibus adipisci asperiores laboriosam. Iusto odio dolorem quos veniam explicabo magnam totam et! Esse porro quia provident similique dolor!</li>
    <li>Culpa ut dolorum magnam a! Quasi vel dolor amet ea ratione quod ipsam, autem cum sit accusamus doloribus incidunt unde at beatae omnis architecto tempore esse. Laborum sunt repudiandae provident.</li>
    <li>Voluptate, doloremque quam. Voluptate rem voluptatem iste, perspiciatis, consequuntur sapiente sed rerum ratione vitae reprehenderit sequi incidunt culpa quas eum minima, velit fuga ex atque cumque itaque delectus dolorem. Optio.</li>
    <li>Repudiandae vero suscipit repellendus dolorum repellat perferendis maiores voluptatibus, soluta eveniet blanditiis consequatur expedita odit cumque. Incidunt eum iure vero, ipsum delectus vel consectetur expedita, ratione dignissimos, quidem deleniti ipsam!</li>
    <li>Inventore, repudiandae rerum in nam deserunt molestiae quae nobis iure modi maiores est voluptates similique aliquid expedita. Non ea eum cupiditate, molestias ipsam provident ipsum eligendi quaerat. Asperiores, in eaque!</li>
    <li>Veniam voluptatem voluptates cumque laborum mollitia nam doloremque repudiandae totam et sunt saepe, fugiat dolore quam perspiciatis ut laboriosam nulla, pariatur similique voluptatum? Iure recusandae voluptas, ratione sapiente maxime quis.</li>
    <li>Numquam quia ab quis mollitia sed debitis vel sequi, rerum, fuga laudantium quam! Officia natus quibusdam explicabo suscipit laborum ea modi magnam. Odit reiciendis quidem, dolore aspernatur enim officiis fugit.</li>
    <li>Quaerat cum quisquam alias consequuntur veniam asperiores debitis illo excepturi exercitationem? Perferendis rem fugit minima inventore culpa, esse veniam facere! Quidem, saepe explicabo dolore pariatur autem mollitia totam laboriosam numquam!</li>
    <li>Minus cupiditate repudiandae praesentium! Inventore totam ipsa quisquam corporis hic. Odio praesentium veritatis animi facere fuga architecto esse cumque excepturi fugit voluptatem, illo at repudiandae dolorem eveniet debitis rem eaque?</li>
    <li>Corporis unde corrupti architecto fugit excepturi nam ipsa doloribus iure molestiae reiciendis laudantium, incidunt aspernatur consequuntur numquam ad nesciunt, beatae harum in rerum, voluptate porro tempora pariatur voluptas culpa! Quidem.</li>
    <li>Nihil omnis repudiandae est consequuntur corrupti similique mollitia, corporis tempore rerum voluptatibus iste iure explicabo aut accusantium excepturi expedita ab minus perferendis at. Earum quos, obcaecati nam perferendis labore beatae.</li>
    <li>In est, similique temporibus assumenda alias porro sequi sit delectus nesciunt sed voluptatem numquam explicabo consequuntur aperiam laboriosam nemo quasi. Dignissimos eveniet ullam a vel iste! Vitae harum minus molestiae.</li>
    <li>Nihil quibusdam aliquid reiciendis cum fugiat quisquam voluptate enim quo facere autem! Sapiente architecto cupiditate, enim quo amet rerum veritatis dolor molestiae qui harum blanditiis! Vel commodi quasi minima porro.</li>
    </ul>
</div>
@endsection