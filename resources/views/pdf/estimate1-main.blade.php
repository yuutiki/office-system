<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .hanko-container {
            width: 100%;
            margin-top: 20px;
            margin-left: 80px;
        }
        .hanko {
            float: left;
            width: 26%; /* 3つの印鑑欄を横並びにするために幅を調整 */
            height: 70px;
            border: 1px solid #000;
        }

    </style>
    <title>御見積書</title>
</head>
<body>
    {{-- headder --}}
        <h1 class="" style="text-align: center; text-decoration: underline; margin: 0%;">{{ $estimate->estimate_document_title }}</h1>
        
        <div style="">
            <div class="header" style="font-size: 12px; text-decoration: underline; text-align: right; font-family: notosansjp; margin-right: 30px;">見積作成日 : {{ $estimate->formatted_date }}</div>
            <div class="header" style="font-size: 12px; text-decoration: underline; text-align: right; font-family: notosansjp;">見積番号 : {{ $estimate->estimate_num }}</div>
        </div>


        <div style="width: 100%;">
            <div id="jyoken" style="float: left; width: 48%; margin-right: 2%;">
                <div class="" style="font-size: 14px; text-decoration: underline; font-family: notosansjp;">{{ $estimate->estimate_recipient }} 御中</div>
                <div class="" style="margin-top: 10px; margin-bottom: 20px; font-size: 12px; font-family: notosansjp;">下記の通り御見積申し上げます。</div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 30%; padding: 2px 0; border-bottom: 0.5px solid #000; font-size: 12px;">受渡期日</td>
                        <td style="width: 70%; padding: 2px 0; border-bottom: 0.5px solid #000; font-size: 12px;">{{ $estimate->delivery_at }}</td>
                    </tr>
                    <tr><td colspan="2" style="height: 16px;"></td></tr>
                    <tr>
                        <td style="width: 30%; padding: 2px 0; border-bottom: 0.5px solid #000; font-size: 12px;">受渡場所</td>
                        <td style="width: 70%; padding: 2px 0; border-bottom: 0.5px solid #000; font-size: 12px;">{{ $estimate->delivery_place }}</td>
                    </tr>
                    <tr><td colspan="2" style="height: 16px;"></td></tr>
                    <tr>
                        <td style="width: 30%; padding: 2px 0; border-bottom: 0.5px solid #000; font-size: 12px;">取引方法</td>
                        <td style="width: 70%; padding: 2px 0; border-bottom: 0.5px solid #000; font-size: 12px;">{{ $estimate->transaction_method }}</td>
                    </tr>
                    <tr><td colspan="2" style="height: 16px;"></td></tr>
                    <tr>
                        <td style="width: 30%; padding: 2px 0; border-bottom: 0.5px solid #000; font-size: 12px;">有効期限</td>
                        <td style="width: 70%; padding: 2px 0; border-bottom: 0.5px solid #000; font-size: 12px;">{{ $estimate->expiration_at }}</td>
                    </tr>
                </table>
                <div style="height: 8px;"></div>
                <table style="width: 100%; border-collapse: collapse; font-size: 15px;">
                    <tr>
                        <td style="width: 30%; padding: 2px 0; border-bottom: 0.5px solid #000;">御見積金額計</td>
                        <td style="width: 70%; padding: 2px 0; border-bottom: 0.5px solid #000; text-align: right;">&yen;{{ number_format($estimate->total_with_tax) }}（税込）</td>
                    </tr>
                </table>
            </div>

            <div id="from" style="float: left; width: 48%; padding: 1%; margin-left: 40px;">
                <div style="text-align: left; margin-bottom: 1px; padding-top: 5px; margin-left: 20px;">
                    <div style="display: inline-block; vertical-align: top;">
                        @if($estimate->project->accountAffiliation1->company_logo_image)
                            <img src="{{ public_path('storage/' . $estimate->project->accountAffiliation1->company_logo_image) }}" style="width: 130px; height: 30px; display: block;">
                        @else
                            <div style="width: 130px; height: 30px; display: block;"></div>
                        @endif
                        <div style="font-size: 14px; margin-top: 5px;">{{ $estimate->project->accountAffiliation1->affiliation1_name }}</div>
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 110px; margin-top: -55px;">
                        @if($estimate->project->accountAffiliation1->company_stamp_image)
                            <img src="{{ public_path('storage/' . $estimate->project->accountAffiliation1->company_stamp_image) }}" style="width: 60px; height: 60px;">
                        @else
                            <div style="width: 60px; height: 60px;"></div>
                        @endif
                    </div>
                </div>

                <!-- 住所1 -->
                @if($estimate->estimateAddress->estimate_address_1)
                    <div style="margin-left: 20px; font-size: 12px;">{{ $estimate->estimateAddress->estimate_address_1 }}</div>
                @endif
                <!-- 住所2 -->
                @if($estimate->estimateAddress->estimate_address_2)
                    <div style="margin-left: 20px; font-size: 12px;">{{ $estimate->estimateAddress->estimate_address_2 }}</div>
                @endif
                <!-- 住所3 -->
                @if($estimate->estimateAddress->estimate_address_3)
                    <div style="margin-left: 20px; font-size: 12px;">{{ $estimate->estimateAddress->estimate_address_3 }}</div>
                @endif

                <!-- TEL/FAX -->
                @if($estimate->estimateAddress->estimate_address_tel || $estimate->estimateAddress->estimate_address_fax)
                    <div style="margin-left: 20px; font-size: 12px;">
                        @if($estimate->estimateAddress->estimate_address_tel)
                            <span style="display: inline-block;">TEL.{{ $estimate->estimateAddress->estimate_address_tel }}</span>
                        @endif
                        @if($estimate->estimateAddress->estimate_address_fax)
                            <span style="display: inline-block; margin-left: 20px;">FAX.{{ $estimate->estimateAddress->estimate_address_fax }}</span>
                        @endif
                    </div>
                @endif
                
                <!-- Mail -->
                @if($estimate->estimateAddress->estimate_address_mail)
                    <div style="margin-left: 20px; font-size: 12px;">{{ $estimate->estimateAddress->estimate_address_mail }}</div>
                @endif

                <!-- URL -->
                @if($estimate->estimateAddress->estimate_address_url)
                    <div style="margin-left: 20px; font-size: 12px;">{{ $estimate->estimateAddress->estimate_address_url }}</div>
                @endif

                @if ($estimate->is_affiliation2_hidden == 0)
                    <div style="margin-left: 30px; font-size: 12px;">担当部署 : {{ $estimate->project->accountAffiliation2->affiliation2_name }}</div>                    
                @endif
                <div style="margin-left: 30px; font-size: 12px;">担当氏名 : {{ $estimate->project->accountUser->user_name }}</div>

                <div style="width: 100%; text-align: center; margin-top: 5px; overflow: hidden; margin-left: 50px;">
                    <div style="float: left; width: 60px; text-align: center; margin-right: 5px;">
                        <div style="width: 60px; height: 60px; border: 1px solid #000; display: flex; align-items: center; justify-content: center;">
                            {{-- 印 --}}
                        </div>
                    </div>
                    <div style="float: left; width: 60px; text-align: center; margin-right: 5px;">
                        <div style="width: 60px; height: 60px; border: 1px solid #000; display: flex; align-items: center; justify-content: center;">
                            {{-- 印 --}}
                        </div>
                    </div>
                    <div style="float: left; width: 60px; margin-right: 5px; position: relative;">
                        <div style="width: 60px; height: 60px; border: 1px solid #000;">
                            <img src="{{ public_path('storage/' . $estimate->project->accountUser->user_stamp_image) }}" alt="印鑑画像" style="width: 40px; height: 40px; position: absolute; top: 90%; left: 50%; transform: translate(-0%, 20%);">
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>

        <div class="" style="font-size: 12px; width: 100%; margin-top: 20px; border-bottom: 0.5px solid #000;">件  名 {{ $estimate->estimate_subject }}</div>
    {{-- headder --}}
{{-- body --}}
<table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
    <thead>
        <tr>
            <th style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif; width: 30px;">№</th>
            <th style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif; width: 350px;">品名</th>
            <th style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif;">標準単価</th>
            <th style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif; white-space: nowrap;">数量</th>
            <th style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif;">標準価格</th>
            <th style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif; width: 80px;">御提供価格</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($estimateDetailData as $estimateDetail)
        <tr>
            <td style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif; text-align: center;">{{ $estimateDetail->sort_order }}</td>
            <td style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp;">{{ $estimateDetail->product_name }}</td>
            <td style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif; text-align: right; padding-right: 5px;">&yen;{{ number_format($estimateDetail->unit_price) }}</td>
            <td style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif; text-align: center;">{{ $estimateDetail->quantity }}</td>
            <td style="font-size: 12px; border: 1px solid #000000; font-family: notosansjp, sans-serif; text-align: right; padding-right: 5px;">&yen;{{ number_format($estimateDetail->unit_price * $estimateDetail->quantity) }}</td>
            <td style="font-size: 12px; border: 1px solid #000000;  font-family: notosansjp, sans-serif; text-align: right; padding-right: 5px;">&yen;{{ number_format($estimateDetail->unit_price * $estimateDetail->quantity + $estimateDetail->discount) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- 集計欄 --}}
