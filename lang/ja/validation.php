<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    
    'accepted'             => ':attributeを承認してください。',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url'           => ':attributeが有効なURLではありません。',
    'after'                => ':attributeには、:dateより後の日付を指定してください。',
    'after_or_equal'       => ':attributeには、:date以降の日付を指定してください。',
    'alpha'                => ':attributeはアルファベットのみがご利用できます。',
    'alpha_dash'           => ':attributeはアルファベットとダッシュ(-)及び下線(_)がご利用できます。',
    'alpha_num'            => ':attributeはアルファベット数字がご利用できます。',
    'array'                => ':attributeは配列でなくてはなりません。',
    'before'               => ':attributeには、:dateより前の日付をご利用ください。',
    'before_or_equal'      => ':attributeには、:date以前の日付をご利用ください。',
    'between'              => [
        'numeric' => ':attributeは、:minから:maxの間で指定してください。',
        'file'    => ':attributeは、:min kBから、:max kBの間で指定してください。',
        'string'  => ':attributeは、:min文字から、:max文字の間で指定してください。',
        'array'   => ':attributeは、:min個から:max個の間で指定してください。',
    ],
    'boolean'              => ':attributeは、trueかfalseを指定してください。',
    'confirmed'            => ':attributeと、確認フィールドとが、一致していません。',
    'current_password'     => 'パスワードが正しくありません。',
    'date'                 => ':attributeには有効な日付を指定してください。',
    'date_equals'          => ':attributeには、:dateと同じ日付けを指定してください。',
    'date_format'          => ':attributeは:format形式で指定してください。',
    'different'            => ':attributeと:otherには、異なった内容を指定してください。',
    'digits'               => ':attributeは:digits桁で指定してください。',
    'digits_between'       => ':attributeは:min桁から:max桁の間で指定してください。',
    'dimensions'           => ':attributeの図形サイズが正しくありません。',
    'distinct'             => ':attributeには異なった値を指定してください。',
    'email'                => ':attributeには、有効なメールアドレスを指定してください。',
    'ends_with'            => ':attributeには、:valuesのどれかで終わる値を指定してください。',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => ':attributeにはファイルを指定してください。',
    'filled'               => ':attributeに値を指定してください。',
    'gt'                   => [
        'numeric' => ':attributeには、:valueより大きな値を指定してください。',
        'file'    => ':attributeには、:value kBより大きなファイルを指定してください。',
        'string'  => ':attributeは、:value文字より長く指定してください。',
        'array'   => ':attributeには、:value個より多くのアイテムを指定してください。',
    ],
    'gte'                  => [
        'numeric' => ':attributeには、:value以上の値を指定してください。',
        'file'    => ':attributeには、:value kB以上のファイルを指定してください。',
        'string'  => ':attributeは、:value文字以上で指定してください。',
        'array'   => ':attributeには、:value個以上のアイテムを指定してください。',
    ],
    'image'                => ':attributeには画像ファイルを指定してください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'in_array'             => ':attributeには:otherの値を指定してください。',
    'integer'              => ':attributeは整数で指定してください。',
    'ip'                   => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4'                 => ':attributeには、有効なIPv4アドレスを指定してください。',
    'ipv6'                 => ':attributeには、有効なIPv6アドレスを指定してください。',
    'json'                 => ':attributeには、有効なJSON文字列を指定してください。',
    'lt'                   => [
        'numeric' => ':attributeには、:valueより小さな値を指定してください。',
        'file'    => ':attributeには、:value kBより小さなファイルを指定してください。',
        'string'  => ':attributeは、:value文字より短く指定してください。',
        'array'   => ':attributeには、:value個より少ないアイテムを指定してください。',
    ],
    'lte'                  => [
        'numeric' => ':attributeには、:value以下の値を指定してください。',
        'file'    => ':attributeには、:value kB以下のファイルを指定してください。',
        'string'  => ':attributeは、:value文字以下で指定してください。',
        'array'   => ':attributeには、:value個以下のアイテムを指定してください。',
    ],
    'max'                  => [
        'numeric' => ':attributeには、:max以下の数字を指定してください。',
        'file'    => ':attributeには、:max kB以下のファイルを指定してください。',
        'string'  => ':attributeは、:max文字以下で指定してください。',
        'array'   => ':attributeは:max個以下指定してください。',
    ],
    'mimes'                => ':attributeには:valuesタイプのファイルを指定してください。',
    'mimetypes'            => ':attributeには:valuesタイプのファイルを指定してください。',
    'min'                  => [
        'numeric' => ':attributeには、:min以上の数字を指定してください。',
        'file'    => ':attributeには、:min kB以上のファイルを指定してください。',
        'string'  => ':attributeは、:min文字以上で指定してください。',
        'array'   => ':attributeは:min個以上指定してください。',
    ],
    'multiple_of' => ':attributeには、:valueの倍数を指定してください。',
    'not_in'               => '選択された:attributeは正しくありません。',
    'not_regex'            => ':attributeの形式が正しくありません。',
    'numeric'              => ':attributeには、数字を指定してください。',
    'password'             => '正しいパスワードを指定してください。',
    'present'              => ':attributeが存在していません。',
    'regex'                => ':attributeに正しい形式を指定してください。',
    'required'             => ':attributeは必ず入力してください。',
    'required_if'          => ':otherが:valueの場合、:attributeも指定してください。',
    'required_unless'      => ':otherが:valuesでない場合、:attributeを指定してください。',
    'required_with'        => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_with_all'    => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_without'     => ':valuesを指定しない場合は、:attributeを指定してください。',
    'required_without_all' => ':valuesのどれも指定しない場合は、:attributeを指定してください。',
    'prohibited'           => ':attributeは入力禁止です。',
    'prohibited_if' => ':otherが:valueの場合、:attributeは入力禁止です。',
    'prohibited_unless'    => ':otherが:valueでない場合、:attributeは入力禁止です。',
    'prohibits'            => 'attributeは:otherの入力を禁じています。',
    'same'                 => ':attributeと:otherには同じ値を指定してください。',
    'size'                 => [
        'numeric' => ':attributeは:sizeを指定してください。',
        'file'    => ':attributeのファイルは、:sizeキロバイトでなくてはなりません。',
        'string'  => ':attributeは:size文字で指定してください。',
        'array'   => ':attributeは:size個指定してください。',
    ],
    'starts_with'          => ':attributeには、:valuesのどれかで始まる値を指定してください。',
    'string'               => ':attributeは文字列を指定してください。',
    'timezone'             => ':attributeには、有効なゾーンを指定してください。',
    'unique'               => ':attributeの値は既に存在しています。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeに正しい形式を指定してください。',
    'uuid'                 => ':attributeに有効なUUIDを指定してください。',


    // 'accepted' => 'The :attribute field must be accepted.',
    // 'accepted_if' => 'The :attribute field must be accepted when :other is :value.',
    // 'active_url' => 'The :attribute field must be a valid URL.',
    // 'after' => 'The :attribute field must be a date after :date.',
    // 'after_or_equal' => 'The :attribute field must be a date after or equal to :date.',
    // 'alpha' => 'The :attribute field must only contain letters.',
    // 'alpha_dash' => 'The :attribute field must only contain letters, numbers, dashes, and underscores.',
    // 'alpha_num' => 'The :attribute field must only contain letters and numbers.',
    // 'array' => 'The :attribute field must be an array.',
    // 'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
    // 'before' => 'The :attribute field must be a date before :date.',
    // 'before_or_equal' => 'The :attribute field must be a date before or equal to :date.',
    // 'between' => [
    //     'array' => 'The :attribute field must have between :min and :max items.',
    //     'file' => 'The :attribute field must be between :min and :max kilobytes.',
    //     'numeric' => 'The :attribute field must be between :min and :max.',
    //     'string' => 'The :attribute field must be between :min and :max characters.',
    // ],
    // 'boolean' => 'The :attribute field must be true or false.',
    // 'confirmed' => 'The :attribute field confirmation does not match.',
    // 'current_password' => 'The password is incorrect.',
    // 'date' => 'The :attribute field must be a valid date.',
    // 'date_equals' => 'The :attribute field must be a date equal to :date.',
    // 'date_format' => 'The :attribute field must match the format :format.',
    // 'decimal' => 'The :attribute field must have :decimal decimal places.',
    // 'declined' => 'The :attribute field must be declined.',
    // 'declined_if' => 'The :attribute field must be declined when :other is :value.',
    // 'different' => 'The :attribute field and :other must be different.',
    // 'digits' => 'The :attribute field must be :digits digits.',
    // 'digits_between' => 'The :attribute field must be between :min and :max digits.',
    // 'dimensions' => 'The :attribute field has invalid image dimensions.',
    // 'distinct' => 'The :attribute field has a duplicate value.',
    // 'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
    // 'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
    // 'email' => 'The :attribute field must be a valid email address.',
    // 'ends_with' => 'The :attribute field must end with one of the following: :values.',
    // 'enum' => 'The selected :attribute is invalid.',
    // 'exists' => 'The selected :attribute is invalid.',
    // 'file' => 'The :attribute field must be a file.',
    // 'filled' => 'The :attribute field must have a value.',
    // 'gt' => [
    //     'array' => 'The :attribute field must have more than :value items.',
    //     'file' => 'The :attribute field must be greater than :value kilobytes.',
    //     'numeric' => 'The :attribute field must be greater than :value.',
    //     'string' => 'The :attribute field must be greater than :value characters.',
    // ],
    // 'gte' => [
    //     'array' => 'The :attribute field must have :value items or more.',
    //     'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
    //     'numeric' => 'The :attribute field must be greater than or equal to :value.',
    //     'string' => 'The :attribute field must be greater than or equal to :value characters.',
    // ],
    // 'image' => 'The :attribute field must be an image.',
    // 'in' => 'The selected :attribute is invalid.',
    // 'in_array' => 'The :attribute field must exist in :other.',
    // 'integer' => 'The :attribute field must be an integer.',
    // 'ip' => 'The :attribute field must be a valid IP address.',
    // 'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    // 'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    // 'json' => 'The :attribute field must be a valid JSON string.',
    // 'lowercase' => 'The :attribute field must be lowercase.',
    // 'lt' => [
    //     'array' => 'The :attribute field must have less than :value items.',
    //     'file' => 'The :attribute field must be less than :value kilobytes.',
    //     'numeric' => 'The :attribute field must be less than :value.',
    //     'string' => 'The :attribute field must be less than :value characters.',
    // ],
    // 'lte' => [
    //     'array' => 'The :attribute field must not have more than :value items.',
    //     'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
    //     'numeric' => 'The :attribute field must be less than or equal to :value.',
    //     'string' => 'The :attribute field must be less than or equal to :value characters.',
    // ],
    // 'mac_address' => 'The :attribute field must be a valid MAC address.',
    // 'max' => [
    //     'array' => 'The :attribute field must not have more than :max items.',
    //     'file' => 'The :attribute field must not be greater than :max kilobytes.',
    //     'numeric' => 'The :attribute field must not be greater than :max.',
    //     'string' => 'The :attribute field must not be greater than :max characters.',
    // ],
    // 'max_digits' => 'The :attribute field must not have more than :max digits.',
    // 'mimes' => 'The :attribute field must be a file of type: :values.',
    // 'mimetypes' => 'The :attribute field must be a file of type: :values.',
    // 'min' => [
    //     'array' => 'The :attribute field must have at least :min items.',
    //     'file' => 'The :attribute field must be at least :min kilobytes.',
    //     'numeric' => 'The :attribute field must be at least :min.',
    //     'string' => 'The :attribute field must be at least :min characters.',
    // ],
    // 'min_digits' => 'The :attribute field must have at least :min digits.',
    // 'missing' => 'The :attribute field must be missing.',
    // 'missing_if' => 'The :attribute field must be missing when :other is :value.',
    // 'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    // 'missing_with' => 'The :attribute field must be missing when :values is present.',
    // 'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    // 'multiple_of' => 'The :attribute field must be a multiple of :value.',
    // 'not_in' => 'The selected :attribute is invalid.',
    // 'not_regex' => 'The :attribute field format is invalid.',
    // 'numeric' => 'The :attribute field must be a number.',
    // 'password' => [
    //     'letters' => 'The :attribute field must contain at least one letter.',
    //     'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
    //     'numbers' => 'The :attribute field must contain at least one number.',
    //     'symbols' => 'The :attribute field must contain at least one symbol.',
    //     'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    // ],
    // 'present' => 'The :attribute field must be present.',
    // 'prohibited' => 'The :attribute field is prohibited.',
    // 'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    // 'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    // 'prohibits' => 'The :attribute field prohibits :other from being present.',
    // 'regex' => 'The :attribute field format is invalid.',
    // 'required' => 'The :attribute field is required.',
    // 'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    // 'required_if' => 'The :attribute field is required when :other is :value.',
    // 'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    // 'required_unless' => 'The :attribute field is required unless :other is in :values.',
    // 'required_with' => 'The :attribute field is required when :values is present.',
    // 'required_with_all' => 'The :attribute field is required when :values are present.',
    // 'required_without' => 'The :attribute field is required when :values is not present.',
    // 'required_without_all' => 'The :attribute field is required when none of :values are present.',
    // 'same' => 'The :attribute field must match :other.',
    // 'size' => [
    //     'array' => 'The :attribute field must contain :size items.',
    //     'file' => 'The :attribute field must be :size kilobytes.',
    //     'numeric' => 'The :attribute field must be :size.',
    //     'string' => 'The :attribute field must be :size characters.',
    // ],
    // 'starts_with' => 'The :attribute field must start with one of the following: :values.',
    // 'string' => 'The :attribute field must be a string.',
    // 'timezone' => 'The :attribute field must be a valid timezone.',
    // 'unique' => 'The :attribute has already been taken.',
    // 'uploaded' => 'The :attribute failed to upload.',
    // 'uppercase' => 'The :attribute field must be uppercase.',
    // 'url' => 'The :attribute field must be a valid URL.',
    // 'ulid' => 'The :attribute field must be a valid ULID.',
    // 'uuid' => 'The :attribute field must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    // 'custom' => [
    //     'attribute-name' => [
    //         'rule-name' => 'custom-message',

    'custom' => [
        '属性名' => [
            'ルール名' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'project_num' => 'プロジェクト№',
        'clientname' => '顧客名',
        'purpose' => '用途',
        'keep_at' => '預託日',
        'return_at' => '返却日',
        'memo' => '備考',
        "clientcorporation_num" => "法人番号",
        "clientcorporation_name" => "法人名称",
        "clientcorporation_kana_name" => "法人カナ名称"
    ],

];
