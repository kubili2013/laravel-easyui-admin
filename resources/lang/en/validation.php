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

    'accepted'             => ' :attribute 必须被接受。',
    'active_url'           => ' :attribute 不是有效网址。',
    'after'                => ' :attribute 必须在 :date 之后。',
    'alpha'                => ' :attribute 必须全部是字母。',
    'alpha_dash'           => ' :attribute 只能包含字母，数字，和破折号。',
    'alpha_num'            => ' :attribute 只能包含字母和数字。',
    'array'                => ' :attribute 必须是一个数组。',
    'before'               => ' :attribute 必须在 :date 之后。',
    'between'              => [
        'numeric' => ' :attribute 必须在 :min 与 :max 之间。',
        'file'    => ' :attribute 大小必须控制在 :min 与 :max (K) 之间.',
        'string'  => ' :attribute 长度 :min 与 :max 之间。',
        'array'   => ' :attribute 条目必须在 :min 与 :max 之间。',
    ],
    'boolean'              => ' :attribute 属性必须为 true 或者 false。',
    'confirmed'            => ' :attribute 属性确认不匹配。',
    'date'                 => ' :attribute 不是日期格式。',
    'date_format'          => ' :attribute 不匹配格式 :format.',
    'different'            => ' :attribute 属性与 :other 属性不能一样。',
    'digits'               => ' :attribute 必须是 :digits 。',
    'digits_between'       => ' :attribute 必须是 :min 到 :max 的数字。',
    'dimensions'           => ' :attribute 图像尺寸不符合要求。',
    'distinct'             => ' :attribute 字段不能包含重复的值。',
    'email'                => ' :attribute 必须是Email地址。',
    'exists'               => ' 选择的 :attribute 是无效的。',
    'file'                 => ' :attribute 必须是一个文件。',
    'filled'               => ' :attribute 是必填项.',
    'image'                => ' :attribute 必须是一张图片。',
    'in'                   => ' :attribute 属性的选择是无效的。',
    'in_array'             => ' :attribute 字段不在 :other 之中。',
    'integer'              => ' :attribute 必须是一个整数。',
    'ip'                   => ' :attribute 不是 IP 地址。',
    'json'                 => ' :attribute 必须是JSON格式字符串。',
    'max'                  => [
        'numeric' => ' :attribute 最大不能超过 :max.',
        'file'    => ' :attribute 大小最大不能超过 :max K。',
        'string'  => ' :attribute 长度不能超过 :max 。',
        'array'   => ' :attribute 长度不能超过 :max 条。',
    ],
    'mimes'                => ' :attribute 支持的文件类型: :values。',
    'mimetypes'            => ' :attribute支持的文件类型: :values。',
    'min'                  => [
        'numeric' => ' :attribute 最小不能小于 :min.',
        'file'    => ' :attribute 最小不能小于 :min K 。',
        'string'  => ' :attribute 长度最小不能小于 :min 。',
        'array'   => ' :attribute 最小不能小于 :min 条。',
    ],
    'not_in'               => '您所选 :attribute 是无效的。',
    'numeric'              => ' :attribute 必须是数字。',
    'present'              => ' :attribute 字段必须存在。',
    'regex'                => ' :attribute 格式不正确。',
    'required'             => ' :attribute 是必填项',
    'required_if'          => '当 :other 是 :value 的时候,:attribute 是必须的。',
    'required_unless'      => '除了 :other 等于 :values 之外, :attribute 是必填的。',
    'required_with'        => '当 :values 任意一个存在时, :attribute 必须填写。',
    'required_with_all'    => '当 :values 全部存在时, :attribute 必须填写。',
    'required_without'     => '当 :values 其中一个不存在时, :attribute 必须填写。',
    'required_without_all' => '当 :values 全部都不存在时, :attribute 必须填写。',
    'same'                 => ' :attribute 与 :other 必须匹配。',
    'size'                 => [
        'numeric' => ' :attribute 必须是 :size。',
        'file'    => ' :attribute 必须是 :size K。',
        'string'  => ' :attribute 必须是 :size 。',
        'array'   => ' :attribute 必须包含 :size 项目。',
    ],
    'string'               => ' :attribute 必须是一个字符串。',
    'timezone'             => ' :attribute 必须是一个有效的时区。',
    'unique'               => ' :attribute 已经存在。',
    'uploaded'             => ' :attribute 无法上传。',
    'url'                  => ' :attribute 格式不正确。',

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

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
