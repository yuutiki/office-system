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

        // ダッシュボード > 預託情報一覧
        Breadcrumbs::for('keepfiles', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('預託情報一覧', url('keepfile'));
        });

                // ダッシュボード > 預託情報一覧 > 預託情報新規登録
                Breadcrumbs::for('createKeepfile', function ($trail) {
                    $trail->parent('keepfiles');
                    $trail->push('新規作成', url('keepfile/create'));
                });

                // ダッシュボード > 預託情報一覧 > 預託情報編集
                Breadcrumbs::for('editKeepfile', function ($trail) {
                    $trail->parent('keepfiles');
                    $trail->push('編集', url('keepfile/edit'));
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
