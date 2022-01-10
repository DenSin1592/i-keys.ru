<?php
use App\Services\Breadcrumbs\Factory;

$pageName = 'Страница не найдена';
$breadcrumbs = resolve(Factory::class)->init();
$breadcrumbs->add($pageName);
?>
@extends('client.layouts.default', ['breadcrumbs' => $breadcrumbs])

@section('title', $pageName)

@section('body_class')
    class='404-page d-flex flex-column'
@endsection

@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1" >
        <section class="section-404">
            <div class="container">
                <div class="article-post">
                    <h1 class="display-title title-h1">{!! $pageName !!}</h1>
                    <p>Запрашиваемая вами страница не существует или была удалена. <br> Вы можете вернуться на {{ link_to_route('home', 'главную страницу') }}.</p>
                </div>
            </div>
        </section>
    </main>
@endsection
