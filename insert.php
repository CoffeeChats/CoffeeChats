<?php
    require 'vendors/autoload.php';
    require 'config/config.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if($conn->connect_error){
        echo "$conn->connect_error";
        die("Connection Failed : ". $conn->connect_error);
    } else {
        $sql = "insert into user(first_name, last_name, email, phone) values('$first_name', '$last_name', '$email', '$phone')";

        if ($conn->query($sql) === TRUE) {
            $from = new \SendGrid\Email("Example User", "coffeechats.network@gmail.com");
            $subject = "Website Contact Form:  $first_name $last_name";
            $to = new \SendGrid\Email("Example User", $email);
            $content = new \SendGrid\Content("text/plain", "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nFirst name: $first_name\n\nLast name: $last_name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message");
            $mail = new \SendGrid\Mail($from, $subject, $to, $content);
            echo "Added: ".$first_name." ".$last_name;

            $sg = new \SendGrid($apiKey);

            $response = $sg->client->mail()->send()->post($mail);
            echo $response->statusCode();
            echo $response->headers();
            echo $response->body();

        } else {
            echo "Error: ".$sql."<br>".$conn->error;
        }
        $conn->close();
    }
?>