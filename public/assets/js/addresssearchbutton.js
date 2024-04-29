// $('#ajaxzip3').on('click', function(){
//     AjaxZip3.zip2addr('head_post_code','','head_prefecture','head_addre1','', '');

//     //成功時に実行する処理
//     AjaxZip3.onSuccess = function() {
//         $('.head_addre1').focus();
//     };
    
//     //失敗時に実行する処理
//     AjaxZip3.onFailure = function() {
//         alert('郵便番号に該当する住所が見つかりません');
//     };
    
//     return false;
// });

$('#ajaxzip3').on('click', function(){
    AjaxZip3.zip2addr('corporation_post_code','','corporation_prefecture_id','corporation_address1','', '');

    //成功時に実行する処理
    AjaxZip3.onSuccess = function() {
        $('#corporation_address1').focus();
    };
    
    //失敗時に実行する処理
    AjaxZip3.onFailure = function() {
        alert('郵便番号に該当する住所が見つかりません');
    };
    
    return false;
});

$('#client_ajaxzip3').on('click', function(){
    AjaxZip3.zip2addr('head_post_code','','head_prefecture_id','head_addre1','', '');

    //成功時に実行する処理
    AjaxZip3.onSuccess = function() {
        $('#head_addre1').focus();
    };
    
    //失敗時に実行する処理
    AjaxZip3.onFailure = function() {
        alert('郵便番号に該当する住所が見つかりません');
    };
    
    return false;
});

$('#project_ajaxzip3').on('click', function(){
    AjaxZip3.zip2addr('head_post_code','','prefecture_id','head_addre1','', '');

    //成功時に実行する処理
    AjaxZip3.onSuccess = function() {
        $('#address').focus();
    };
    
    //失敗時に実行する処理
    AjaxZip3.onFailure = function() {
        console.log('郵便番号に該当する住所が見つかりません')
    };
    
    return false;
});