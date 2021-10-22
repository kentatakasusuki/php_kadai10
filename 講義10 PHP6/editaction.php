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
		<div class="col-md-2">
<h2>管理メニュー</h2>
<ul>
<li><a href="https://hystericend.sakura.ne.jp/takasusukisample2/">モデル登録</a></li>
<li><a href="https://hystericend.sakura.ne.jp/takasusukisample2/modellist.php">モデル一覧→承認</a></li>
</ul>
		</div>
		
		<div class="col-md-10">
		
		
<?
	define('PVL_DIR_COMN_PATH','./system/'); //comnフォルダまでのpath(必ず設定して下さい)
	require_once(PVL_DIR_COMN_PATH.'config/app_conf.php');
	
$id = $_POST["id"];	

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
$sql = 'update takasusukisample set name=:name,modelname=:modelname,age=:age,birthday=:birthday,bloodtype=:bloodtype,career=:career,height=:height,weight=:weight,bust=:bust,west=:west,
hip=:hip,hobby=:hobby,intro=:intro,bankcompany=:bankcompany,bankbranch=:bankbranch,banktype=:banktype,banknumber=:banknumber,email=:email where id = :value';
$stmt = $pdo -> prepare($sql);


$stmt->bindParam(':value', $id, PDO::PARAM_INT);
$stmt->bindParam(':name', $_POST['cont1'], PDO::PARAM_STR);
$stmt->bindParam(':modelname', $_POST['cont2'],  PDO::PARAM_STR);
$stmt->bindParam(':age', $_POST['cont3'],  PDO::PARAM_STR);
$stmt->bindParam(':birthday', $_POST['cont4'],  PDO::PARAM_STR);
$stmt->bindParam(':bloodtype', $_POST['cont5'], PDO::PARAM_STR);
$stmt->bindParam(':career', $_POST['cont6'],  PDO::PARAM_STR);
$stmt->bindParam(':height',$_POST['cont7'], PDO::PARAM_STR);
$stmt->bindParam(':weight',$_POST['cont9'],  PDO::PARAM_STR);
$stmt->bindParam(':bust', $_POST['cont10'], PDO::PARAM_STR);
$stmt->bindParam(':west',$_POST['cont11'], PDO::PARAM_STR);
$stmt->bindParam(':hip',$_POST['cont12'], PDO::PARAM_STR);
$stmt->bindParam(':hobby',$_POST['cont13'], PDO::PARAM_STR);
$stmt->bindParam(':intro',$_POST['cont14'], PDO::PARAM_STR);
$stmt->bindParam(':bankcompany',$_POST['cont15'], PDO::PARAM_STR);
$stmt->bindParam(':bankbranch',$_POST['cont16'], PDO::PARAM_STR);
$stmt->bindParam(':banktype',$_POST['cont17'], PDO::PARAM_STR);
$stmt->bindParam(':banknumber',$_POST['cont18'], PDO::PARAM_STR);
$stmt->bindParam(':email',$_POST['cont19'], PDO::PARAM_STR);

$stmt->execute();

    /* データベースから値を取ってきたり， データを挿入したりする処理 */

} catch (PDOException $e) {

    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);

}	

?>		
			
		
		
		<h2>モデル情報更新【完了】</h2>
		<p>情報更新完了しました。</p>
		<p>左メニューから移動してください。</p>
</div>
		
		</div>
</div>


 </main>
<footer>
</footer>
  
</body>
</html>