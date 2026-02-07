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

@section('content')
<div class="admin__content">
    <div class="admin__heading">
        <h2>Admin</h2>
    </div>
    <form class="search-form" action="/search" method="get">
        <div class="search-form__item">
            <input class="search-form__item-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください"　value="{{ old('keyword') }}">
            <select class="search-form__item-select" name="gender">
                <option value="">性別</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
            <select class="search-form__item-select" name="category_id">
                <option value="">お問い合わせの種類</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->content }}</option>
                    @endforeach
            </select>
            <input class="search-form__item-input" type="date" name="date" value="{{ request('date') }}">
        </div>
        <div class="search-form__button">
            <button class="search-form__button-submit" type="submit">検索</button>
            <button class="search-form__button-reset" type="reset">リセット</button>
        </div>
    </form>
     <div class="admin-pagination">
            {{ $contacts->links('vendor.pagination.tailwind2') }}
    </div>
    <div class="admin-table">
        <table class="admin-table__inner">
            <tr class="admin-table__row">
                <th class="admin-table__header">お名前</th>
                <th class="admin-table__header">性別</th>
                <th class="admin-table__header">メールアドレス</th>
                <th class="admin-table__header">お問い合わせの種類</th>
            </tr>
            @foreach ($contacts as $contact)
            <tr class="admin-table__row">
                <td class="admin-table__item">
                    {{ $contact->last_name }} {{ $contact->first_name }}
                </td>
                <td class="admin-table__item">
                    @if($contact->gender == 1)
                        男性
                    @elseif($contact->gender == 2)
                        女性
                    @else
                        その他
                    @endif
                </td>
                <td class="admin-table__item">{{ $contact->email }}</td>
                <td class="admin-table__item">{{ optional($contact->category)->content }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection