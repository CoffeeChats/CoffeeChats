<?php
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
            $email_subject = "Website Contact Form:  $first_name $last_name";
            $email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nFirst name: $first_name\n\nLast name: $last_name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
            $headers = "coffeechats.network@gmail.com"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
            $headers .= "Reply-To: $email_address";   
            mail($email,$email_subject,$email_body,$headers);
            echo "Added: ".$first_name." ".$last_name;
        } else {
            echo "Error: ".$sql."<br>".$conn->error;
        }
        $conn->close();
    }
?>