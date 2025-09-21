<?php

use App\Models\Contract;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('ホーム', route('dashboard'));
});

        // ホーム > メッセージ
        Breadcrumbs::for('notifications', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('通知', route('notifications.index'));
        });

        // ホーム > 法人
        Breadcrumbs::for('corporations', function ($trail, $searchParams) {
            $trail->parent('dashboard');
            $trail->push('法人', route('corporations.index', $searchParams));
        });

                // ホーム > 法人 > 新規登録
                Breadcrumbs::for('createCorporation', function ($trail, $searchParams) {
                    $trail->parent('corporations', $searchParams);
                    $trail->push('新規作成', route('corporations.create'));
                });

                // ホーム > 法人 > 編集
                Breadcrumbs::for('editCorporation', function ($trail ,$corporation, $searchParams) {
                    $trail->parent('corporations', $searchParams);
                    $trail->push('編集', url('corporations/' . $corporation->id . '/edit'));
                });

                // ホーム > 法人 > CSVアップロード
                Breadcrumbs::for('csvUploadCorporation', function ($trail, $searchParams) {
                    $trail->parent('corporations', $searchParams);
                    $trail->push('CSVアップロード', route('corporations.showUploadForm'));
                });

        // ホーム > 顧客
        Breadcrumbs::for('clients', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('顧客', url('clients'));
        });

                // ホーム > 顧客 > 新規登録
                Breadcrumbs::for('createClient', function ($trail,) {
                    $trail->parent('clients');
                    $trail->push('新規作成', url('clients/create'));
                });

                // ホーム > 顧客 > 編集
                Breadcrumbs::for('editClient', function ($trail, $client) {
                    $trail->parent('clients');
                    $trail->push('編集', url('clients/' . $client->id . '/edit'));
                });

                // ホーム > 顧客 > CSVアップロード
                Breadcrumbs::for('csvUploadClients', function ($trail) {
                    $trail->parent('clients');
                    $trail->push('CSVアップロード', route('clients.showUploadForm'));
                });

        // ホーム > 導入製品
        Breadcrumbs::for('clientProducts', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('導入製品', route('client-products.index'));
        });

                // ホーム > 導入製品 > 新規登録
                Breadcrumbs::for('createClientProduct', function ($trail) {
                    $trail->parent('clientProducts');
                    $trail->push('登録', route('client-products.create'));
                });

                // ホーム > 導入製品 > 編集
                Breadcrumbs::for('editClientProduct', function ($trail, $clientProduct) {
                    $trail->parent('clientProducts');
                    $trail->push('編集', route('client-products.edit', $clientProduct));
                });


        // ホーム > 製品
        Breadcrumbs::for('products', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('製品', url('products'));
        });

                // ホーム > 製品 > 新規登録
                Breadcrumbs::for('createProduct', function ($trail) {
                    $trail->parent('products');
                    $trail->push('新規作成', url('products/create'));
                });

                // ホーム > 製品 > 編集
                Breadcrumbs::for('editProduct', function ($trail ,$product) {
                    $trail->parent('products');
                    $trail->push('編集', url('products/' . $product->id . '/edit'));
                });

                // ホーム > 製品 > CSVアップロード
                Breadcrumbs::for('csvUploadProducts', function ($trail) {
                    $trail->parent('products');
                    $trail->push('CSVアップロード', url('products/show-upload'));
                });

        // ホーム > 業者
        Breadcrumbs::for('vendors', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('業者', url('vendors'));
        });

                // ホーム > 業者 > 新規登録
                Breadcrumbs::for('createVendor', function ($trail) {
                    $trail->parent('vendors');
                    $trail->push('新規作成', url('vendors/create'));
                });

                // ホーム > 業者 > 編集
                Breadcrumbs::for('editVendor', function ($trail, $vendor) {
                    $trail->parent('vendors');
                    $trail->push('編集', url('vendors/' . $vendor->ulid . '/edit'));
                });

                // ホーム > 担当者 > CSVアップロード
                Breadcrumbs::for('csvUploadVendors', function ($trail) {
                    $trail->parent('vendors');
                    $trail->push('CSVアップロード', url('vendors/show-upload'));
                });

        // ホーム > 担当者
        Breadcrumbs::for('clientContacts', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('担当者', route('client-contacts.index'));
        });

                // ホーム > 担当者 > 新規登録
                Breadcrumbs::for('createClientContact', function ($trail) {
                    $trail->parent('clientContacts');
                    $trail->push('新規作成', route('client-contacts.create'));
                });

                // ホーム > 担当者 > 編集
                Breadcrumbs::for('editClientContact', function ($trail) {
                    $trail->parent('clientContacts');
                    $trail->push('編集', url('client-contact/edit'));
                });

                // ホーム > 担当者 > CSVアップロード
                Breadcrumbs::for('csvUploadClientContact', function ($trail) {
                    $trail->parent('clientContacts');
                    $trail->push('CSVアップロード', route('client-contacts.showUploadForm'));
                });

        // ホーム > サポート
        Breadcrumbs::for('supports', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('サポート', route('supports.index'));
        });
                // ホーム > サポート > 新規登録
                Breadcrumbs::for('createSupport', function ($trail) {
                    $trail->parent('supports');
                    $trail->push('新規作成', url('supports.create'));
                });

                // ホーム > サポート > 編集
                Breadcrumbs::for('editSupport', function ($trail ,$support) {
                    $trail->parent('supports');
                    $trail->push('編集', url('supports/' . $support->id . '/edit'));
                });

                // ホーム > サポート > CSVアップロード
                Breadcrumbs::for('csvUploadSupport', function ($trail) {
                    $trail->parent('supports');
                    $trail->push('CSVアップロード', route('supports.showUploadForm'));
                });


        // ホーム > 契約
        Breadcrumbs::for('contracts', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('契約', route('contracts.index')); // URLをroute関数を使って生成
        });

                // ホーム > 契約 > 新規登録
                Breadcrumbs::for('createContract', function ($trail) {
                    $trail->parent('contracts');
                    $trail->push('新規作成', route('contracts.create')); // URLをroute関数を使って生成
                });

                // ホーム > 契約 > 編集（例　ID=1）
                Breadcrumbs::for('editContract', function ($trail, $contract) {
                    $trail->parent('contracts');
                    $trail->push('編集（' . $contract->contract_num . '）', route('contracts.edit', $contract)); // $contractを直接渡す
                });

                // ホーム > 契約 > 編集 > 契約詳細新規登録
                Breadcrumbs::for('CreateContractDetail', function ($trail, $contract) {
                    $trail->parent('editContract', $contract);
                    $trail->push('契約詳細', route('contracts.details.create', $contract)); // $contractを直接渡す
                });

                // 契約基本編集画面（例　ID=1） > 契約詳細編集
                Breadcrumbs::for('editContractDetail', function ($trail, $contract) {
                    $trail->parent('editContract', $contract);
                    $trail->push('契約詳細', route('contracts.details.edit', $contract));
                });



        // ホーム > プロジェクト
        Breadcrumbs::for('projects', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('案件', url('projects'));
        });
                // ホーム > プロジェクト > プロジェクト新規登録
                Breadcrumbs::for('createProject', function ($trail) {
                    $trail->parent('projects');
                    $trail->push('新規作成', url('projects/create'));
                });

                // ホーム > プロジェクト > プロジェクト編集
                Breadcrumbs::for('editProject', function ($trail, $project) {
                    $trail->parent('projects');
                    $trail->push('編集', route('projects.edit', $project));
                });

                    // ホーム > プロジェクト > プロジェクト編集 > 見積新規
                    Breadcrumbs::for('createEstimate', function ($trail, $project) {
                        $trail->parent('editProject', $project);
                        $trail->push('見積新規', route('estimate.create', $project));
                    });

                    // ホーム > プロジェクト > プロジェクト編集 > 見積編集
                    Breadcrumbs::for('editEstimate', function ($trail, $project, $estimate) {
                        $trail->parent('editProject', $project);
                        $trail->push('見積編集', route('estimates.edit', ['projectId' => $project->id, 'estimateId' => $estimate->ulid]));
                    });

                // ホーム > プロジェクト > CSVアップロード
                Breadcrumbs::for('csvUploadProjects', function ($trail) {
                    $trail->parent('projects');
                    $trail->push('CSVアップロード', url('projects/show-upload'));
                });                
                
                
        // ホーム > 営業報告
        Breadcrumbs::for('reports', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('営業報告', url('reports'));
        });
                // ホーム > 営業報告 > 営業報告新規登録
                Breadcrumbs::for('createReport', function ($trail) {
                    $trail->parent('reports');
                    $trail->push('新規作成', url('reports/create'));
                });

                // ホーム > 営業報告 > 営業報告編集
                Breadcrumbs::for('editreport', function ($trail) {
                    $trail->parent('reports');
                    $trail->push('編集', url('reports/edit'));
                });

                // ホーム > 営業報告 > 営業報告確認
                Breadcrumbs::for('showReport', function ($trail, $report) {
                    $trail->parent('reports');
                    $trail->push('確認', url('reports/' . $report->id));
                });


        // ホーム > 預託情報
        Breadcrumbs::for('keepfiles', function ($trail, $searchParams) {
            $trail->parent('dashboard');
            $trail->push('預託情報', route('keepfiles.index', $searchParams));
        });

                // ホーム > 預託情報 > 預託情報新規登録
                Breadcrumbs::for('createKeepfile', function ($trail, $searchParams) {
                    $trail->parent('keepfiles', $searchParams);
                    $trail->push('新規作成', url('keepfile/create'));
                });

                // ホーム > 預託情報 > 預託情報編集
                Breadcrumbs::for('editKeepfile', function ($trail, $searchParams) {
                    $trail->parent('keepfiles', $searchParams);
                    $trail->push('編集', url('keepfile/edit'));
                });

        // ホーム > マスタ
        Breadcrumbs::for('masters', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('マスタ', url('masters'));
        });
        
                // ホーム > マスタ >  対応種別マスタ
                Breadcrumbs::for('contactTypeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('対応種別マスタ', route('contact-type.index'));
                });

                // ホーム > マスタ >  見積書住所マスタ
                Breadcrumbs::for('estimateAddressMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('見積書住所マスタ', route('estimate-address.index'));
                });

                // ホーム > マスタ >  製品シリーズマスタ
                Breadcrumbs::for('productSeriesMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('製品シリーズマスタ', route('product-series.index'));
                });

                // ホーム > マスタ >  製品バージョンマスタ
                Breadcrumbs::for('productVersionMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('製品バージョンマスタ', route('product-version.index'));
                });

                // ホーム > マスタ >  顧客種別マスタ
                Breadcrumbs::for('clientTypeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('顧客種別マスタ', url('client-type'));
                });
                
                // ホーム > マスタ >  サポート種別マスタ
                Breadcrumbs::for('supportTypeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('サポート種別', route('support-type.index'));
                });
                
                // ホーム > マスタ >  サポート時間マスタ
                Breadcrumbs::for('supportTimeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('サポート時間', route('support-time.index'));
                });

                // ホーム > マスタ >  営業種別マスタ
                Breadcrumbs::for('salesStageMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('営業種別', route('sales-stage.index'));
                });
                
                // ホーム > マスタ >  プロジェクト種別マスタ
                Breadcrumbs::for('projectTypeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('プロジェクト種別', route('project-type.index'));
                });

                // ホーム > マスタ >  営業報告種別マスタ
                Breadcrumbs::for('reportTypeMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('営業報告種別', route('report-type.index'));
                });

                // ホーム > マスタ >  会計期間マスタ
                Breadcrumbs::for('accountingPeriodMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('会計期間', route('accounting-period.index'));
                });

                

                // ホーム > マスタ >  都道府県マスタ
                Breadcrumbs::for('prefectureMaster', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('都道府県マスタ', route('prefecture.index'));
                });

                // ホーム > マスタ >  所属階層1
                Breadcrumbs::for('affiliation1s', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('所属階層1', route('affiliation1.index'));
                });

                        // ホーム > マスタ >  所属階層1 > 所属階層1新規
                        Breadcrumbs::for('createAffiliation1', function ($trail) {
                            $trail->parent('affiliation1s');
                            $trail->push('所属階層1新規', route('affiliation1.create'));
                        });

                        // ホーム > マスタ >  所属階層1 > 所属階層1新規
                        Breadcrumbs::for('editAffiliation1', function ($trail, $affiliation1) {
                            $trail->parent('affiliation1s');
                            $trail->push('所属階層1編集', route('affiliation1.edit', $affiliation1));
                        });

                // ホーム > マスタ >  所属階層2
                Breadcrumbs::for('affiliation2s', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('所属階層2', route('affiliation2.index'));
                });

                        // ホーム > マスタ >  所属階層2 > 所属階層2新規
                        Breadcrumbs::for('createAffiliation2', function ($trail) {
                            $trail->parent('affiliation2s');
                            $trail->push('所属階層2新規', route('affiliation2.create'));
                        });

                        // ホーム > マスタ >  所属階層2 > 所属階層2新規
                        Breadcrumbs::for('editAffiliation2', function ($trail, $affiliation2) {
                            $trail->parent('affiliation2s');
                            $trail->push('所属階層2編集', route('affiliation2.edit', $affiliation2));
                        });

                // ホーム > マスタ >  所属階層3
                Breadcrumbs::for('affiliation3s', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('所属階層3', route('affiliation3.index'));
                });

                        // ホーム > マスタ >  所属階層3 > 所属階層3新規
                        Breadcrumbs::for('createAffiliation3', function ($trail) {
                            $trail->parent('affiliation3s');
                            $trail->push('所属階層3新規', route('affiliation3.create'));
                        });

                        // ホーム > マスタ >  所属階層3 > 所属階層3新規
                        Breadcrumbs::for('editAffiliation3', function ($trail, $affiliation3) {
                            $trail->parent('affiliation3s');
                            $trail->push('所属階層3編集', route('affiliation3.edit', $affiliation3));
                        });

                // ホーム > マスタ > 所属部門
                Breadcrumbs::for('departments', function ($trail) {
                    $trail->parent('masters');
                    $trail->push('所属部門', route('departments.index'));
                });
                    // ホーム > マスタ > 所属部門 > 新規
                    Breadcrumbs::for('createDepartment', function ($trail) {
                        $trail->parent('departments');
                        $trail->push('新規', route('departments.create'));
                    });
                    // ホーム > マスタ > 所属部門 > 編集
                    Breadcrumbs::for('editDepartment', function ($trail, $department) {
                        $trail->parent('departments');
                        $trail->push('編集', route('departments.edit', $department));
                    });

                    

            // Breadcrumbs::for('users', function ($trail) {
            //     $trail->parent('home');
            //     $trail->push('Users', route('users'));
            // });

            // ホーム > マスタ >  [顧客種別マスタ]
            // Breadcrumbs::for('clientTypeMaster', function ($trail, $book) {
            //     $trail->parent('masters');
            //     $trail->push($book->book_title, url('books/' . $book->id));
            // });
            
        // ホーム > プロフィール
        Breadcrumbs::for('userProfile', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('アカウント情報', url('profile'));
        });

        // ホーム > ユーザ
        Breadcrumbs::for('users', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('ユーザ', url('users'));
        });
                // ホーム > ユーザ >  ユーザ新規作成
                Breadcrumbs::for('createUser', function ($trail) {
                    $trail->parent('users');
                    $trail->push('新規作成', route('users.create'));
                });
                
                // ホーム > ユーザ >  編集
                Breadcrumbs::for('editUser', function ($trail, $user) {
                    $trail->parent('users');
                    $trail->push('編集',route('users.edit', $user));
                });

                // ホーム > ユーザ > CSVアップロード
                Breadcrumbs::for('csvUploadUser', function ($trail, $searchParams) {
                    $trail->parent('users', $searchParams);
                    $trail->push('CSVアップロード', route('users.showUploadForm'));
                });                





