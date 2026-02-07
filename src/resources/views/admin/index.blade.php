@extends('layouts.app')

@section('css')
<link rel=stylesheet href="{{ asset('css/admin.css') }}">
@endsection

@section('header')
<div class="header-utilities">
    <form class="form" action="/logout" method="post">
        @csrf
        <button class="header-nav__button" type="submit">ログアウト</button>
    </form>
</div>
@endsection

