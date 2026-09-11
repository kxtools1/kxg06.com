<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: contact.html'); exit; }
if (!empty($_POST['website'] ?? '')) { header('Location: thank-you.html'); exit; }
foreach (['name','email','product','message','website'] as $field) { if (isset($_POST[$field]) && !is_string($_POST[$field])) { http_response_code(400); exit('Invalid input.'); } }
if (strlen($_POST['message'] ?? '') > 20000 || strlen($_POST['name'] ?? '') > 200 || strlen($_POST['product'] ?? '') > 300) { http_response_code(400); exit('Input too long.'); }
function clean($v){return trim(str_replace(["\r","\n"]," ",(string)$v));}
$name=clean($_POST['name']??'');
$email=filter_var(trim((string)($_POST['email']??'')),FILTER_VALIDATE_EMAIL);
$product=clean($_POST['product']??'');
$message=trim((string)($_POST['message']??''));
if($name===''||!$email||$message===''){header('Location: contact.html?error=1');exit;}
$to='gushuai@kxg06.com';
$subject='Website RFQ - '.($product!==''?$product:'General Inquiry');
$body="Name: $name\nEmail: $email\nProduct: $product\n\nMessage:\n$message\n";
$headers="From: CROSSORDER Website <gushuai@kxg06.com>\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8\r\n";
if (!@mail($to,$subject,$body,$headers)) { header('Location: contact.html?error=mail', true, 303); exit; }
header('Location: thank-you.html'); exit;
?>