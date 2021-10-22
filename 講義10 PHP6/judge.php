<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>モデル一覧</title>
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
<li><a href="https://hystericend.sakura.ne.jp/takasusukisample2/modellist">モデル一覧→承認</a></li>
</ul>
		</div>
		
		<div class="col-md-10">
<h2>モデル承認・非承認</h2>

<?
	define('PVL_DIR_COMN_PATH','./system/'); //comnフォルダまでのpath(必ず設定して下さい)
	require_once(PVL_DIR_COMN_PATH.'config/app_conf.php');

$id = $_GET["id"];
$flag = $_GET["flag"];


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

$sql = 'update takasusukisample set entry_flag = :entry_flag where id = :value';
$stmt = $pdo -> prepare($sql);

$stmt->bindParam(':value', $id, PDO::PARAM_INT);
$stmt->bindParam(':entry_flag', $flag, PDO::PARAM_STR);

$stmt->execute();

$stmt = $pdo->query("SELECT * FROM takasusukisample where `id` = $id");
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data2"][]=$row;
}











} catch (PDOException $e) {

    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
}	

?>  

<? if($flag == 1){
	
$to = $arg["data2"][0]["email"];
$subject = "モデル承認のお知らせ【fapeal】";
$message = <<<EOM
名前：{$arg["data2"][0]["name"]}　様

モデルのご登録ありがとうございました。
審査の結果、当サイトfapealの正式モデルとして承認いたします。

EOM;

$headers = "From: fapeal@fapeal.com";
mb_send_mail($to, $subject, $message, $headers); 

	?>
<p>このモデルを承諾しました。</p>
<p>左メニューより戻ってください。</p>
<?}else{
	
$to = $arg["data2"][0]["email"];
$subject = "モデル非承認のお知らせ【fapeal】";
$message = <<<EOM
名前：{$arg["data2"][0]["name"]}　様

モデルのご登録ありがとうございました。
審査の結果、当サイトfapealのモデル審査は不合格になりました。
理由等につきましては、お問い合わせにお答えすることはできませんのでご了承ください。

EOM;

$headers = "From: fapeal@fapeal.com";
mb_send_mail($to, $subject, $message, $headers); 
	
	?>
<p>このモデルを非承諾しました。</p>
<p>左メニューより戻ってください。</p>
<?}?>


	</div>
		
		</div>
</div>


 </main>
<footer>
</footer>
  
</body>
</html>