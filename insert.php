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
            echo "added";
            $from = new SendGrid\Email("Example User", "test@example.com");
            $subject = "Sending with SendGrid is Fun";
            $to = new SendGrid\Email("Example User", "kargirwar@gmail.com");
            $content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
            $mail = new SendGrid\Mail($from, $subject, $to, $content);
            
            //$apiKey = getenv('SENDGRID_API_KEY');
            $sg = new \SendGrid(trim(file_get_contents("SENDGRID_API_KEY")));
            
            $response = $sg->client->mail()->send()->post($mail);
            echo $response->statusCode();
            print_r($response->headers());
            echo $response->body();

        } else {
            echo "Error: ".$sql."<br>".$conn->error;
        }
        $conn->close();
    }
?>