<table style="width: 25%; border-collapse: collapse; margin-top: 20px; margin-left: auto;">
    <tr>
        <td style="font-size: 11px; border: 1px solid #000000; padding: 5px; text-align: center; width: auto; white-space: nowrap; font-family: notosansjp, sans-serif; font-weight: bold;">税抜合計</td>
        <td style="font-size: 11px; border: 1px solid #000000; padding: 5px; text-align: right; width: auto; font-family: notosansjp, sans-serif; font-weight: bold;">&yen;{{ number_format($estimate->total_without_tax) }}</td>
    </tr>
    <tr>
        <td style="font-size: 11px; border: 1px solid #000000; padding: 5px; text-align: center; width: auto; white-space: nowrap; font-family: notosansjp, sans-serif; font-weight: bold;">消費税額</td>
        <td style="font-size: 11px; border: 1px solid #000000; padding: 5px; text-align: right; width: auto; font-family: notosansjp, sans-serif; font-weight: bold;">&yen;{{ number_format($estimate->total_tax) }}</td>
    </tr>
    <tr>
        <td style="font-size: 11px; border: 1px solid #000000; padding: 5px; text-align: center; width: auto; white-space: nowrap; font-family: notosansjp, sans-serif; font-weight: bold;">税込合計</td>
        <td style="font-size: 11px; border: 1px solid #000000; padding: 5px; text-align: right; width: auto; font-weight: bold; font-family: notosansjp, sans-serif;">&yen;{{ number_format($estimate->total_with_tax) }}</td>
    </tr>
</table>

{{-- 改ページ --}}
<pagebreak />

{{-- 備考欄 --}}
<div style="margin-top: 20px; font-size: 12px;">
    <div style="font-weight: bold; margin-bottom: 5px;">備考</div>
    <div style="border: 1px solid #000000; padding: 10px; min-height: 60px;">
        {!! nl2br(e($estimate->estimate_memo ?? '')) !!}
    </div>
</div>
</body>
</html>
