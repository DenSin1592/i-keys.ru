<?php
use App\Services\Breadcrumbs\Factory;

$pageName = 'Страница не найдена';
$breadcrumbs = resolve(Factory::class)->init();
$breadcrumbs->add($pageName);
?>
@extends('client.layouts.default', ['breadcrumbs' => $breadcrumbs])

@section('title', $pageName)

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="content-inner col">
                    <h1 class="display-title">{!! $pageName !!}</h1>

                    <div class="article">
                        Запрашиваемая вами страница не существует или была удалена.<br/>
                        Вы можете вернуться на {{ link_to_route('home', 'главную страницу') }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
