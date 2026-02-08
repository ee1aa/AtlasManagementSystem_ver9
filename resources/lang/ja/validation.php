<?php

return [
  'required' => '※:attribute は必須です。',
  'email' => '※:attribute の形式が正しくありません。',
  'min' => [
    'string' => '※:attribute は :min 文字以上で入力してください。',
  ],
  'max' => [
    'string' => '※:attribute は :max 文字以内で入力してください。',
  ],
  'confirmed' => '※:attribute が確認用と一致しません。',
  'regex' => '※:attribute の形式が正しくありません。',
  'date' => '※:attribute は正しい日付を入力してください。',
  'after' => '※:attribute は :date より後の日付にしてください。',

  'attributes' => [
    'password' => 'パスワード',
    'password_confirmation' => '確認用パスワード',
    'mail_address' => 'メールアドレス',
    'over_name' => '姓',
    'under_name' => '名',
    'birth_day' => '生年月日',
    'over_name_kana' => 'セイ',
    'under_name_kana' => 'メイ'
  ],
];
