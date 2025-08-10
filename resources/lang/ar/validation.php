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

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما :other يكون :value.',
    'active_url' => ':attribute ليس عنوان URL صالحًا.',
    'after' => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'after_today' => 'يجب أن يكون :attribute تاريخًا بعد اليوم.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخًا بعد أو يساوي :date.',
    'alpha' => 'يجب أن يحتوي :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي :attribute على أحرف وأرقام وشرطات فقط.',
    'alpha_num' => 'يجب أن يحتوي :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون :attribute مصفوفة.',
    'before' => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخًا قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن يحتوي :attribute على :min إلى :max عنصر.',
        'file' => 'يجب أن يكون حجم :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'string' => 'يجب أن يكون طول :attribute بين :min و :max حرف.',
    ],
    'boolean' => 'يجب أن تكون قيمة :attribute صحيحة أو خاطئة.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => ':attribute ليس تاريخًا صالحًا.',
    'date_equals' => 'يجب أن يكون :attribute تاريخًا يساوي :date.',
    'date_format' => 'لا يتطابق :attribute مع الصيغة :format.',
    'declined' => 'يجب رفض :attribute.',
    'declined_if' => 'يجب رفض :attribute عندما :other يكون :value.',
    'different' => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits' => 'يجب أن يحتوي :attribute على :digits أرقام.',
    'digits_between' => 'يجب أن يحتوي :attribute على :min إلى :max أرقام.',
    'dimensions' => ':attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_end_with' => 'يجب ألا ينتهي :attribute بأحد القيم التالية: :values.',
    'doesnt_start_with' => 'يجب ألا يبدأ :attribute بأحد القيم التالية: :values.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالحًا.',
    'ends_with' => 'يجب أن ينتهي :attribute بأحد القيم التالية: :values.',
    'enum' => ':attribute المحدد غير صالح.',
    'exists' => ':attribute المحدد غير موجود.',
    'file' => 'يجب أن يكون :attribute ملفًا.',
    'filled' => 'يجب ملء حقل :attribute.',
    'gt' => [
        'array' => 'يجب أن يحتوي :attribute على أكثر من :value عنصر.',
        'file' => 'يجب أن يكون حجم :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'string' => 'يجب أن يكون طول :attribute أكبر من :value حرف.',
    ],
    'gte' => [
        'array' => 'يجب أن يحتوي :attribute على :value عنصر على الأقل.',
        'file' => 'يجب أن يكون حجم :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من أو تساوي :value.',
        'string' => 'يجب أن يكون طول :attribute أكبر من أو يساوي :value حرف.',
    ],
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => ':attribute المحدد غير صالح.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صالحًا.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صالحًا.',
    'json' => 'يجب أن يكون :attribute نصًا JSON صالحًا.',
    'lt' => [
        'array' => 'يجب أن يحتوي :attribute على أقل من :value عنصر.',
        'file' => 'يجب أن يكون حجم :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من :value.',
        'string' => 'يجب أن يكون طول :attribute أقل من :value حرف.',
    ],
    'lte' => [
        'array' => 'يجب أن يحتوي :attribute على :value عنصر على الأكثر.',
        'file' => 'يجب أن يكون حجم :attribute أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من أو تساوي :value.',
        'string' => 'يجب أن يكون طول :attribute أقل من أو يساوي :value حرف.',
    ],
    'mac_address' => 'يجب أن يكون :attribute عنوان MAC صالحًا.',
    'max' => [
        'array' => 'يجب أن يحتوي :attribute على :max عنصر على الأكثر.',
        'file' => 'يجب أن يكون حجم :attribute أقل من :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من :max.',
        'string' => 'يجب أن يكون طول :attribute أقل من :max حرف.',
    ],
    'max_digits' => 'يجب ألا يحتوي :attribute على أكثر من :max أرقام.',
    'mimes' => 'يجب أن يكون :attribute ملفًا من نوع: :values.',
    'mimetypes' => 'يجب أن يكون :attribute ملفًا من نوع: :values.',
    'min' => [
        'array' => 'يجب أن يحتوي :attribute على :min عنصر على الأقل.',
        'file' => 'يجب أن يكون حجم :attribute أكبر من :min كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :min.',
        'string' => 'يجب أن يكون طول :attribute أكبر من :min حرف.',
    ],
    'min_digits' => 'يجب أن يحتوي :attribute على :min أرقام على الأقل.',
    'multiple_of' => 'يجب أن تكون قيمة :attribute مضاعفًا لـ :value.',
    'not_in' => ':attribute المحدد غير صالح.',
    'not_regex' => 'صيغة :attribute غير صالحة.',
    'numeric' => 'يجب أن يكون :attribute رقمًا.',
    'password' => [
        'letters' => 'يجب أن يحتوي :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن يحتوي :attribute على حرف كبير وحرف صغير على الأقل.',
        'numbers' => 'يجب أن يحتوي :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن يحتوي :attribute على رمز واحد على الأقل.',
        'uncompromised' => ':attribute المقدم ظهر في تسريب بيانات. يرجى اختيار :attribute مختلف.',
    ],
    'present' => 'يجب وجود حقل :attribute.',
    'prohibited' => 'حقل :attribute محظور.',
    'prohibited_if' => 'حقل :attribute محظور عندما :other يكون :value.',
    'prohibited_unless' => 'حقل :attribute محظور ما لم يكن :other في :values.',
    'prohibits' => 'حقل :attribute يحظر وجود :other.',
    'regex' => 'صيغة :attribute غير صالحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'حقل :attribute يجب أن يحتوي على إدخالات لـ: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما :other يكون :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما يتم قبول :other.',
    'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other في :values.',
    'required_with' => 'حقل :attribute مطلوب عندما :values موجود.',
    'required_with_all' => 'حقل :attribute مطلوب عندما :values موجودة.',
    'required_without' => 'حقل :attribute مطلوب عندما :values غير موجود.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'size' => [
        'array' => 'يجب أن يحتوي :attribute على :size عنصر.',
        'file' => 'يجب أن يكون حجم :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute :size.',
        'string' => 'يجب أن يكون طول :attribute :size حرف.',
    ],
    'starts_with' => 'يجب أن يبدأ :attribute بأحد القيم التالية: :values.',
    'string' => 'يجب أن يكون :attribute نصًا.',
    'timezone' => 'يجب أن يكون :attribute منطقة زمنية صالحة.',
    'unique' => 'قيمة :attribute مستخدمة من قبل.',
    'uploaded' => 'فشل في تحميل :attribute.',
    'url' => 'صيغة :attribute غير صالحة.',
    'uuid' => 'يجب أن يكون :attribute UUID صالحًا.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'name' => 'الاسم',
        'full_name' => 'الاسم الكامل',
        'company_name' => 'اسم الشركة',
        'crn' => 'رقم السجل التجاري',
        'country_id' => 'البلد',
        'city_id' => 'المدينة',
        'phone' => 'رقم الهاتف',
        'address' => 'العنوان',
        'image' => 'الصورة',
        'role_id' => 'الدور',
        'forget_password_search' => 'البريد الإلكتروني أو رقم السجل التجاري',
        'login_text' => 'البريد الإلكتروني أو رقم السجل التجاري',
        'login_password' => 'كلمة المرور',
        'otp' => 'رمز التحقق',
        'otp_user' => 'المستخدم',
        'resend_otp_user' => 'المستخدم',
        'push_notify' => 'الإشعارات المباشرة',
        'email_notify' => 'إشعارات البريد الإلكتروني',
        'sample_request' => 'طلب العينة',
    ],
];
