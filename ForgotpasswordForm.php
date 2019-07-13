<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/login_menuDash.php"); ?>
<?php  require(  "Connections/connection.php"); ?>

<?php



    session_start();


    if(isset($_POST['reset_password']))
    {
        if(empty($_POST["passwordreset"]))
        {
            $message='<label> Email field are requared</label>';
        }
        else
        {

            function getPosts()
            {
                $posts=array();
                $posts[0]=$_POST['passwordreset'];
                return $posts;
            }
            $data= getPosts();

           $query="SELECT * FROM  bussness_users where Email=:emails";
            $statement=$conn->prepare($query);
            $statement->execute(
                array(
                    ':emails' =>$_POST["passwordreset"]
                ));

            if ($statement) {
                $user = $statement->fetch();

                $datas=$user[3];

            }


                $count=$statement->rowCount();
            if ($count>0)
            {
            //  echo "Send email to user with password";
                require 'PHPMailer/PHPMailerAutoload.php';

                $mail = new PHPMailer(true);
                try{


                    $mail->IsSMTP(true);
//$mail->SMTPDebug = 2;
                    $mail->From = "walterochieng6950@gmail.com";
                    $mail->FromName = "Innovative Digital Computers";
                    $mail->Host = "smtp.gmail.com";
//$mail->Host = "email-smtp.us-east-1.amazonaws.com";
                    $mail->SMTPSecure= "ssl";
                    $mail->Port = 465;
                    $mail->SMTPAuth = true;
                    $mail->Username = "walterochieng6950@gmail.com";
                    $mail->Password = "digitaldombo";
                    $mail->AddAddress($data[0]);
                    $mail->AddReplyTo("walterochieng6950@gmail.com");
                    $mail->WordWrap = 50;
                    $mail->IsHTML(true);
                    $mail->Subject = 'Notification From B-Tax Systems';
                    $mail->Body = 'The password for your B-Tax System is  '.$datas;

                    $mail->Send();

                    echo  'Password sent to your email';

                }catch(Exception $e)
                {
                    echo 'Sorry, we are Unable to send your password. Check your network connection';
                    echo 'Mail error' . $mail->ErrorInfo;


                }

            }
            else
            {
                $message='<label> Wrong Input Data</label>';

            }


        }
    }


               /* $mail->setFrom('walterochieng44@yahoo.com', 'Walter B Tax Systems');
                $mail->addAddress('walterochieng6950@gmail.com', 'Wialter Th');
                $mail->Subject  = 'First PHPMailer Message';
                $mail->Body     = 'Hi! This is my first e-mail sent through PHPMailer.';
                if(!$mail->send()) {
                    echo 'Message was not sent.';
                    echo 'Mailer error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message has been sent.';
                }*/

              /*  while( $row = $statement->fetch(PDO::FETCH_ASSOC($query)))
                {


                    $password = $row['Password'];
                    $to = $row['Email'];
                    $subject = "Your Recovered Password";

                    $message = "Please use this password to login " . $password;
                    $headers = "From : waltero@innovativedigitalcomputers.com";
                    if (mail($to, $subject, $message, $headers)) {
                        echo "Your Password has been sent to your email Address";
                    } else {
                        echo "Failed to Recover your password, try again";
                    }
                }
                */


              /*
               *
                require 'PHPMailer/PHPMailerAutoload.php';
                $mail = new PHPMailer();

              //  $mail->isSMTP();
                $mail->SMTPAuth =true;
                $mail->SMTPSecure='ssl';
                $mail->Host ='smtp.gmail.com';
                $mail->Port= '465';
                $mail->isHTML();
                $mail->Username ='walterochieng6950@gmail.com';
                $mail->Password = 'digitaldombo';
                $mail->SetFrom('walterochieng6950@gmail.com');
                $mail->Subject='Hello World';
                $mail->Body ='A test Mail!';
                $mail->AddAddress('walterochieng6950@gmail.com');

                $mail->Send();

                if(!$mail->Send()) {
                    echo 'Message was not sent.';
                    echo 'Mailer error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message has been sent.';
                }
               */











?>





<?php

if(isset($message))
{
    echo '<span class=" alert alert-danger">'.$message.'</span>';

}
?>


<div class="panelDisplay">
    <form action="<?php   ?>" method="POST"    class="usersforgotpasswordform"  enctype="multipart/form-data" name="usersBussLogin" id="usersBussLoginPage"  >

        <div class="form-group">
            <label for="passwordreset">Enter your Email here to reset password </label>
            <input type="email" name="passwordreset" required placeholder="Enter  Email" id="loginEmail" " />
        </div>



        <br /> Back to Sign in? <a style="align:left;" href="LoginBussinessUsers.php">Yes</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

        <input name="reset_password" type="submit"   class="btn btn-primary  " value="Reset" id="resetpassbutton" " />

        <br>




    </form>
</div>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>