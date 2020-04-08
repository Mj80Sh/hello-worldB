<?php
/**
 * Telegram Bot example.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include 'Telegram.php';
include 'jdf.php';

header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

// Set the bot TOKEN
$bot_token = '979191276:AAEda6Rai7LWRxjaH4mfUBNWwUcnT1-1doc';
// Instances the class
$telegram = new Telegram($bot_token);

$text = $telegram->Text();
$chat_id = $telegram->ChatID();

$servername = "localhost";
$username = "tlbotir1_root";
$password = "o.*E%D@.yG+x";
$dbname = "tlbotir1_shagh";
$TBname='shagh';


$conn = new mysqli($servername, $username, $password, $dbname);


if(isset($_GET['timer']))
if($_GET['timer'])
{
   
    $sql = "SELECT DISTINCT Uid FROM shagh";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($uid = mysqli_fetch_assoc($result)) {
            $option = array( 
                //First row
                array($telegram->buildInlineKeyBoardButton("خواب",  $url = '', $callback_data = '0'),
                      $telegram->buildInlineKeyBoardButton("خوابالو",   $url = '', $callback_data = '1')),
                      array($telegram->buildInlineKeyBoardButton("آماده به کار",  $url = '', $callback_data = '2'),
                      $telegram->buildInlineKeyBoardButton("زده بالا",   $url = '', $callback_data = '3')),
                      array($telegram->buildInlineKeyBoardButton("میخوام بزززززززززنم",  $url = '', $callback_data = '4'))
                    );
            $keyb = $telegram->buildInlineKeyBoard($option);
            $content = array('chat_id' => $uid["Uid"], 'reply_markup' => $keyb, 'text' => "الان شقه؟"."\n".jdate("l, j F Y \nH:i" , time()));
            $id= $telegram->sendMessage($content)['result']['message_id'];

            $time=time();
            $UID=$uid['Uid'];
            $name='';
            $sql = "INSERT INTO shagh (Uid,name, time,MSG) VALUES ($UID,'$name', $time,$id)";
            $conn->query($sql);
           
        }
    }
  

}

$callback_query = $telegram->Callback_Query();
if ($callback_query !== null && $callback_query != '') {
    
    $Fname=$callback_query['from']['first_name'];
    $MSG=$telegram->Callback_Message()['message_id'];
    $data=$telegram->Callback_Data();
    $id=$telegram->Callback_ChatID();
    if($data!=8){
    $sql = "UPDATE shagh  SET name='$Fname',value=$data WHERE MSG=$MSG";
    $conn->query($sql);
    }
    if($data==8)
    {
    $content = ['callback_query_id' => $telegram->Callback_ID(), 'text' => 'قبلا ثبت شده داداش!', 'show_alert' => true];
    $telegram->answerCallbackQuery($content);
    }



    $sql = "SELECT * FROM shagh WHERE MSG=$MSG";
    $result = mysqli_query($conn, $sql);
    $time = mysqli_fetch_array($result)['time'];


    if($data==0){
    $option = array( 
        array($telegram->buildInlineKeyBoardButton("خواب✅",  $url = '', $callback_data = '8'),
              $telegram->buildInlineKeyBoardButton("خوابالو",   $url = '', $callback_data = '8')),
        array($telegram->buildInlineKeyBoardButton("آماده به کار",  $url = '', $callback_data = '8'),
              $telegram->buildInlineKeyBoardButton("زده بالا",   $url = '', $callback_data = '8')),
        array($telegram->buildInlineKeyBoardButton("میخوام بزززززززززنم",  $url = '', $callback_data = '8')));
    }
    if($data==1){
    $option = array( 
        array($telegram->buildInlineKeyBoardButton("خواب",  $url = '', $callback_data = '8'),
            $telegram->buildInlineKeyBoardButton("خوابالو✅",   $url = '', $callback_data = '8')),
        array($telegram->buildInlineKeyBoardButton("آماده به کار",  $url = '', $callback_data = '8'),
            $telegram->buildInlineKeyBoardButton("زده بالا",   $url = '', $callback_data = '8')),
        array($telegram->buildInlineKeyBoardButton("میخوام بزززززززززنم",  $url = '', $callback_data = '8')));
    }
    if($data==2){
        $option = array( 
            array($telegram->buildInlineKeyBoardButton("خواب",  $url = '', $callback_data = '8'),
                $telegram->buildInlineKeyBoardButton("خوابالو",   $url = '', $callback_data = '8')),
            array($telegram->buildInlineKeyBoardButton("آماده به کار✅",  $url = '', $callback_data = '8'),
                $telegram->buildInlineKeyBoardButton("زده بالا",   $url = '', $callback_data = '8')),
            array($telegram->buildInlineKeyBoardButton("میخوام بزززززززززنم",  $url = '', $callback_data = '8')));
        }
    if($data==3){
    $option = array( 
        array($telegram->buildInlineKeyBoardButton("خواب",  $url = '', $callback_data = '8'),
            $telegram->buildInlineKeyBoardButton("خوابالو",   $url = '', $callback_data = '8')),
        array($telegram->buildInlineKeyBoardButton("آماده به کار",  $url = '', $callback_data = '8'),
            $telegram->buildInlineKeyBoardButton("زده بالا✅",   $url = '', $callback_data = '8')),
        array($telegram->buildInlineKeyBoardButton("میخوام بزززززززززنم",  $url = '', $callback_data = '8')));
    }
    if($data==4){
        $option = array( 
            array($telegram->buildInlineKeyBoardButton("خواب",  $url = '', $callback_data = '8'),
                $telegram->buildInlineKeyBoardButton("خوابالو",   $url = '', $callback_data = '8')),
            array($telegram->buildInlineKeyBoardButton("آماده به کار",  $url = '', $callback_data = '8'),
                $telegram->buildInlineKeyBoardButton("زده بالا",   $url = '', $callback_data = '8')),
            array($telegram->buildInlineKeyBoardButton("میخوام بزززززززززنم✅",  $url = '', $callback_data = '8')));
    }

    $keyb = $telegram->buildInlineKeyBoard($option);
    $content = array('chat_id' => $id,'message_id'=>$MSG, 'reply_markup' => $keyb, 'text' => "الان شقه؟"."\n".jdate("l, j F Y \nH:i" , $time));
    $telegram->editMessageText($content);
}





if(isset($_GET['startDate'])&& isset($_GET['endDate'])){

$db=new PDO('mysql:dbname=tlbotir1_shagh;host=localhost;','tlbotir1_root','o.*E%D@.yG+x');  
//here prepare the query for analyzing, prepared statements use less resources and thus run faster  
$s=$_GET['startDate'];
$e=$_GET['endDate'];
$row=$db->prepare("select * from shagh where time>$s AND time<$e");  
  
$row->execute();//execute the query  
$json_data=array();//create the array  
foreach($row as $rec)//foreach loop  
{  
    $json_array['id']=$rec['id'];  
    $json_array['Uid']=$rec['Uid'];  
    $json_array['name']=$rec['name'];  
    $json_array['value']=$rec['value'];  
    $json_array['time']=$rec['time'];
//here pushing the values in to an array  
    array_push($json_data,$json_array);  
  
}  
  
//built in PHP function to encode the data in to JSON format  
echo json_encode($json_data,JSON_PRETTY_PRINT);  

}

if($text){
    if($text=='/start'){
    $option = array( 
        //First row
        array($telegram->buildKeyboardButton("خوابه"), $telegram->buildKeyboardButton("خوابالو")), 
        //Second row 
        array($telegram->buildKeyboardButton("آماده به کار"), $telegram->buildKeyboardButton("زده بالا"), $telegram->buildKeyboardButton("میخوام بزنم")) );
    $keyb = $telegram->buildKeyBoard($option, $onetime=false);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "حالت دستی فعال شد");
    $telegram->sendMessage($content);
    }

    $value=-1;
    switch($text){
        case 'خوابه':
            $value=0;
        break;
        case 'خوابالو' :
            $value=1;
        break;
        case "آماده به کار":
            $value=2;
        break;
        case "زده بالا" :
            $value=3;
        break;
        case "میخوام بزنم":
            $value=4;
        break;
    }

    if($value>=0){
        $Fname=$telegram->FirstName();
        $time=time();
        $sql = "INSERT INTO shagh (Uid,name,value, time,MSG) VALUES ($chat_id,'$Fname',$value, $time,'0')";
        $conn->query($sql);
        $content = array('chat_id' => $chat_id, 'text' => "وضعیت کیر شما ثبت شد!");
        $telegram->sendMessage($content);
    }

    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $conn->error);
    $telegram->sendMessage($content);
}

$conn->close();



