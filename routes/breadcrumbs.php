<?php
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('ホーム', route('dashboard'));
});

        // ダッシュボード > 法人一覧
        Breadcrumbs::for('corporations', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('法人一覧', url('corporations'));
        });

                // ダッシュボード > 法人一覧 > 新規登録
                Breadcrumbs::for('createCorporation', function ($trail) {
                    $trail->parent('corporations');
                    $trail->push('新規作成', url('corporations/create'));
                });

                // ダッシュボード > 法人一覧 > 編集
                Breadcrumbs::for('editCorporation', function ($trail ,$corporation) {
                    $trail->parent('corporations');
                    $trail->push('編集', url('corporations/' . $corporation->id . '/edit'));
                });

                // ダッシュボード > 法人一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadCorporation', function ($trail) {
                    $trail->parent('corporations');
                    $trail->push('CSVアップロード', url('corporations/show-upload'));
                });

        // ダッシュボード > 顧客一覧
        Breadcrumbs::for('clients', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('顧客一覧', url('client'));
        });

                // ダッシュボード > 顧客一覧 > 新規登録
                Breadcrumbs::for('createClient', function ($trail,) {
                    $trail->parent('clients');
                    $trail->push('新規作成', url('client/create'));
                });

                // ダッシュボード > 顧客一覧 > 編集
                Breadcrumbs::for('editClient', function ($trail, $client) {
                    $trail->parent('clients');
                    $trail->push('編集', url('client/' . $client->id . '/edit'));
                });

                        // ダッシュボード > 顧客一覧 > 編集 > 導入システム新規登録
                        Breadcrumbs::for('createClientProduct', function ($trail) {
                            $trail->parent('editClient');
                            $trail->push('導入システム登録', url('client-product/create'));
                        });

        // ダッシュボード > 業者一覧
        Breadcrumbs::for('vendors', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('業者一覧', url('vendors'));
        });

                // ダッシュボード > 業者一覧 > 新規登録
                Breadcrumbs::for('createVendor', function ($trail) {
                    $trail->parent('vendors');
                    $trail->push('新規作成', url('vendors/create'));
                });

                // ダッシュボード > 業者一覧 > 編集
                Breadcrumbs::for('editVendor', function ($trail) {
                    $trail->parent('vendors');
                    $trail->push('編集', url('vendors/edit'));
                });

        // ダッシュボード > 担当者一覧
        Breadcrumbs::for('clientpersons', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('担当者一覧', url('client-person'));
        });

                // ダッシュボード > 担当者一覧 > 新規登録
                Breadcrumbs::for('createclientperson', function ($trail) {
                    $trail->parent('clientpersons');
                    $trail->push('新規作成', url('client-person/create'));
                });

                // ダッシュボード > 担当者一覧 > 編集
                Breadcrumbs::for('editclientperson', function ($trail) {
                    $trail->parent('clientpersons');
                    $trail->push('編集', url('client-person/edit'));
                });

        // ダッシュボード > ユーザ一覧
        Breadcrumbs::for('users', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('ユーザ一覧', url('user'));
        });

        // ダッシュボード > サポート一覧
        Breadcrumbs::for('supports', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('サポート一覧', url('support'));
        });
                // ダッシュボード > サポート一覧 > サポート新規登録
                Breadcrumbs::for('createSupport', function ($trail) {
                    $trail->parent('supports');
                    $trail->push('新規作成', url('support/create'));
                });


        // ダッシュボード > 契約一覧
        Breadcrumbs::for('contracts', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('契約一覧', url('contract'));
        });
                // ダッシュボード > 契約一覧 > 契約新規登録
                Breadcrumbs::for('createContract', function ($trail) {
                    $trail->parent('contracts');
                    $trail->push('新規作成', url('contract/create'));
                });

        // ダッシュボード > 営業報告一覧
        Breadcrumbs::for('reports', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('営業報告一覧', url('reports'));
        });
                // ダッシュボード > 営業報告一覧 > 営業報告新規登録
                Breadcrumbs::for('createreport', function ($trail) {
                    $trail->parent('reports');
                    $trail->push('新規作成', url('reports/create'));
                });

                // ダッシュボード > 営業報告一覧 > 営業報告編集
                Breadcrumbs::for('editreport', function ($trail) {
                    $trail->parent('reports');
                    $trail->push('編集', url('reports/edit'));
                });

                // ダッシュボード > 営業報告一覧 > 営業報告確認
                Breadcrumbs::for('showReport', function ($trail, $report) {
                    $trail->parent('reports');
                    $trail->push('確認', url('reports/' . $report->id));
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
