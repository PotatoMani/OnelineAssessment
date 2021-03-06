<?php
/**
 * 此处记录路径所需要的权限
 */
return [
    'work' => [1],

    // 数据查询
    'work/data_view' => [1,2],
    'work/data_view/check' => [1,2],

    // 数据录入
    'work/data_entry' => [1,3],
    'work/data_entry/input' => [1,3],
    'work/data_entry/input/check' => [1,3],

    // 数据审核
    'work/data_audit' => [1,4],
    'work/data_audit/check' => [1,4],

    // 数据管理
    'work/data_regulate' => [1,5],
    'work/data_regulate/check' => [1,5],
    'work/data_regulate/regulate/check' => [1,5],

    // 项目设置
    'work/project_setting' => [1,6],
    'work/project_setting/edit' => [1,6],
    'work/project_setting/edit/check' => [1,6],

    // 用户管理
    'admin/user_regulate' => [1,2,3,4,5,6,7],

    // 系统管理
    'admin/system_control' => [1,2,3,4,5,6,7,8],
];
