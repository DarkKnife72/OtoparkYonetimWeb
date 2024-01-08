<?php

$conn = new mysqli("localhost", "root", "", "project_db");

if ($conn->connect_errno > 0) {
    echo "mysql";
}
else
{
    date_default_timezone_set('Europe/Istanbul');
    $conn->set_charset("utf8");
    if ($_POST['type'] == "login")
    {
        $hash_pass = hash('sha256', $_POST['password']);
        $query = "SELECT * FROM accounts WHERE BINARY username = '".$_POST['username']."' AND password = '".$hash_pass."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) 
        {            
            if (session_status() != PHP_SESSION_ACTIVE)
            {
                session_start();
            }
            $row = $result->fetch_assoc();
            $session_id = session_create_id();
            $_SESSION['account_id'] = $row['id'];            
            $_SESSION['account_session'] = $session_id;
            $query = "UPDATE accounts SET last_login = ".time().", session_id = '".$session_id."' WHERE username = '".$_POST['username']."'";
            $result = $conn->query($query);           
        } 
        else
        {
            echo "incorrect";
        }  
    }
    else if ($_POST['type'] == "logout")
    {        
        if (session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        session_destroy(); 
    }
    else if ($_POST['type'] == "change_username")
    {        
        if (session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        $query = "UPDATE accounts SET username = '".$_POST['username']."' WHERE id = ".$_SESSION['account_id']."";
        $result = $conn->query($query);         
    }
    else if ($_POST['type'] == "change_password")
    {
        if (session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        $old_pass = hash('sha256', $_POST['old_password']);
        $new_pass = hash('sha256', $_POST['new_password']);
        $query = "SELECT password FROM accounts WHERE password = '".$old_pass."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0)
        {
            $query = "UPDATE accounts SET password = '".$new_pass."' WHERE id = ".$_SESSION['account_id']."";
            $result = $conn->query($query);            
        } 
        else
        {
            echo "oldpass_not";
        } 
    }
    else if ($_POST['type'] == "change_avatar")
    {
        if (session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
        }        
        $query = "UPDATE accounts SET avatar = '".$_POST['avatar']."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0)
        {
            
        } 
        else
        {
            echo "mysql";
        } 
    }
    else if ($_POST['type'] == "vehicle_add")
    {        
        $query = "SELECT * FROM garage WHERE plate = '".$_POST['plate']."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) 
        {
            echo "avaible";            
        } 
        else
        {
            if (session_status() != PHP_SESSION_ACTIVE)
            {
                session_start();
            }
            $end_time = time() + $_POST['hours'] * 3600;
            $query = "INSERT INTO garage SET brand = '".$_POST['brand']."', model = '".$_POST['model']."', plate = '".$_POST['plate']."', owner = '".$_POST['owner']."', end_time = ".$end_time."";
            $result = $conn->query($query);

            $query = "UPDATE accounts SET total_input = total_input + 1 WHERE id = ".$_SESSION['account_id']."";
            $result = $conn->query($query);

            $query = "UPDATE management SET total_cash = total_cash + 200";
            $result = $conn->query($query);
        }
    }
    else if ($_POST['type'] == "vehicle_delete")
    {     
        if (session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
        }   
        $query = "SELECT * FROM garage WHERE plate = '".$_POST['plate']."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) 
        {
            $query = "DELETE FROM garage WHERE plate = '".$_POST['plate']."'";
            $result = $conn->query($query);

            $query = "UPDATE accounts SET total_output = total_output + 1 WHERE id = ".$_SESSION['account_id']."";
            $result = $conn->query($query);
        } 
        else
        {
            echo "not_found";            
        }
    }
    else if ($_POST['type'] == "change_theme")
    {        
        if (session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        if ($_POST['theme'] == 1)
        {
            $query = "UPDATE accounts SET theme_mode = 1 WHERE id = '".$_SESSION['account_id']."'";
            $result = $conn->query($query);
            if ($result->num_rows < 1)
            {
                echo "mysql";             
            }
        }     
        else
        {
            $query = "UPDATE accounts SET theme_mode = 0 WHERE id = '".$_SESSION['account_id']."'";
            $result = $conn->query($query);
            if ($result->num_rows < 1)
            {
                echo "mysql";             
            } 
        }         
    }
    else if ($_POST['type'] == "create_account")
    {     
        $hash = hash('sha256', $_POST['password']);           
        $query = "INSERT INTO accounts SET username = '".$_POST['username']."', password = '".$hash."', admin_level = ".$_POST['admin_level']."";
        $result = $conn->query($query);
        if ($result->num_rows < 1)
        {
            echo "mysql";             
        }         
    }
    $conn->close();
}



?>