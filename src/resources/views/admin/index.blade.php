@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header')
<div class="header-utilities">
    <form class="form" action="/logout" method="post">
        @csrf
        <button class="header-nav__logout" type="submit">logout</button>
    </form>
</div>
@endsection

@section('content')
<div class="admin__content">
    <div class="admin__heading">
        <h2>Admin</h2>
    </div>
    <form class="form" action="/search" method="get">
        <div class="search__form">
            <div class="search-form__item">
                <input class="search-form__item--keyword" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
                <select class="search-form__item-select" name="gender">
                    <option value="">性別</option>
                    <option value="1" @selected(request('gender') == '1')>男性</option>
                    <option value="2" @selected(request('gender') == '2')>女性</option>
                    <option value="3" @selected(request('gender') == '3')>その他</option>
                </select>
                <select class="search-form__item-select" name="category_id">
                    <option value="">お問い合わせの種類</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string)request('category_id') === (string)$category->id)>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
                <input class="search-form__item-date" type="date" name="date" value="{{ request('date') }}">
            </div>
            <div class="search-form__button">
                <button class="search-form__button-submit" type="submit">検索</button>
                <button class="search-form__button-reset" type="reset">リセット</button>
            </div>
        </div>
    </form>
    <div class="admin__toolbar">
        <div class="export-form">
            <a class="export-form__button"href="{{ route('admin.export') }}" class="btn">
                エクスポート
            </a>
        </div>
        <div class="admin-pagination">
            {{ $contacts->links('vendor.pagination.tailwind2') }}
        </div>
    </div>
    <div class="admin-table">
        <table class="admin-table__inner">
            <tr class="admin-table__row">
                <th class="admin-table__header">お名前</th>
                <th class="admin-table__header">性別</th>
                <th class="admin-table__header">メールアドレス</th>
                <th class="admin-table__header">お問い合わせの種類</th>
                <th class="admin-table__header"></th>
            </tr>

            @foreach ($contacts as $contact)
            <tr class="admin-table__row">
                <td class="admin-table__item">{{ $contact->last_name }} {{ $contact->first_name }}</td>
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
                <td class="admin-table__detail">
                    <button
                        type="button"
                        class="admin-table__detail-button js-open-detail"
                        data-id="{{ $contact->id }}"
                        data-last_name="{{ $contact->last_name }}"
                        data-first_name="{{ $contact->first_name }}"
                        data-gender="{{ $contact->gender }}"
                        data-email="{{ $contact->email }}"
                        data-tel="{{ $contact->tel }}"
                        data-address="{{ $contact->address }}"
                        data-building="{{ $contact->building }}"
                        data-category="{{ optional($contact->category)->content }}"
                        data-detail="{{ $contact->detail }}"
                    >
                        詳細
                    </button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<dialog id="contactDialog" class="contact-dialog">
    <div class="contact-dialog__inner">
        <div class="contact-dialog__button">
            <button type="button" class="js-close-dialog" aria-label="閉じる">×</button>
        </div>

        <div class="contact-dialog__body">
            <table class="contact-dialog__table">
                <tr>
                    <th>お名前</th>
                    <td id="d-name"></td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td id="d-gender"></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td id="d-email"></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td id="d-tel"></td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td id="d-address"></td>
                </tr>
                <tr>
                    <th>建物名</th>
                    <td id="d-building"></td>
                </tr>
                <tr>
                    <th>お問い合わせの種類</th>
                    <td id="d-category"></td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td id="d-detail" style="white-space: pre-wrap;"></td>
                </tr>
            </table>
        </div>
        <div class="contact-dialog__delete">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button class="danger" type="submit">削除</button>
            </form>
        </div>
    </div>
</dialog>

<script>
    const dialog = document.getElementById('contactDialog');
    const deleteForm = document.getElementById('deleteForm');

    const genderLabel = (g) => {
        if (String(g) === '1') return '男性';
        if (String(g) === '2') return '女性';
        return 'その他';
    };

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.js-open-detail');
        if (btn) {
        document.getElementById('d-name').textContent =
            `${btn.dataset.last_name ?? ''} ${btn.dataset.first_name ?? ''}`.trim();

        document.getElementById('d-gender').textContent = genderLabel(btn.dataset.gender);
        document.getElementById('d-email').textContent = btn.dataset.email ?? '';
        document.getElementById('d-tel').textContent = btn.dataset.tel ?? '';
        document.getElementById('d-address').textContent = btn.dataset.address ?? '';
        document.getElementById('d-building').textContent = btn.dataset.building ?? '';
        document.getElementById('d-category').textContent = btn.dataset.category ?? '';
        document.getElementById('d-detail').textContent = btn.dataset.detail ?? '';

        deleteForm.action = `/admin/contacts/${btn.dataset.id}`;

        dialog.showModal();
        return;
        }

        if (e.target.closest('.js-close-dialog')) {
        dialog.close();
        }
    });

    dialog.addEventListener('click', (e) => {
        const inner = dialog.querySelector('.contact-dialog__inner');
        if (!inner.contains(e.target)) dialog.close();
    });
</script>
@endsection
