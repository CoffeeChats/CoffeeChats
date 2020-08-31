<?php
if(empty($_POST['first_name'])      ||
   empty($_POST['last_name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "No arguments Provided!";
   return false;
   }
   
$first_name = strip_tags(htmlspecialchars($_POST['first_name']));
$last_name = strip_tags(htmlspecialchars($_POST['last_name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// Create the email and send the message
$to = 'coffeechats.network@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Website Contact Form:  $first_name $last_name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nFirst name: $first_name\n\nLast name: $last_name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
$headers = "coffeechats.network@gmail.com"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";   
mail($to,$email_subject,$email_body,$headers);
return true;         
?>