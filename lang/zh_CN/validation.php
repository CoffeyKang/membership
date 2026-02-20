<?php

return [
    'enter_amount_to_deposit' => '请输入存款金额。',
    'select_preset_value' => '请选择存款类型。',
    'confirm_deposit_amount' => '请确认存款金额。',
    'confirm_deposit_amount_mismatch' => '确认存款金额与输入金额不匹配。',
    'custom' => [
        'full_name' => [
            'required' => '请输入姓名',
            'string' => '请输入姓名, 只包含字母、数字和空格',
            'max' => '姓名最多255个字符',
        ],
        'phone_number' => [
            'required' => '请输入手机号',
            'string' => '请输入手机号, 只包含数字和空格',
            'max' => '手机号最多20个字符',
        ],
        'base_salary' => [
            'required' => '请输入基础工资',
            'numeric' => '请输入基础工资, 只包含数字',
            'min' => '基础工资不能小于0',
        ],
        
        'commission_rate' => [
            'required' => '请输入佣金率',
            'numeric' => '请输入佣金率, 只包含数字',
            'min' => '佣金率不能小于0',
            'max' => '佣金率不能大于1',
        ],
        'depositAmount' => [
            'required' => '请输入存款金额',
            'numeric' => '请输入存款金额, 只包含数字',
            'min' => '存款金额不能小于0',
        ],
        'type' => [
            'required' => '请选择存款类型',
        ],
        'confirmDepositAmount' => [
            'required' => '请确认存款金额',
            'numeric' => '请确认存款金额, 只包含数字',
            'min' => '确认存款金额不能小于0',
        ],
        'spendAmount' => [
            'required' => '请输入取款金额',
            'numeric' => '请输入取款金额, 只包含数字',
            'min' => '取款金额不能小于0',
        ],
        'confirmSpendAmount' => [
            'required' => '请确认取款金额',
            'numeric' => '请确认取款金额, 只包含数字',
            'min' => '确认取款金额不能小于0',
        ],
        'selectedStaff' => [
            'required' => '请选发型师',
        ],
        'notes' => [
            'string' => '请输入备注, 只包含字母、数字和空格',
            'max' => '备注最多255个字符',
        ],

        'selectedMemberID' => [
            'required' => '请选择会员',
        ],
        'selectedStaffId' => [
            'required' => '请选发型师',
        ],
        'amount' => [
            'required' => '请输入金额',
            'numeric' => '请输入金额, 只包含数字',
            'min' => '金额不能小于0',
        ],
        'confirmAmount' => [
            'required' => '请确认金额',
            'numeric' => '请确认金额, 只包含数字',
            'min' => '确认金额不能小于0',
            'same' => '确认金额与输入金额不匹配',
        ],
    ]
];
