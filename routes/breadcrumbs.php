<?php

use App\Models\Contract;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('ホーム', route('dashboard'));
});

        // ダッシュボード > メッセージ一覧
        Breadcrumbs::for('notifications', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('通知一覧', route('notifications.index'));
        });

        // ダッシュボード > 法人一覧
        Breadcrumbs::for('corporations', function ($trail, $searchParams) {
            $trail->parent('dashboard');
            $trail->push('法人一覧', route('corporations.index', $searchParams));
        });

                // ダッシュボード > 法人一覧 > 新規登録
                Breadcrumbs::for('createCorporation', function ($trail, $searchParams) {
                    $trail->parent('corporations', $searchParams);
                    $trail->push('新規作成', route('corporations.create'));
                });

                // ダッシュボード > 法人一覧 > 編集
                Breadcrumbs::for('editCorporation', function ($trail ,$corporation, $searchParams) {
                    $trail->parent('corporations', $searchParams);
                    $trail->push('編集', url('corporations/' . $corporation->id . '/edit'));
                });

                // ダッシュボード > 法人一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadCorporation', function ($trail, $searchParams) {
                    $trail->parent('corporations', $searchParams);
                    $trail->push('CSVアップロード', route('corporations.showUploadForm'));
                });

        // ダッシュボード > 顧客一覧
        Breadcrumbs::for('clients', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('顧客一覧', url('clients'));
        });

                // ダッシュボード > 顧客一覧 > 新規登録
                Breadcrumbs::for('createClient', function ($trail,) {
                    $trail->parent('clients');
                    $trail->push('新規作成', url('clients/create'));
                });

                // ダッシュボード > 顧客一覧 > 編集
                Breadcrumbs::for('editClient', function ($trail, $client) {
                    $trail->parent('clients');
                    $trail->push('編集', url('clients/' . $client->id . '/edit'));
                });

                // ダッシュボード > 顧客一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadClients', function ($trail) {
                    $trail->parent('clients');
                    $trail->push('CSVアップロード', route('clients.showUploadForm'));
                });

        // ダッシュボード > 導入製品一覧
        Breadcrumbs::for('clientProducts', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('導入製品一覧', route('client-products.index'));
        });

                // ダッシュボード > 導入製品一覧 > 新規登録
                Breadcrumbs::for('createClientProduct', function ($trail) {
                    $trail->parent('clientProducts');
                    $trail->push('登録', route('client-products.create'));
                });

                // ダッシュボード > 導入製品一覧 > 編集
                Breadcrumbs::for('editClientProduct', function ($trail, $clientProduct) {
                    $trail->parent('clientProducts');
                    $trail->push('編集', route('client-products.edit', $clientProduct));
                });


        // ダッシュボード > 製品一覧
        Breadcrumbs::for('products', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('製品一覧', url('products'));
        });

                // ダッシュボード > 製品一覧 > 新規登録
                Breadcrumbs::for('createProduct', function ($trail) {
                    $trail->parent('products');
                    $trail->push('新規作成', url('products/create'));
                });

                // ダッシュボード > 製品一覧 > 編集
                Breadcrumbs::for('editProduct', function ($trail ,$product) {
                    $trail->parent('products');
                    $trail->push('編集', url('products/' . $product->id . '/edit'));
                });

                // ダッシュボード > 製品一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadProducts', function ($trail) {
                    $trail->parent('products');
                    $trail->push('CSVアップロード', url('products/show-upload'));
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
                Breadcrumbs::for('editVendor', function ($trail, $vendor) {
                    $trail->parent('vendors');
                    $trail->push('編集', url('vendors/' . $vendor->ulid . '/edit'));
                });

                // ダッシュボード > 担当者一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadVendors', function ($trail) {
                    $trail->parent('vendors');
                    $trail->push('CSVアップロード', url('vendors/show-upload'));
                });

        // ダッシュボード > 担当者一覧
        Breadcrumbs::for('clientContacts', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('担当者一覧', route('client-contacts.index'));
        });

                // ダッシュボード > 担当者一覧 > 新規登録
                Breadcrumbs::for('createClientContact', function ($trail) {
                    $trail->parent('clientContacts');
                    $trail->push('新規作成', route('client-contacts.create'));
                });

                // ダッシュボード > 担当者一覧 > 編集
                Breadcrumbs::for('editClientContact', function ($trail) {
                    $trail->parent('clientContacts');
                    $trail->push('編集', url('client-contact/edit'));
                });

                // ダッシュボード > 担当者一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadClientContact', function ($trail) {
                    $trail->parent('clientContacts');
                    $trail->push('CSVアップロード', route('client-contacts.showUploadForm'));
                });

        // ダッシュボード > サポート一覧
        Breadcrumbs::for('supports', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('サポート一覧', route('supports.index'));
        });
                // ダッシュボード > サポート一覧 > サポート新規登録
                Breadcrumbs::for('createSupport', function ($trail) {
                    $trail->parent('supports');
                    $trail->push('新規作成', url('supports.create'));
                });

                // ダッシュボード > サポート一覧 > 編集
                Breadcrumbs::for('editSupport', function ($trail ,$support) {
                    $trail->parent('supports');
                    $trail->push('編集', url('supports/' . $support->id . '/edit'));
                });

                // ダッシュボード > サポート一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadSupport', function ($trail) {
                    $trail->parent('supports');
                    $trail->push('CSVアップロード', route('supports.showUploadForm'));
                });


        // ダッシュボード > 契約一覧
        Breadcrumbs::for('contracts', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('契約一覧', route('contracts.index')); // URLをroute関数を使って生成
        });

                // ダッシュボード > 契約一覧 > 契約新規登録
                Breadcrumbs::for('createContract', function ($trail) {
                    $trail->parent('contracts');
                    $trail->push('新規作成', route('contracts.create')); // URLをroute関数を使って生成
                });

                // 契約一覧 > 契約基本編集画面（例　ID=1）
                Breadcrumbs::for('editContract', function ($trail, $contract) {
                    $trail->parent('contracts');
                    $trail->push('契約基本（' . $contract->contract_num . '）', route('contracts.edit', $contract)); // $contractを直接渡す
                });

                // 契約基本編集画面（例　ID=1） > 契約詳細新規登録
                Breadcrumbs::for('CreateContractDetail', function ($trail, $contract) {
                    $trail->parent('editContract', $contract);
                    $trail->push('契約詳細', route('contracts.details.create', $contract)); // $contractを直接渡す
                });

                // 契約基本編集画面（例　ID=1） > 契約詳細編集
                Breadcrumbs::for('editContractDetail', function ($trail, $contract) {
                    $trail->parent('editContract', $contract);
                    $trail->push('契約詳細', route('contracts.details.edit', $contract));
                });



        // ダッシュボード > プロジェクト一覧
        Breadcrumbs::for('projects', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('案件一覧', url('projects'));
        });
                // ダッシュボード > プロジェクト一覧 > プロジェクト新規登録
                Breadcrumbs::for('createProject', function ($trail) {
                    $trail->parent('projects');
                    $trail->push('新規作成', url('projects/create'));
                });

                // ダッシュボード > プロジェクト一覧 > プロジェクト編集
                Breadcrumbs::for('editProject', function ($trail, $project) {
                    $trail->parent('projects');
                    $trail->push('編集', route('projects.edit', $project));
                });

                    // ダッシュボード > プロジェクト一覧 > プロジェクト編集 > 見積新規
                    Breadcrumbs::for('createEstimate', function ($trail, $project) {
                        $trail->parent('editProject', $project);
                        $trail->push('見積新規', route('estimate.create', $project));
                    });

                    // ダッシュボード > プロジェクト一覧 > プロジェクト編集 > 見積編集
                    Breadcrumbs::for('editEstimate', function ($trail, $project, $estimate) {
                        $trail->parent('editProject', $project);
                        $trail->push('見積編集', route('estimates.edit', ['projectId' => $project->id, 'estimateId' => $estimate->ulid]));
                    });

                // ダッシュボード > プロジェクト一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadProjects', function ($trail) {
                    $trail->parent('projects');
                    $trail->push('CSVアップロード', url('projects/show-upload'));
                });                
                
                
        // ダッシュボード > 営業報告一覧
        Breadcrumbs::for('reports', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('営業報告一覧', url('reports'));
        });
                // ダッシュボード > 営業報告一覧 > 営業報告新規登録
                Breadcrumbs::for('createReport', function ($trail) {
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
        Breadcrumbs::for('keepfiles', function ($trail, $searchParams) {
            $trail->parent('dashboard');
            $trail->push('預託情報一覧', route('keepfiles.index', $searchParams));
        });

                // ダッシュボード > 預託情報一覧 > 預託情報新規登録
                Breadcrumbs::for('createKeepfile', function ($trail, $searchParams) {
                    $trail->parent('keepfiles', $searchParams);
                    $trail->push('新規作成', url('keepfile/create'));
                });

                // ダッシュボード > 預託情報一覧 > 預託情報編集
                Breadcrumbs::for('editKeepfile', function ($trail, $searchParams) {
                    $trail->parent('keepfiles', $searchParams);
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
                
                // ダッシュボード > マスタ一覧 >  サポート種別マスタ
                Breadcrumbs::for('supportTypeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('サポート種別', route('support-type.index'));
                });
                
                // ダッシュボード > マスタ一覧 >  サポート時間マスタ
                Breadcrumbs::for('supportTimeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('サポート時間', route('support-time.index'));
                });

                // ダッシュボード > マスタ一覧 >  営業種別マスタ
                Breadcrumbs::for('salesStageMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('営業種別', route('sales-stage.index'));
                });
                
                // ダッシュボード > マスタ一覧 >  プロジェクト種別マスタ
                Breadcrumbs::for('projectTypeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('プロジェクト種別', route('project-type.index'));
                });

                // ダッシュボード > マスタ一覧 >  営業報告種別マスタ
                Breadcrumbs::for('reportTypeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('営業報告種別', route('report-type.index'));
                });

                // ダッシュボード > マスタ一覧 >  会計期間マスタ
                Breadcrumbs::for('accountingPeriodMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('会計期間', route('accounting-period.index'));
                });

                

                // ダッシュボード > マスタ一覧 >  都道府県マスタ
                Breadcrumbs::for('prefectureMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('都道府県マスタ', route('prefecture.index'));
                });

                // ダッシュボード > マスタ一覧 >  所属階層1一覧
                Breadcrumbs::for('affiliation1s', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('所属階層1一覧', route('affiliation1.index'));
                });

                        // ダッシュボード > マスタ一覧 >  所属階層1一覧 > 所属階層1新規
                        Breadcrumbs::for('createAffiliation1', function ($trail) {
                            $trail->parent('affiliation1s');
                            $trail->push('所属階層1新規', route('affiliation1.create'));
                        });

                        // ダッシュボード > マスタ一覧 >  所属階層1一覧 > 所属階層1新規
                        Breadcrumbs::for('editAffiliation1', function ($trail, $affiliation1) {
                            $trail->parent('affiliation1s');
                            $trail->push('所属階層1編集', route('affiliation1.edit', $affiliation1));
                        });

                // ダッシュボード > マスタ一覧 >  所属階層2一覧
                Breadcrumbs::for('affiliation2s', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('所属階層2一覧', route('affiliation2.index'));
                });

                        // ダッシュボード > マスタ一覧 >  所属階層2一覧 > 所属階層2新規
                        Breadcrumbs::for('createAffiliation2', function ($trail) {
                            $trail->parent('affiliation2s');
                            $trail->push('所属階層2新規', route('affiliation2.create'));
                        });

                        // ダッシュボード > マスタ一覧 >  所属階層2一覧 > 所属階層2新規
                        Breadcrumbs::for('editAffiliation2', function ($trail, $affiliation2) {
                            $trail->parent('affiliation2s');
                            $trail->push('所属階層2編集', route('affiliation2.edit', $affiliation2));
                        });

                // ダッシュボード > マスタ一覧 >  所属階層3一覧
                Breadcrumbs::for('affiliation3s', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('所属階層3一覧', route('affiliation3.index'));
                });

                        // ダッシュボード > マスタ一覧 >  所属階層3一覧 > 所属階層3新規
                        Breadcrumbs::for('createAffiliation3', function ($trail) {
                            $trail->parent('affiliation3s');
                            $trail->push('所属階層3新規', route('affiliation3.create'));
                        });

                        // ダッシュボード > マスタ一覧 >  所属階層3一覧 > 所属階層3新規
                        Breadcrumbs::for('editAffiliation3', function ($trail, $affiliation3) {
                            $trail->parent('affiliation3s');
                            $trail->push('所属階層3編集', route('affiliation3.edit', $affiliation3));
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
            
        // ダッシュボード > プロフィール
        Breadcrumbs::for('userProfile', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('アカウント情報', url('profile'));
        });

        // ダッシュボード > ユーザ一覧
        Breadcrumbs::for('users', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('ユーザ一覧', url('users'));
        });
                // ダッシュボード > ユーザ一覧 >  ユーザ新規作成
                Breadcrumbs::for('createUser', function ($trail) {
                    $trail->parent('users');
                    $trail->push('新規作成', route('users.create'));
                });
                
                // ダッシュボード > ユーザ一覧 >  編集
                Breadcrumbs::for('editUser', function ($trail, $user) {
                    $trail->parent('users');
                    $trail->push('編集',route('users.edit', $user));
                });

                // ダッシュボード > ユーザ一覧 > CSVアップロード
                Breadcrumbs::for('csvUploadUser', function ($trail, $searchParams) {
                    $trail->parent('users', $searchParams);
                    $trail->push('CSVアップロード', route('users.showUploadForm'));
                });                





