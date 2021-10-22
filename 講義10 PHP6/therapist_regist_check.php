<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>モデル登録</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <title></title>
    <!-- BootstrapのCSS読み込み -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="./js/bootstrap.min.js"></script>
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="./css/base.css" rel="stylesheet">
</head>
<body>
<main>
<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-12">
		
		
<?
	define('PVL_DIR_COMN_PATH','./system/'); //comnフォルダまでのpath(必ず設定して下さい)
	require_once(PVL_DIR_COMN_PATH.'config/app_conf.php');
	
$key =  substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8);	
$size = $_POST['size_1'].'('.$_POST['size_4'].')/'.$_POST['size_2'].'/'.$_POST['size_3'];
//ファイルのアップロード
$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$tempfile = $_FILES['image']['tmp_name'];
$filepath = $key . ".".$extension;
$filename = './girlimg/' .$filepath;
 
if (is_uploaded_file($tempfile)) {
    if ( move_uploaded_file($tempfile , $filename )) {
	echo $filename . "をアップロードしました。";

    } else {
        echo "ファイルをアップロードできません。";
    }
} else {
    echo "ファイルが選択されていません。";
} 
	
try {

    /* リクエストから得たスーパーグローバル変数をチェックするなどの処理 */
$_ = function($s){return $s;};//展開用
    // データベースに接続
    $pdo = new PDO("mysql:host={$_(PVL_DB_HOSTNAME)};dbname={$_(PVL_DB_DBNAME)};charset=utf8",PVL_DB_USER,PVL_DB_PASSWD,
[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
])
;

$stmt = $pdo -> prepare("INSERT INTO girllist (girllist_name,girllist_age,girllist_birthday,girllist_bloodtype,girllist_height,girllist_b,girllist_w,girllist_h,girllist_hobby,girllist_shopid,girllist_filepath,girllist_comment) VALUES (:girllist_name,:girllist_age,:girllist_birthday,:girllist_bloodtype,:girllist_height,
:girllist_b,:girllist_w,:girllist_h,:girllist_hobby,:girllist_shopid,:girllist_filepath,:girllist_comment)");
$stmt->bindParam(':girllist_name', $_POST['cont1'], PDO::PARAM_STR);
$stmt->bindParam(':girllist_age', $_POST['cont3'],  PDO::PARAM_STR);
$stmt->bindParam(':girllist_birthday', $_POST['cont4'],  PDO::PARAM_STR);
$stmt->bindParam(':girllist_bloodtype', $_POST['cont5'],  PDO::PARAM_STR);
$stmt->bindParam(':girllist_height', $_POST['cont7'], PDO::PARAM_STR);
$stmt->bindParam(':girllist_b',$_POST['cont10'], PDO::PARAM_STR);
$stmt->bindParam(':girllist_w',$_POST['cont11'],  PDO::PARAM_STR);
$stmt->bindParam(':girllist_h', $_POST['cont12'], PDO::PARAM_STR);
$stmt->bindParam(':girllist_hobby',$_POST['cont13'], PDO::PARAM_STR);
$stmt->bindParam(':girllist_shopid',$_POST['cont17'], PDO::PARAM_STR);
$stmt->bindParam(':girllist_filepath',$filepath, PDO::PARAM_STR);
$stmt->bindParam(':girllist_comment',$_POST['cont14'], PDO::PARAM_STR);

$stmt->execute();

//IDとるよ
$regid = $pdo ->lastInsertId();
//今回はサンプルなので事前の投票数はランダムにします。
$votetoday = mt_rand(300, 600);
$voteall = mt_rand(3000, 6000);


$stmt2 = $pdo -> prepare("INSERT INTO vote (vote_girlid,vote_today,vote_all) VALUES (:vote_girlid,:vote_today,:vote_all)");
$stmt2->bindParam(':vote_girlid', $regid, PDO::PARAM_STR);
$stmt2->bindParam(':vote_today', $votetoday,  PDO::PARAM_STR);
$stmt2->bindParam(':vote_all', $voteall,  PDO::PARAM_STR);

$stmt2->execute();


} catch (PDOException $e) {

    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);

}	

?>		
			
		
		
		<h2>モデル登録【完了】</h2>
		<p>登録完了しました。</p>
		<p>左メニューから移動してください。</p>
		<p><a href="./index2.php" class="btn btn-link">女の子登録に戻る</a></p>
</div>
		
		</div>
</div>


 </main>
<footer>
</footer>
  
</body>
</html>