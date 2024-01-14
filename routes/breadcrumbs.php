<?php
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('ホーム', route('dashboard'));
});

    // ダッシュボード > ユーザ一覧
    Breadcrumbs::for('users', function ($trail) {
        $trail->parent('dashboard');
        $trail->push('ユーザ一覧', url('users'));
    });

    // ダッシュボード > サポート一覧
    Breadcrumbs::for('supports', function ($trail) {
        $trail->parent('dashboard');
        $trail->push('サポート一覧', url('support'));
    });

    // ダッシュボード > マスタ一覧
    Breadcrumbs::for('masters', function ($trail) {
        $trail->parent('dashboard');
        $trail->push('マスタ一覧', url('masters'));
    });

        // ダッシュボード > マスタ一覧 >  顧客種別マスタ
        Breadcrumbs::for('clientTypeMaster', function ($trail) {
            $trail->parent('masters');
            $trail->push('顧客種別マスタ', url('client-type'));
        });

        // Breadcrumbs::for('users', function ($trail) {
        //     $trail->parent('home');
        //     $trail->push('Users', route('users'));
        // });

        // ダッシュボード > マスタ一覧 >  [顧客種別マスタ]
        // Breadcrumbs::for('clientTypeMaster', function ($trail, $book) {
        //     $trail->parent('masters');
        //     $trail->push($book->book_title, url('books/' . $book->id));
        // });

// {{ Breadcrumbs::render('hogehoge') }}
