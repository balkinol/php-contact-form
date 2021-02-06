<?php
    // Message Variable
    $msg = '';
    $msgClass = '';

    // Check for Subbmit
    if(filter_has_var(INPUT_POST, 'submit')){
        // Get Form Data
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        // Check Required Fields
        if(!empty($name) && !empty($email) && !empty($message)){
            // Passed
            // Validate Email
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                // Failed
                $msg = 'Please use a valid email';
                $msgClass = 'alert-danger';
            } else {
                // Passed
                $toEmail = 'theshopifydev@gmail.com';
                $subject = 'Contact Request From '.$name;
                $body = '<h2>Contact Request</h2>
                <h4>Name</h4><p>'.$name.'</p>
                <h4>Email</h4><p>'.$email.'</p>
                <h4>Message</h4><p>'.$message.'</p>
                ';

                // Email Headers
                $headers = "MIME-Version: 1.0" ."\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

                // Additional Headers
                $headers .= "From: " .$name. "<".$email.">". "\r\n";

                if(mail($toEmail, $subject, $body, $headers)){
                    // Email Sent
                    $msg = 'Your Email has been sent';
                    $msgClass = 'alert-success';
                } else {
                    // Failed
                    $msg = 'Your email was not sent';
                    $msgClass = 'alert-danger';
                }
            }
        } else {
            // Failed
            $msg = 'Please fill in all fields';
            $msgClass = 'alert-danger';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-2 mb-3">
        <h3>Contact Us</h3>
    </header>
    <div class="container">

        <?php if($msg != '') : ?>
            <div class="alert <?php echo $msgClass ; ?>"><?php echo $msg ; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : '';?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : '';?>">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : '';?></textarea>
            </div> <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>