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

    'accepted' => ':attribute ကို လက်ခံရပါမည်။',
    'accepted_if' => ':other သည် :value ဖြစ်သောအခါ :attribute ကို လက်ခံရပါမည်။',
    'active_url' => ':attribute သည် မှန်ကန်သော URL မဟုတ်ပါ။',
    'after' => ':attribute သည် :date ပြီးနောက် ရက်စွဲဖြစ်ရပါမည်။',
    'after_or_equal' => ':attribute သည် :date နှင့်ညီသော သို့မဟုတ် နောက်ပိုင်း ရက်စွဲဖြစ်ရပါမည်။',
    'alpha' => ':attribute သည် စာလုံးများသာ ပါဝင်ရပါမည်။',
    'alpha_dash' => ':attribute သည် စာလုံးများ၊ ဂဏန်းများ၊ ဒက်ရှ်များနှင့် အောက်မျဉ်းများသာ ပါဝင်ရပါမည်။',
    'alpha_num' => ':attribute သည် စာလုံးများနှင့် ဂဏန်းများသာ ပါဝင်ရပါမည်။',
    'any_of' => ':attribute သည် မမှန်ကန်ပါ။',
    'array' => ':attribute သည် array ဖြစ်ရပါမည်။',
    'ascii' => ':attribute သည် single-byte alphanumeric စာလုံးများနှင့် သင်္ကေတများသာ ပါဝင်ရပါမည်။',
    'before' => ':attribute သည် :date ပြီးမှ ရက်စွဲဖြစ်ရပါမည်။',
    'before_or_equal' => ':attribute သည် :date နှင့်ညီသော သို့မဟုတ် အရင်ပိုင်း ရက်စွဲဖြစ်ရပါမည်။',
    'between' => [
        'array' => ':attribute သည် :min နှင့် :max ကြားတွင် items များ ရှိရပါမည်။',
        'file' => ':attribute သည် :min နှင့် :max kilobytes ကြားတွင် ရှိရပါမည်။',
        'numeric' => ':attribute သည် :min နှင့် :max ကြားတွင် ရှိရပါမည်။',
        'string' => ':attribute သည် :min နှင့် :max စာလုံးကြားတွင် ရှိရပါမည်။',
    ],
    'boolean' => ':attribute သည် true သို့မဟုတ် false ဖြစ်ရပါမည်။',
    'can' => ':attribute တွင် ခွင့်ပြုမထားသော တန်ဖိုးပါရှိသည်။',
    'confirmed' => ':attribute အတည်ပြုချက် မကိုက်ညီပါ။',
    'contains' => ':attribute တွင် လိုအပ်သောတန်ဖိုး မပါရှိပါ။',
    'current_password' => 'လျှို့ဝှက်နံပါတ် မမှန်ကန်ပါ။',
    'date' => ':attribute သည် မှန်ကန်သော ရက်စွဲမဟုတ်ပါ။',
    'date_equals' => ':attribute သည် :date နှင့်ညီသော ရက်စွဲဖြစ်ရပါမည်။',
    'date_format' => ':attribute သည် :format ဖော်မတ်နှင့် မကိုက်ညီပါ။',
    'decimal' => ':attribute တွင် :decimal ဒဿမအရေအတွက် ရှိရပါမည်။',
    'declined' => ':attribute ကို ငြင်းပယ်ရပါမည်။',
    'declined_if' => ':other သည် :value ဖြစ်သောအခါ :attribute ကို ငြင်းပယ်ရပါမည်။',
    'different' => ':attribute နှင့် :other သည် ကွဲပြားရပါမည်။',
    'digits' => ':attribute သည် :digits ဂဏန်း ဖြစ်ရပါမည်။',
    'digits_between' => ':attribute သည် :min နှင့် :max ဂဏန်းကြားတွင် ရှိရပါမည်။',
    'dimensions' => ':attribute တွင် မမှန်ကန်သော ပုံ dimensions များရှိသည်။',
    'distinct' => ':attribute တွင် ထပ်နေသောတန်ဖိုးရှိသည်။',
    'doesnt_contain' => ':attribute တွင် အောက်ပါတန်ဖိုးများ မပါရှိရပါ - :values',
    'doesnt_end_with' => ':attribute သည် အောက်ပါတို့ဖြင့် မပြီးဆုံးရပါ - :values',
    'doesnt_start_with' => ':attribute သည် အောက်ပါတို့ဖြင့် မစရပါ - :values',
    'email' => ':attribute သည် မှန်ကန်သော အီးမေးလ်လိပ်စာဖြစ်ရပါမည်။',
    'ends_with' => ':attribute သည် အောက်ပါတို့ဖြင့် ပြီးဆုံးရပါမည် - :values',
    'enum' => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'exists' => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'extensions' => ':attribute တွင် အောက်ပါ extensions များရှိရပါမည် - :values',
    'file' => ':attribute သည် ဖိုင်ဖြစ်ရပါမည်။',
    'filled' => ':attribute တွင် တန်ဖိုးရှိရပါမည်။',
    'gt' => [
        'array' => ':attribute တွင် :value ထက်ပို၍ items များရှိရပါမည်။',
        'file' => ':attribute သည် :value kilobytes ထက်ကြီးရပါမည်။',
        'numeric' => ':attribute သည် :value ထက်ကြီးရပါမည်။',
        'string' => ':attribute သည် :value စာလုံးထက်ကြီးရပါမည်။',
    ],
    'gte' => [
        'array' => ':attribute တွင် :value items သို့မဟုတ် ပိုရှိရပါမည်။',
        'file' => ':attribute သည် :value kilobytes နှင့်ညီသော သို့မဟုတ် ကြီးရပါမည်။',
        'numeric' => ':attribute သည် :value နှင့်ညီသော သို့မဟုတ် ကြီးရပါမည်။',
        'string' => ':attribute သည် :value စာလုံးနှင့်ညီသော သို့မဟုတ် ပိုရှိရပါမည်။',
    ],
    'hex_color' => ':attribute သည် မှန်ကန်သော hexadecimal အရောင်ဖြစ်ရပါမည်။',
    'image' => ':attribute သည် ပုံဖြစ်ရပါမည်။',
    'in' => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'in_array' => ':attribute သည် :other တွင် ရှိရပါမည်။',
    'in_array_keys' => ':attribute တွင် အောက်ပါ keys များပါရှိရပါမည် - :values',
    'integer' => ':attribute သည် ကိန်းပြည့်ဖြစ်ရပါမည်။',
    'ip' => ':attribute သည် မှန်ကန်သော IP လိပ်စာဖြစ်ရပါမည်။',
    'ipv4' => ':attribute သည် မှန်ကန်သော IPv4 လိပ်စာဖြစ်ရပါမည်။',
    'ipv6' => ':attribute သည် မှန်ကန်သော IPv6 လိပ်စာဖြစ်ရပါမည်။',
    'json' => ':attribute သည် မှန်ကန်သော JSON string ဖြစ်ရပါမည်။',
    'list' => ':attribute သည် စာရင်းဖြစ်ရပါမည်။',
    'lowercase' => ':attribute သည် စာလုံးသေးဖြစ်ရပါမည်။',
    'lt' => [
        'array' => ':attribute တွင် :value ထက်နည်းသော items များရှိရပါမည်။',
        'file' => ':attribute သည် :value kilobytes ထက်နည်းရပါမည်။',
        'numeric' => ':attribute သည် :value ထက်နည်းရပါမည်။',
        'string' => ':attribute သည် :value စာလုံးထက်နည်းရပါမည်။',
    ],
    'lte' => [
        'array' => ':attribute တွင် :value ထက်ပို၍ items များ မရှိရပါ။',
        'file' => ':attribute သည် :value kilobytes နှင့်ညီသော သို့မဟုတ် နည်းရပါမည်။',
        'numeric' => ':attribute သည် :value နှင့်ညီသော သို့မဟုတ် နည်းရပါမည်။',
        'string' => ':attribute သည် :value စာလုံးနှင့်ညီသော သို့မဟုတ် နည်းရပါမည်။',
    ],
    'mac_address' => ':attribute သည် မှန်ကန်သော MAC လိပ်စာဖြစ်ရပါမည်။',
    'max' => [
        'array' => ':attribute တွင် :max ထက်ပို၍ items များ မရှိရပါ။',
        'file' => ':attribute သည် :max kilobytes ထက်မကြီးရပါ။',
        'numeric' => ':attribute သည် :max ထက်မကြီးရပါ။',
        'string' => ':attribute သည် :max စာလုံးထက်မကြီးရပါ။',
    ],
    'max_digits' => ':attribute တွင် :max ထက်ပို၍ ဂဏန်းများ မရှိရပါ။',
    'mimes' => ':attribute သည် :values အမျိုးအစား ဖိုင်ဖြစ်ရပါမည်။',
    'mimetypes' => ':attribute သည် :values အမျိုးအစား ဖိုင်ဖြစ်ရပါမည်။',
    'min' => [
        'array' => ':attribute တွင် အနည်းဆုံး :min items များရှိရပါမည်။',
        'file' => ':attribute သည် အနည်းဆုံး :min kilobytes ရှိရပါမည်။',
        'numeric' => ':attribute သည် အနည်းဆုံး :min ရှိရပါမည်။',
        'string' => ':attribute သည် အနည်းဆုံး :min စာလုံးရှိရပါမည်။',
    ],
    'min_digits' => ':attribute တွင် အနည်းဆုံး :min ဂဏန်းများရှိရပါမည်။',
    'missing' => ':attribute သည် ပျောက်နေရပါမည်။',
    'missing_if' => ':other သည် :value ဖြစ်သောအခါ :attribute ပျောက်နေရပါမည်။',
    'missing_unless' => ':other သည် :value မဟုတ်လျှင် :attribute ပျောက်နေရပါမည်။',
    'missing_with' => ':values ရှိသောအခါ :attribute ပျောက်နေရပါမည်။',
    'missing_with_all' => ':values များရှိသောအခါ :attribute ပျောက်နေရပါမည်။',
    'multiple_of' => ':attribute သည် :value ၏ မြှောက်ဖြစ်ရပါမည်။',
    'not_in' => 'ရွေးချယ်ထားသော :attribute သည် မမှန်ကန်ပါ။',
    'not_regex' => ':attribute ဖော်မတ်သည် မမှန်ကန်ပါ။',
    'numeric' => ':attribute သည် ဂဏန်းဖြစ်ရပါမည်။',
    'password' => [
        'letters' => ':attribute တွင် အနည်းဆုံး စာလုံးတစ်လုံးပါရှိရပါမည်။',
        'mixed' => ':attribute တွင် အနည်းဆုံး စာလုံးကြီးတစ်လုံးနှင့် စာလုံးသေးတစ်လုံးပါရှိရပါမည်။',
        'numbers' => ':attribute တွင် အနည်းဆုံး ဂဏန်းတစ်လုံးပါရှိရပါမည်။',
        'symbols' => ':attribute တွင် အနည်းဆုံး သင်္ကေတတစ်ခုပါရှိရပါမည်။',
        'uncompromised' => 'ပေးထားသော :attribute သည် ဒေတာယိုစိမ့်မှုတွင် ပါဝင်ခဲ့သည်။ ကျေးဇူးပြု၍ အခြားသော :attribute ကို ရွေးချယ်ပါ။',
    ],
    'present' => ':attribute သည် ရှိရပါမည်။',
    'present_if' => ':other သည် :value ဖြစ်သောအခါ :attribute ရှိရပါမည်။',
    'present_unless' => ':other သည် :value မဟုတ်လျှင် :attribute ရှိရပါမည်။',
    'present_with' => ':values ရှိသောအခါ :attribute ရှိရပါမည်။',
    'present_with_all' => ':values များရှိသောအခါ :attribute ရှိရပါမည်။',
    'prohibited' => ':attribute ကို တားမြစ်ထားသည်။',
    'prohibited_if' => ':other သည် :value ဖြစ်သောအခါ :attribute ကို တားမြစ်ထားသည်။',
    'prohibited_if_accepted' => ':other ကို လက်ခံသောအခါ :attribute ကို တားမြစ်ထားသည်။',
    'prohibited_if_declined' => ':other ကို ငြင်းပယ်သောအခါ :attribute ကို တားမြစ်ထားသည်။',
    'prohibited_unless' => ':other သည် :values တွင်မရှိလျှင် :attribute ကို တားမြစ်ထားသည်။',
    'prohibits' => ':attribute သည် :other ကို တားမြစ်သည်။',
    'regex' => ':attribute ဖော်မတ်သည် မမှန်ကန်ပါ။',
    'required' => ':attribute လိုအပ်ပါသည်။',
    'required_array_keys' => ':attribute တွင် :values အတွက် entries များ ပါရှိရပါမည်။',
    'required_if' => ':other သည် :value ဖြစ်သောအခါ :attribute လိုအပ်ပါသည်။',
    'required_if_accepted' => ':other ကို လက်ခံသောအခါ :attribute လိုအပ်ပါသည်။',
    'required_if_declined' => ':other ကို ငြင်းပယ်သောအခါ :attribute လိုအပ်ပါသည်။',
    'required_unless' => ':other သည် :values တွင်မရှိလျှင် :attribute လိုအပ်ပါသည်။',
    'required_with' => ':values ရှိသောအခါ :attribute လိုအပ်ပါသည်။',
    'required_with_all' => ':values များရှိသောအခါ :attribute လိုအပ်ပါသည်။',
    'required_without' => ':values မရှိသောအခါ :attribute လိုအပ်ပါသည်။',
    'required_without_all' => ':values များထဲမှ တစ်ခုမှ မရှိသောအခါ :attribute လိုအပ်ပါသည်။',
    'same' => ':attribute နှင့် :other သည် ကိုက်ညီရပါမည်။',
    'size' => [
        'array' => ':attribute တွင် :size items များ ပါရှိရပါမည်။',
        'file' => ':attribute သည် :size kilobytes ဖြစ်ရပါမည်။',
        'numeric' => ':attribute သည် :size ဖြစ်ရပါမည်။',
        'string' => ':attribute သည် :size စာလုံး ဖြစ်ရပါမည်။',
    ],
    'starts_with' => ':attribute သည် အောက်ပါတို့ဖြင့် စရပါမည် - :values',
    'string' => ':attribute သည် စာသားဖြစ်ရပါမည်။',
    'timezone' => ':attribute သည် မှန်ကန်သော timezone ဖြစ်ရပါမည်။',
    'unique' => ':attribute ကို အသုံးပြုပြီးဖြစ်သည်။',
    'uploaded' => ':attribute upload လုပ်ရန် မအောင်မြင်ပါ။',
    'uppercase' => ':attribute သည် စာလုံးကြီးဖြစ်ရပါမည်။',
    'url' => ':attribute သည် မှန်ကန်သော URL ဖြစ်ရပါမည်။',
    'ulid' => ':attribute သည် မှန်ကန်သော ULID ဖြစ်ရပါမည်။',
    'uuid' => ':attribute သည် မှန်ကန်သော UUID ဖြစ်ရပါမည်။',

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

    'attributes' => [],

];
