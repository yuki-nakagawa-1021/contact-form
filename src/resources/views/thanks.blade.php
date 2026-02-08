@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('no_header')
@endsection

@section('content')
<div class="thanks__overlay">
    <h1 class="thanks__title">Thank you</h1>
    <div class="thanks__content">
        <div class="thanks__heading">
            <h2>お問い合わせありがとうございました</h2>
        </div>
        <a class="home-button" href="/">HOME</a>
    </div>
</div>
@endsection
