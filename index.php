<?php
    $connect = mysqli_connect('HOST', 'DBuser', 'DBpassword', 'DBname');
    function create()
    {
        $feed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
        $checkst = '';
        for ($i=0; $i < 6; $i++)                          
            $checkst .= substr($feed, rand(0, strlen($feed)-1), 1); 
        return $checkst;
    }
?>
<?php
if(isset($_POST['url']))
{
    if(strpos($_POST['url'], "http://") === false && strpos($_POST['url'], "https://") === false)
        echo "정확한 URL 주소를 입력해주세요.";
    else
    {
        global $connect;
        $checkst = create();
        while(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM shortcut WHERE shortcut='$checkst'")))
            $checkst = create();
        mysqli_query($connect, "INSERT INTO shortcut ( url, shortcut ) VALUES ( '".mysqli_real_escape_string($connect, $_POST[url])."', '$checkst' )");
        if($_SERVER['HTTPS'] === 'on')
            $proto = "https://";
        else
            $proto = "http://";
        echo "<a href='".$proto.$_SERVER['HTTP_HOST']."/fb/".$checkst."' target='blank'>".$proto.$_SERVER['HTTP_HOST']."/fb/".$checkst."</a>";
        exit(1);
    }
} ?>

<html>
<head>
<meta charset='utf-8'>
<title>URL Shorter!</title>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>
<?php if($_GET['md'] === 'create') { ?>
<style>
    #wrapper {
        max-width: 800px;
        text-align: center;
        box-sizing: border-box;
    }
    #wrapper p {
        text-align: left;
    }
    #wrapper input[type='text'] {
        width: 100%;
        height: 2.5em;
        padding: 0;
        font-size: 0.8em;
        text-align: center;
    }
    #wrapper input[type='submit'] {
        width: 100%;
        height: 3em;
        font-size: 1em;
        font-weight: bold;
        padding: 0;
    }
    #result {
        margin-top: 1em;
    }
</style>

<script>
    $(document).ready(function(){
        $('#create').click(function(){
            $.ajax({
                url: '<?php echo $_SERVER[PHP_SELF]; ?>',
                type: 'POST',
                data: "url="+$('#url').val(),
		async: false,
                success: function(result){
                    $('#result').empty();
                    $('#result').append(result);
                }
            })
        });
    });
</script>
<center>
<div id='wrapper'>
<h2>URL Shortcut!</h2>
<p>1. 이동 하고 싶은 URL</p>
<input type='text' id='url' placeholder='ex) https://hepstar.kr'><br><br>
<input type='submit' id='create' value='주소 생성하기'>
<div id='result'></div>
</div>
</center>
<?php 
} 
if(isset($_GET['shortcut'])) {
    $connect = mysqli_connect('HOST', 'DBuser', 'DBpassword', 'DBname');
    if(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM shortcut WHERE shortcut = '".mysqli_real_escape_string($connect, $_GET[shortcut])."'")) === 1)
    {
        $row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM shortcut WHERE shortcut = '".mysqli_real_escape_string($connect, $_GET[shortcut])."'"));
        header("Location: ".$row['url']."");
    }
    else
        echo "ERROR!<br>404 Not Found!";
} ?>
</body>
</html>
