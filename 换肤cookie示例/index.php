<?php 
// print_r($_COOKIE);
if(empty($_COOKIE)){
    $skin = 'bg.png';
}else{
    $skin = $_COOKIE['skin'];
}
if(!empty($_GET)){
    // print_r($_GET);
    $skinType = $_GET['skin'];
    switch($skinType){
        case 'none':
            $skin = 'bg.png';
            break;
        case 'a':   
            $skin = "a.png";
            break;
        case 'b':
            $skin = "b.png";
            break;
        default:
            $skin = "bg.png";
            break;
    }
    setcookie('skin',$skin,time()+3600*30*10);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    *{
        margin:0;
        padding:0;
    }
    html,body{
        height:100%;        
    }
    body{
        background:url(./skin/<?php echo $skin;?>) no-repeat center center;
        background-size:cover;
    }
    ul{
        list-style:none;
        display:flex;
        justify-content:flex-end;
    }
    ul a{
        color:red;
        text-decoration:none;
        margin:10px;
    }
    </style>
</head>
<body>
    <ul>
        <li>
            <a href="./index.php?skin=none">无背景</a>
        </li>
        <li>
            <a href="./index.php?skin=a">A主题</a>
        </li>
        <li>
            <a href="./index.php?skin=b">B主题</a>
        </li>
    </ul>
</body>
</html>