<?php 
// It return proper info in JSON format
//DEBUG ONLY, remove it after
//ini_set('display,errors',1);

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json; charset=UTF-8');
$results = [];
$visitor_name = '';
$visitor_email = '';
$visitor_message = '';

//Check the submission ---> Validate the data

// isset - Determine if a variable is declared and is different than NULL
if (isset($_POST['firstname'])) {
    //filter_var - Filters a variable with a specified filter
    if(!empty($_POST['firstname'])){
        echo "This field is required.";
        return false;
    }
    $visitor_name = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
}

if (isset($_POST['lastname'])) {
    $visitor_name .= ' ' .filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
}

if (isset($_POST['email'])) {
    $visitor_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
}

if (isset($_POST['message'])) {
    $visitor_message =  filter_var(htmlspecialchars($_POST['message']), FILTER_SANITIZE_STRING);
}
if (isset($_POST['g-recaptcha'])){
    $secret_key = '6Ld5IOEZAAAAAPBj1NNITvV0YO21KsHyiD7-6B80';
}

$results['name'] = $visitor_name;
$results['message'] = $visitor_message;

//Prepare the email
$email_subject = '';
$email_recipient = 'test@mail.ca';

//sprinf - Return a formatted string
$email_message = sprintf('Name: %s, Email: %s, Message: %s', $visitor_name, $visitor_email, $visitor_message);

$email_headers = array(
    // 'From' => 'noreply@yourdomain.ca',
    // 'Reply-To' => $visitor_email,
    
    'From'=>$visitor_email
);

//Send out the email
//mail - Send mail
$email_result = mail($email_recipient, $email_subject, $email_message, $email_headers);
if ($email_result) {
    $results['message'] = sprintf('Thank you for contacting us, %s. You will get a reply within 24 hours.', $visitor_name);

} else {
    $results['message'] = sprintf('We are sorry but the email did not go through.');
}


// json_encode - Returns the JSON representation of a value
echo json_encode($results);


