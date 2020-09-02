<?php
    require 'vendors/autoload.php';

    //use if local testing. Ask Josh for config file
    //require 'config/config.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    //create connection

    //use if local testing. Ask Josh for config file
    //$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    $conn = new mysqli(getenv(host), getenv(dbUsername), getenv(dbPassword), getenv(dbname));
    if($conn->connect_error){
        echo "$conn->connect_error";
        die("Connection Failed : ". $conn->connect_error);
    } else {
        $sql = "insert into user(first_name, last_name, email, phone) values('$first_name', '$last_name', '$email', '$phone')";

        if ($conn->query($sql) === TRUE) {
            $from = new \SendGrid\Email("CoffeeChats", "coffeechats.network@gmail.com");
            $subject = "CoffeeChats Mentorship Program Survey for:  $first_name $last_name";
            $to = new \SendGrid\Email("New Chatter", $email);
            $content = new \SendGrid\Content("text/plain", "Proceed to the following link to fill out your survey and be matched up with your mentor! \nhttps://docs.google.com/forms/d/e/1FAIpQLSepDBgaTkvQ1yhL85Z08Dx3Ne-Bv1mslbQ7VWwY_Lw-ce2PDQ/viewform");
            $mail = new \SendGrid\Mail($from, $subject, $to, $content);
            echo "Added: ".$first_name." ".$last_name;

            //use if local test. Ask Josh for config file
            //$sg = new \SendGrid($apiKey);

            $sg = new \SendGrid(getenv(apiKey));
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