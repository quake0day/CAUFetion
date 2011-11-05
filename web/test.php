<?php
$conn = @ mysql_connect("localhost","root","xxxxx") or die ("error");
mysql_select_db("xxxxxx",$conn);
mysql_query("set names GBK");

function send_mail($to, $subject = 'No subject', $body) {
$loc_host = "im286"; //发信计算机名，可随意
$smtp_acc = "xxxx"; //Smtp认证的用户名，类似fish1240@fishcat.com.cn，或者fish1240
$smtp_pass="xxx"; //Smtp认证的密码，一般等同pop3密码
$smtp_host="xxxx"; //SMTP服务器地址，类似 smtp.tom.com
$from="xxxx"; //发信人Email地址，你的发信信箱地址
$headers = "Content-Type: text/plain; charset=\"gb2312\"\r\nContent-Transfer-Encoding: base64";
$lb="\r\n"; //linebreak

$hdr = explode($lb,$headers); //解析后的hdr
if($body) {$bdy = preg_replace("/^\./","..",explode($lb,$body));}//解析后的Body

$smtp = array(
//1、EHLO，期待返回220或者250
array("EHLO ".$loc_host.$lb,"220,250","HELO error: "),
//2、发送Auth Login，期待返回334
array("AUTH LOGIN".$lb,"334","AUTH error:"),
//3、发送经过Base64编码的用户名，期待返回334
array(base64_encode($smtp_acc).$lb,"334","AUTHENTIFICATION error : "),
//4、发送经过Base64编码的密码，期待返回235
array(base64_encode($smtp_pass).$lb,"235","AUTHENTIFICATION error : "));
//5、发送Mail From，期待返回250
$smtp[] = array("MAIL FROM: <".$from.">".$lb,"250","MAIL FROM error: ");

$smtp[] = array("RCPT TO: <".$to.">".$lb,"250","RCPT TO error: ");

$smtp[] = array("DATA".$lb,"354","DATA error: ");

$smtp[] = array("From: ".$from.$lb,"","");
//8.2、发送To
$smtp[] = array("To: ".$to.$lb,"","");
//8.1、发送标题
$smtp[] = array("Subject: ".$subject.$lb,"","");
//8.3、发送其他Header内容
foreach($hdr as $h) {$smtp[] = array($h.$lb,"","");}
//8.4、发送一个空行，结束Header发送
$smtp[] = array($lb,"","");
//8.5、发送信件主体
if($bdy) {foreach($bdy as $b) {$smtp[] = array(base64_encode($b.$lb).$lb,"","");}}
//9、发送“.”表示信件结束，期待返回250
$smtp[] = array(".".$lb,"250","DATA(end)error: ");
//10、发送Quit，退出，期待返回221
$smtp[] = array("QUIT".$lb,"221","QUIT error: ");

//打开smtp服务器端口
$fp = @fsockopen($smtp_host, 25);
if (!$fp) echo "<b>Error:</b> Cannot conect to ".$smtp_host."<br>";
while($result = @fgets($fp, 1024)){if(substr($result,3,1) == " ") { break; }}

$result_str="";
//发送smtp数组中的命令/数据
foreach($smtp as $req){
//发送信息
@fputs($fp, $req[0]);
//如果需要接收服务器返回信息，则
if($req[1]){
//接收信息
while($result = @fgets($fp, 1024)){
if(substr($result,3,1) == " ") { break; }
};
if (!strstr($req[1],substr($result,0,3))){
$result_str.=$req[2].$result."<br>";
}
}
}
//关闭连接
@fclose($fp);
return $result_str;
}


//$sql ="select * from signup where id = 1";

$sql = "insert into signup (userid,passwd,tel,telpasswd,email,intime) values ('$_POST[userid]','$_POST[passwd]','$_POST[tel]','$_POST[telpasswd]','$_POST[email]',now())";
$mail = $_POST['email'];
mysql_query($sql) OR die ("fuck");
$subject = "Welcome! \nName:".$_POST['userid']."\nYour cellphone number:".$_POST['tel']."\nPlease do not reply this E-mail. Thanks!";
send_mail($mail,'欢迎使用自动查分系统',$subject);
//$row = mysql_fetch_array($t);
//print_r ($row);
//print_r ($row);
mysql_close();
echo "OK Please check your E-mail:) Redirecting to index..... \n";
echo "<meta http-equiv=refresh content='2;URL=index.html'>";
?>