// 共通機能


        // ホーム > 権限グループ管理
        Breadcrumbs::for('roleGroups', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('権限グループ管理', url('role-groups'));
        });
                // ホーム > 権限グループ管理 >  グループ新規作成
                Breadcrumbs::for('createRoleGroup', function ($trail) {
                    $trail->parent('roleGroups');
                    $trail->push('新規作成', url('role-groups.create'));
                });

                // ホーム > 権限グループ管理 >  グループ編集
                Breadcrumbs::for('editRoleGroup', function ($trail) {
                    $trail->parent('roleGroups');
                    $trail->push('編集', url('client-type'));
                });

        // ホーム > ログ
        Breadcrumbs::for('logs', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('操作ログ', route('logs.index'));
        });

            // ホーム > ログ > ログ詳細
            Breadcrumbs::for('showLog', function ($trail, $modelHistory) {
                $trail->parent('logs');
                $trail->push('操作ログ詳細', route('logs.show', $modelHistory));
            });


        // ホーム > 所属別リンク
        Breadcrumbs::for('Links', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('所属別リンク', url('link'));
        });


        Breadcrumbs::for('app-settings', function ($tail) {
            $tail->parent('dashboard');
            $tail->push('システム設定', route('app-settings.index'));
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

            Breadcrumbs::for('departmentSetting', function ($tail) {
                $tail->parent('app-settings');
                $tail->push('所属部門設定', route('department-settings.edit', 1));
            });


        // // ホーム > マスタ
        // Breadcrumbs::for('masters', function ($trail, $searchParams) {
        //     $trail->parent('dashboard');
        //     $trail->push('マスタ', route('masters.index', $searchParams));
        // });

        //         // ホーム > 権限グループ管理 >  グループ新規作成
        //         Breadcrumbs::for('prefectureMaster', function ($trail, $searchParams) {
        //             $trail->parent('masters', $searchParams);
        //             $trail->push('都道府県マスタ', route('prefecture.index'));
        //         });        

// {{ Breadcrumbs::render('hogehoge') }}
