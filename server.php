<?php

require("PHPMailer_5.2.0/class.phpmailer.php");
include 'conf/db.php';


$first_name  = "";
$last_name   = "";
$email       = "";
$affiliation = "";
$country     = "";
$motivation  = "";
$newsletter  = "";
$mainCaptcha  = "";
$securityCode  = "";

$errors = array();

$db = @mysqli_connect($host,$username,$password,$database);

if (mysqli_connect_errno()) {
    array_push($errors, "<p class='text-danger text-center'>Something went wrong. Please, try again later.</p>");
}

if (isset($_POST['submit'])) {
    
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $affiliation = mysqli_real_escape_string($db, $_POST['affiliation']);
    $country = mysqli_real_escape_string($db, $_POST['country']);
    $motivation = mysqli_real_escape_string($db, $_POST['motivation']);
    $newsletter = mysqli_real_escape_string($db, $_POST['newsletter']);
    $mainCaptcha  = mysqli_real_escape_string($db, $_POST['mainCaptcha']);
    $securityCode  = mysqli_real_escape_string($db, $_POST['securityCode']);
    
    $newsletter = isset($_POST['newsletter']) ? $_POST['newsletter'] : 'no';
    
    //echo "newsletter:" . $newsletter;
    
    if ($newsletter == "no") {
        $newsletter = 0;
    }
    else {
        $newsletter = 1;
    }
   
    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($affiliation) && !empty($country) && !empty($motivation) && !empty($securityCode)) { 

        if ($mainCaptcha === $securityCode) {
            
            try {
                $user_check_query = $db->prepare("SELECT * FROM ophuser WHERE email=?");
                $user_check_query->bind_param("s", $email);
                
                $user_check_query->execute();
                
                $result = $user_check_query->execute();
                $user_check_query->store_result();
                
                if ($user_check_query->num_rows === 0) {
                    if (count($errors) == 0) {
                        
                        $stmt = $db->prepare('INSERT INTO ophuser (first_name, last_name, email, affiliation, country, motivation, newsletter) value (?,?,?,?,?,?,?)');
                        $stmt->bind_param("ssssssi",$first_name, $last_name, $email, $affiliation, $country, $motivation, $newsletter);
                        
                        $stmt->execute();
                        
                        //email to administrator
                        $mail = new PHPMailer();
                        $mail->isSMTP();
                        $mail->Host = $mailHost;
                        $mail->SMTPAuth = true;
                        $mail->Username = $mailUser;
                        $mail->Password = $mailPass;
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = $mailPort;
                        
                        $mail->SetFrom($mailFrom,"ECASLab");
                        
                        $mail->addAddress($mailFrom);
                        $mail->Subject = 'New registration request for Ophidia Cluster';
                        
                        $MESSAGE_BODY = "Registration details: \n\nFirst name: $first_name\nLast name: $last_name\n";
                        $MESSAGE_BODY .= "Email: $email\nAffiliation: $affiliation\n";
                        $MESSAGE_BODY .= "Country: $country\nMotivation: $motivation";
                        
                        $mail ->Body = $MESSAGE_BODY;
                        
                        if (!$mail->Send()) {
                            array_push($errors, "<p class='text-danger text-center'>Something went wrong, please try again.</p>");
                        } 
                        
                        //email to user
                        $mail2 = new PHPMailer();
                        $mail2->isSMTP();
                        $mail2->Host = $mailHost;
                        $mail2->SMTPAuth = true;
                        $mail2->Username = $mailUser;
                        $mail2->Password = $mailPass;
                        $mail2->SMTPSecure = 'ssl';
                        $mail2->Port = $mailPort;
                        
                        $mail2->SetFrom($mailFrom,"ECASLab");
                        
                        $mail2->addAddress($email);                       
                        $mail2->Subject = 'ECASLab account request';
                        
                        $MESSAGE_BODY2 = "Dear $first_name $last_name,\n\n";
                        $MESSAGE_BODY2 .= "Thank you for registering to ophidialab.cmcc.it.\n";
                        $MESSAGE_BODY2 .= "Your request is being processed. You will receive an email with the credentials soon.\n\n";
                        $MESSAGE_BODY2 .= "Best regards,\n";
                        $MESSAGE_BODY2 .= "ECASLab team\n\n";
                        $MESSAGE_BODY2 .= "NOTE: If you didn't register to ECASLab, please contact us at ecas-support@cmcc.it";
                        
                        $mail2 ->Body = $MESSAGE_BODY2;
                        
                        if (!$mail2->Send()) {
                            array_push($errors, "<p class='text-danger text-center'>Something went wrong, please try again.</p>");
                        }
                        
                        header('location: registered.php');
                        
                    }
                }
                else {
                    array_push($errors, "<p class='text-danger text-center'>Email already in use.</p>");
                }
            }
            catch (ErrorException $e) {
                array_push($errors, "<p class='text-danger text-center'>Something went wrong. Please, try again later.</p>");
            }
        }
        else {
            array_push($errors, "<p class='text-danger text-center'>Please, insert a valid captcha code.</p>");
        }                                
    }
    else {
        array_push($errors, "<p class='text-danger text-center'>Please, fill out properly all the required fields.</p>");
    }
}
