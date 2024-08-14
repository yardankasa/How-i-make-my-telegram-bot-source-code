<?php
// author , writer : Mahdi Eskandari
// all rights safe for mine.
// E-mail : yardankasa@gmail.com | zameh.ir

//-----------------

if(!is_dir("names")){mkdir("names");}
if(!is_dir("users")){mkdir("users");}
define("TOKEN","here for you token");
function bot($method, $data=[]){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.TOKEN.'/'.$method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    return json_decode(curl_exec($ch));
}
$update  = json_decode(file_get_contents("php://input"));
$message = $update->message;
$text    = $message->text;
$chat_id = $message->chat->id;
$from_id = $message->from_id;

$caquery = $update->callback_query;
$caquery_id = $update->callback_query->id;
$data    = $caquery->data;
$from_id2 = $caquery->from->id;

$user = file_get_contents("users/$chat_id");
$name = file_get_contents("names/$chat_id");


$first_name = $update->message->from->first_name;
$username   = $update->message->from->username;

if(!file_exists("users/$chat_id")){

    file_put_contents("users/$chat_id","nothing");

    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"به جمع ما خوش اومدی!"
    ]);
}


if(!file_exists("names/$chat_id")){
$name = "عزیز";
}

if($text=="سلام" or $text=="/start"){
    file_put_contents("users/$chat_id","nothing");
        bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"سلام $name  به سرزمین ایده های جدید و نو خوش آمدی!",
        'reply_markup'=>json_encode(['keyboard'=>[
            [['text'=>"اکانت من"]],
            [['text'=>"متن برجسته"],['text'=>"آمار ربات"]],
            [['text'=>"دکمه شیشه ای"],['text'=>"ثبت نام"]],
            [['text'=>"دریافت ویس"],['text'=>"فوروارد پیام"]],
            [['text'=>"دریافت داکیومنت"],['text'=>"دریافت آهنگ"]],
            [['text'=>"لوگو تلگرام"],['text'=>"دریافت فیلم"]],
            [['text'=>'درباره ما'],['text'=>'کانال ما']]
        ],'resize_keyboard'=>true])
        ]); } 


    if($text=="درباره ما"){

         bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"من یک ربات آزمایشی در کتاب آموزش طراحی ربات تلگرام هستم.",
         ]);
    }

    if($text=="کانال ما"){
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"متن برای کانال ما",
             ]);
    }
    if($text=="لوگو تلگرام"){
   bot('sendphoto',[
    'chat_id'=>$chat_id,
    'photo'=>"https://img.freepik.com/premium-vector/telegram-logo_976174-21.jpg",
    'caption'=>"این لوگو تلگرام است."
   ]);

    }

    if($text=="دریافت فیلم"){
        bot('sendvideo',[
            'chat_id'=>$chat_id,
            'video'=>new CURLFILE("video.mp4"),
            'caption'=>"این یک فیلم است"
           ]);
    }

    if($text=="دریافت داکیومنت"){
        bot('senddocument',[
            'chat_id'=>$chat_id,
            'document'=>new CURLFILE("rezomeh.pdf"),
            'caption'=>"این یک Document است"
           ]);
    }

    if($text=="دریافت آهنگ"){
        bot('sendaudio',[
            'chat_id'=>$chat_id,
            'audio'=>new CURLFILE("music.mp3"),
            'caption'=>"این یک Audio است"
           ]);
    }

    if($text=="دریافت ویس"){
    bot('sendvoice',[
       'chat_id'=>$chat_id,
       'voice'=>new CURLFILE("voice.ogg"),
       'caption'=>"این یک ویس است."

    ]);
    }

    if($text=="فوروارد پیام"){
     bot('forwardmessage',[
        'chat_id'=>$chat_id,
        'from_chat_id'=>"@zamehir",
        'message_id'=>5
     ]);
    }
if($text=="دکمه شیشه ای"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"یک مثال از دکمه های شیشه ای",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"یک مثال لینکی",'url'=>"https://zameh.ir"]],
[['text'=>"یک مثال نمایش پیام",'callback_data'=>"showmessage"]],
[['text'=>"یک مثال ارسال پیام عادی",'callback_data'=>"sendmsg"]],
]
])
]);}
if($data=="showmessage"){
bot('answerCallbackQuery',[
'callback_query_id'=>$caquery_id,
'text'=>"نمایش پیام آزمایشی!",
'show_alert'=>true

]);
}

if($data=="sendmsg"){
    bot('sendmessage',[
    'chat_id'=>$from_id2,
    'text'=>"نمایش پیام آزمایشی!",
    
    ]);

    }

    if($text=="متن برجسته"){
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"این یک متن آزمایشی است که <b>این متن برحسته به نظر میرسد</b> اما این یک متن غیربرجسته است.",
            'parse_mode'=>"html"
            
            ]);
    }



    if(!file_exists("test.txt")){
        file_put_contents("test.txt","long live freedom.");
    }

    if($text=="ثبت نام"){
   file_put_contents("users/$chat_id","set name");

   bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"لطفا نام مورد نظر خودتان را وارد کنید :‌ برای لغو /start",
    
    ]);

    }

    if($user=="set name" and $text!="/start"){
    
        if($text){
        file_put_contents("names/$chat_id","$text");
        file_put_contents("users/$chat_id","nothing");

        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"نام شما به $text تنظیم شد، از این پس شما را با این نام صدا میزنم!"
        ]);

        }
    }

    if($text=="آمار ربات"){
        if($chat_id==1604140942){
     $users_count = count("users");

     bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"تعداد اعضای ربات :‌$users_count است."
     ]);
    }else{
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"شما اجازه دیدن این بخش را ندارید!"
         ]);   
    }
}

    if($text=="اکانت من"){
   bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"نام :‌ $first_name
یوزرنیم :‌ $username
آیدی عددی :‌ $chat_id"
     ]);
    }



// managment section.........
 if($text=="/admin"){

if($chat_id=="1604140942"){


    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"به پنل مدیریت خوش آمدید.",
        'reply_markup'=>json_encode([
            'keyboard'=>[
[['text'=>"آمار ربات"]],
[['text'=>"ارسال پیام همگانی"]]

            ]
        ])
    ]);

}else{
    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"شما اجازه دیدن این بخش را ندارید!"
     ]);   
}
 }

 if($text=="ارسال پیام همگانی"){
    if($chat_id=="1604140942"){

file_put_contents("users/$chat_id","sendall");

bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"لطفا پیام خود را در قالب متن اینجا ارسال کنید :‌ لغو /start"
 ]);  


 }else{
    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"شما اجازه دیدن این بخش را ندارید!"
     ]);   
}
 }

 if($user=="sendall" and $text!="/start"){

    if($text){

        foreach(scandir("users") as $userall){

            bot('sendmessage',[
             'chat_id'=>$userall,
             'text'=>"پیامی از مدیر :‌ \n"."$text"
            ]);
        }

        file_put_contents("users/$chat_id","nothing");

        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"پیام با موفقیت به همه کاربران ارسال شد ."
           ]);
    }

 }

 // author , writer : Mahdi Eskandari
// all rights safe for mine.
// E-mail : yardankasa@gmail.com | zameh.ir
 