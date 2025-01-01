<?php

require 'C:/xampp/php/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}


error_reporting(E_ALL);
ini_set('display_errors', 1);


$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);


if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("JSON Decode Error: " . json_last_error_msg());
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input.']);
    exit();
}


if (empty($data['firstName']) || empty($data['lastName']) || empty($data['email'])) {
    echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
    exit();
}


if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    exit();
}

$file = 'submissions.json';
if (file_exists($file)) {
    $existingData = json_decode(file_get_contents($file), true);
    if (!is_array($existingData)) {
        $existingData = [];
    }
} else {
    $existingData = [];
}


$submission = [
    'firstName' => htmlspecialchars($data['firstName']),
    'lastName' => htmlspecialchars($data['lastName']),
    'email' => htmlspecialchars($data['email']),
    'telephone' => htmlspecialchars($data['telephone']),
    'message' => htmlspecialchars($data['message']),
    'date' => date('Y-m-d H:i:s')
];


$existingData[] = $submission;
file_put_contents($file, json_encode($existingData, JSON_PRETTY_PRINT));


$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'gmail'; 
    $mail->Password = 'password';   
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    
    $toAdmin = "prabhath.senadheer@ebeyonds.com, dumidu.kodithuwakku@ebeyonds.com";
    $subjectAdmin = "New Form Submission";
    $messageAdmin = "
      New form submission received:\n
      Name: {$submission['firstName']} {$submission['lastName']}\n
      Email: {$submission['email']}\n
      Telephone: {$submission['telephone']}\n
      Message: {$submission['message']}\n
      Date: {$submission['date']}
    ";
   
   
    $mail->setFrom('no-reply@yourdomain.com', 'Your Website');
    $mail->addAddress($toAdmin);  
    $mail->Subject = $subjectAdmin;
    $mail->Body = $messageAdmin;

    $mail->send();

    
    $mail->clearAddresses();
    $mail->addAddress($submission['email']);
    $mail->Subject = "Thank you for contacting us!";
    $mail->Body = "
      Hi {$submission['firstName']},\n
      Thank you for reaching out to us. We've received your message and will get back to you shortly.\n\n
      Best Regards,\n
      The Team
    ";

    $mail->send();

  
    echo json_encode([
        'success' => true,
        'message' => 'Form submitted successfully. We will get back to you soon.'
    ]);
} catch (Exception $e) {
    error_log("Email Error: " . $mail->ErrorInfo);
    echo json_encode(['success' => false, 'message' => 'Form submitted, but email delivery failed.']);
}
?>
