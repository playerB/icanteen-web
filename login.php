<?php 
session_start();
        if(isset($_POST['Username'])){
				//connection
                  include("Connections/condb.php");
				//รับค่า user & password
                  $Username = $_POST['Username'];
                  $Password = md5($_POST['Password']);
				//query 
                  $sql="SELECT * FROM user WHERE user_name='".$Username."' and user_password='".$Password."' ";

                  $result = mysqli_query($conn,$sql);
				
                  if(mysqli_num_rows($result)==1){

                      $row = mysqli_fetch_array($result);

                      $_SESSION["user_id"] = $row["user_id"];
                      $_SESSION["user_name"] = $row["user_name"];
                      $_SESSION["user_role"] = $row["user_role"];
                      $_SESSION["user_balance"] = $row["user_balance"];


                      if($_SESSION["user_role"]=="admin"){ //ถ้าเป็น admin ให้กระโดดไปหน้า admin_page.php

                        Header("Location: admin_page.php");

                      }

                      else if ($_SESSION["user_role"]=="member"){  //ถ้าเป็น member ให้กระโดดไปหน้า usermenu.php

                        Header("Location: usermenu.php");

                      }

                      else if ($_SESSION["user_role"]=="vendor"){  //ถ้าเป็น vendor ให้กระโดดไปหน้า usermenu.php

                        Header("Location: usermenu.php");

                      }
                      $_SESSION["Loggedin"] = true;

                  }else{
                    echo "<script>";
                        echo "alert(\".$sql.\");";
                        //echo "window.history.back()";
                    echo "</script>";

                  }

        }else{


             Header("Location: form_login.php"); //user & password incorrect back to login again

        }
?>