<?php
    require 'vendor/autoload.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $host = "us-cdbr-east-02.cleardb.com";
    $dbUsername = "b439f60082bbb1";
    $dbPassword = "175824a2";
    $dbname = "heroku_364712d29ce9e84";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if($conn->connect_error){
        echo "$conn->connect_error";
        die("Connection Failed : ". $conn->connect_error);
    } else {
        $sql = "insert into user(first_name, last_name, email, phone) values('$first_name', '$last_name', '$email', '$phone')";

        if ($conn->query($sql) === TRUE) {
            $from = new \SendGrid\Email("Example User", "joshbarrientos1@gmail.com");
            $subject = "Website Contact Form:  $first_name $last_name";
            $to = new \SendGrid\Email("Example User", "dannybaek5@gmail.com");
            $content = new \SendGrid\Content("text/plain", "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nFirst name: $first_name\n\nLast name: $last_name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message");
            $mail = new \SendGrid\Mail($from, $subject, $to, $content);
            echo "Added: ".$first_name." ".$last_name;

            $apiKey = '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';
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