// 共通機能


        // ダッシュボード > 権限グループ管理
        Breadcrumbs::for('roleGroups', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('権限グループ管理', url('role-groups'));
        });
                // ダッシュボード > 権限グループ管理 >  グループ新規作成
                Breadcrumbs::for('createRoleGroup', function ($trail) {
                    $trail->parent('roleGroups');
                    $trail->push('新規作成', url('role-groups.create'));
                });

                // ダッシュボード > 権限グループ管理 >  グループ編集
                Breadcrumbs::for('editRoleGroup', function ($trail) {
                    $trail->parent('roleGroups');
                    $trail->push('編集', url('client-type'));
                });

        // ダッシュボード > ログ一覧
        Breadcrumbs::for('logs', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('操作ログ一覧', route('logs.index'));
        });

            // ダッシュボード > ログ一覧 > ログ詳細
            Breadcrumbs::for('showLog', function ($trail, $modelHistory) {
                $trail->parent('logs');
                $trail->push('操作ログ詳細', route('logs.show', $modelHistory));
            });


        // ダッシュボード > 所属別リンク一覧
        Breadcrumbs::for('Links', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('所属別リンク一覧', url('link'));
        });


        Breadcrumbs::for('app-settings', function ($tail) {
            $tail->parent('dashboard');
            $tail->push('システム設定一覧', route('app-settings.index'));
        });

            Breadcrumbs::for('affiliation-level-setting', function ($tail) {
                $tail->parent('app-settings');
                $tail->push('所属階層利用設定', route('app-settings.index'));
            });

            Breadcrumbs::for('smtp-settings', function ($tail) {
                $tail->parent('app-settings');
                $tail->push('送信元SMTP情報設定', route('smtp-settings.index'));
            });

                Breadcrumbs::for('createSmtpSetting', function ($tail) {
                    $tail->parent('smtp-settings');
                    $tail->push('新規作成', route('smtp-settings.create'));
                });

                Breadcrumbs::for('editSmtpSetting', function ($tail, $smtpSetting) {
                    $tail->parent('smtp-settings');
                    $tail->push('編集', route('smtp-settings.edit', $smtpSetting));
                });

            Breadcrumbs::for('password-policy-setting', function ($tail) {
                $tail->parent('app-settings');
                $tail->push('パスワードポリシー設定', route('password-policy.edit', 1));
            });


        // // ダッシュボード > マスタ一覧
        // Breadcrumbs::for('masters', function ($trail, $searchParams) {
        //     $trail->parent('dashboard');
        //     $trail->push('マスタ一覧', route('masters.index', $searchParams));
        // });

        //         // ダッシュボード > 権限グループ管理 >  グループ新規作成
        //         Breadcrumbs::for('prefectureMaster', function ($trail, $searchParams) {
        //             $trail->parent('masters', $searchParams);
        //             $trail->push('都道府県マスタ', route('prefecture.index'));
        //         });        

// {{ Breadcrumbs::render('hogehoge') }}
