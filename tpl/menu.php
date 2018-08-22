<?php

//foreach($_SESSION['modules'] as $m)

function searchArray($search, $array)
{
    foreach($array as $key => $value)
    {

        if (stristr($value, $search))
        {
            return 1;
        }
    }
    return false;
}



/// add a new html list for a new menu item
?>
<ul class="nav">
    <li>
        <a href="<?=$base_url?>/dashboard">Dashboard</a>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pred (1) <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <a href="#">Exercise 1 : Uploading </a>
        </ul>
    </li>    


    <li class="dropdown">
        <a href="/settlement/index" class="dropdown-toggle" data-toggle="dropdown">Fredy <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <?php  echo '<li><a href="'.$base_url.'/settlement/index"> Exercise 1 : Uploading</a></li>' ?>
            <?php  echo '<li><a href="'.$base_url.'/crud/index"> CRUD</a></li>' ?>
        </ul>
    </li>  

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Philo <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <a href="#">Exercise 1 : Uploading </a>
        </ul>
    </li>    

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Benny <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <a href="#">Exercise 1 : Uploading </a>
        </ul>
    </li>  


     <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="<?=$base_url?>/settings/dashboard">
                    <h6>Dashboard</h6>
                    Set your dashboard here
                </a>

            </li>
            <li><a href="<?=$base_url?>/settings/change_password">Change Password</a></li>
            <li class="divider"></li>
            <li><a href="<?=$base_url?>/auth/logout"><i class="icon-signout"></i>Logout</a></li>
        </ul>
    </li>

   
</ul>
