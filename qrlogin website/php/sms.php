?php
class Sender{
var $host;
var $port;
/*
* Username that is to be used for submission
*/
var $strUserName;
/*
* password that is to be used along with username
*/
var $strPassword;
/*
* Sender Id to be used for submitting the message
*/
var $strSender;
/*
* Message content that is to be transmitted
*/
var $strMessage;
/*
* Mobile No is to be transmitted.
*/
var $strMobile;
var $strMessageType;
/*
* Require DLR or not
* &lt;ul&gt;
* &lt;li&gt;0:means DLR is not Required&lt;/li&gt;
* &lt;li&gt;1:means DLR is Required&lt;/li&gt;
* &lt;/ul&gt;
*/
var $strDlr;
private function sms__unicode($message){
$hex1=&#39;&#39;;
if (function_exists(&#39;iconv&#39;)) {
$latin = @iconv(&#39;UTF-8&#39;, &#39;ISO-8859- 1&#39;, $message);
if (strcmp($latin, $message)) {
$arr = unpack(&#39;H*hex&#39;, @iconv(&#39;UTF-8&#39;,
2BE&#39;, $message));
$hex1 = strtoupper($arr[&#39;hex&#39;]);
}
if($hex1 ==&#39;&#39;){
$hex2=&#39;&#39;;
$hex=&#39;&#39;;

for ($i=0; $i &lt; strlen($message); $i++){
$hex = dechex(ord($message[$i]));
$len =strlen($hex);
$add = 4 - $len;
if($len &lt; 4){
for($j=0;$j&lt;$add;$j++){
$hex=&quot;0&quot;.$hex;
}
}
$hex2.=$hex;
}
return $hex2;
}
else{
return $hex1;
}
}
else{
print &#39;iconv Function Not Exists !&#39;;
}
}
//Constructor..
public function Sender ($host,$port,$username,$password,$sender, $message,$mobile,
$msgtype,$dlr){
$this-&gt;host=$host;
$this-&gt;port=$port;
$this-&gt;strUserName = $username;
$this-&gt;strPassword = $password;
$this-&gt;strSender= $sender;
$this-&gt;strMessage=$message; //URL Encode The Message..
$this-&gt;strMobile=$mobile;
$this-&gt;strMessageType=$msgtype;
$this-&gt;strDlr=$dlr;
}
public function Submit(){
if($this-&gt;strMessageType==&quot;2&quot; ||
$this-&gt;strMessageType==&quot;6&quot;) {
//Call The Function Of String To HEX.
$this-&gt;strMessage = $this-&gt;sms__unicode(
$this-&gt;strMessage);
try{
//Smpp http Url to send sms.
$live_url=&quot;http://&quot;.$this-&gt;host.&quot;:&quot;.$this- &gt;port.&quot;/sendsms?username=&quot;.$this-
&gt;strUserName.&quot;&amp;password=&quot;.$this-
&gt;strPassword.&quot;&amp;type=&quot;.$this-&gt;strMessageType.&quot;&amp;dlr=&quot;.$this- &gt;strDlr.&quot;&amp;destination=&quot;.$this-
&gt;strMobile.&quot;&amp;source=&quot;.$this-&gt;strSender.&quot;&amp;message=&quot;.$this- &gt;strMessage.&quot;&quot;;
$parse_url=file($live_url);
echo $parse_url[0];
}catch(Exception $e){
echo &#39;Message:&#39; .$e-&gt;getMessage();
}
}
else
$this-&gt;strMessage=urlencode($this- &gt;strMessage);
try{
//Smpp http Url to send sms.

$live_url=&quot;http://&quot;.$this-&gt;host.&quot;:&quot;.
$this-&gt;port.&quot;/sendsms?username=&quot;.$this- &gt;strUserName.&quot;&amp;password=&quot;.$this-
&gt;strPassword.&quot;&amp;type=&quot;.$this-&gt;strMessageType.&quot;&amp;dlr=&quot;.$this- &gt;strDlr.&quot;&amp;destination=&quot;.$this-
&gt;strMobile.&quot;&amp;source=&quot;.$this-
&gt;strSender.&quot;&amp;message=&quot;.$this-&gt;strMessage.&quot;&quot;;
$parse_url=file($live_url);
echo $parse_url[0];
}
catch(Exception $e){
echo &#39;Message:&#39; .$e-&gt;getMessage();
}
}
}
//Call The Constructor.
$obj = new Sender(&quot;IP&quot;,&quot;Port&quot;,&quot;&quot;,&quot;&quot;,&quot;Tester&quot;,&quot; &quot;_______&quot;,&quot; 919990001245
,&quot;2&quot;,&quot;1&quot;);
$obj-&gt;Submit ();
?&gt;