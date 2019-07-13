<?php  require("HeaderDashBoard.php"); ?>
<?php  require("_includes/login_menuDash.php"); ?>
<?php  require(  "Connections/connection.php"); ?>

<?php

try{

    session_start();

    if(isset($_POST['reset_password']))
    {
        if(empty($_POST["passwordreset"]))
        {
            $message='<label> all fields are requared</label>';
        }
        else
        {
            // ':emails'=> $_POST['passwordreset'];

            function getPosts()
            {
                $posts=array();
                $posts[0]=$_POST['passwordreset'];

                return $posts;
            }

            $data= getPosts();


            // $emails = $_POST['passwordreset'];
            $query="SELECT * FROM  users where Email=:emails";
            $statement=$conn->prepare($query);
            $statement->execute(
                array(
                    ':emails' =>$_POST["passwordreset"]
                ));

            $count=$statement->rowCount();
            if ($count>0)
            {
                //  echo "Send email to user with password";



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


            }
            else
            {
                $message='<label> Wrong Input Data</label>';

            }


        }
    }




}

catch(PDOException $error)

{
    $message= $error->getMessage();

}


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



        <br /> Back to Sign in? <a style="align:left;" href="Systems_UsersForm.php">Yes</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

        <input name="reset_password" type="submit"   class="btn btn-primary  " value="Reset" id="resetpassbutton" " />

        <br>




    </form>
</div>

<?php  require("_includes/Footer.php"); ?>

</body>
</html>