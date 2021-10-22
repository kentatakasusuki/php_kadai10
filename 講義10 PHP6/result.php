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

<?
	define('PVL_DIR_COMN_PATH','./system/'); //comnフォルダまでのpath(必ず設定して下さい)
	require_once(PVL_DIR_COMN_PATH.'config/app_conf.php');

$girlid=$_GET["girlid"];

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

$stmt = $pdo->query("SELECT * FROM girllist LEFT OUTER JOIN shoplist ON girllist.girllist_shopid = shoplist.shoplist_id where `girllist_id` = $girlid");
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data2"][]=$row;
}
//投票する。

$sql3 = "update vote set vote_today = vote_today +1 where `vote_girlid` = $girlid";
$pdo->query($sql3);

$sql4 = "update vote set vote_all = vote_all +1 where `vote_girlid` = $girlid";
$pdo->query($sql4);

//個人のデータをとる。
$stmt2 = $pdo->query("SELECT * FROM vote where `vote_girlid` = $girlid");
while($row = $stmt2 -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data3"][]=$row;
}
//全体のデータをとる。

$sql5 = "select SUM(vote_today) from vote";
$sum_today = $pdo->query($sql5);
while($row2 = $sum_today -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data4"][]=$row2;
}	

$sql6 = "select SUM(vote_all) from vote";
$sum_today = $pdo->query($sql6);
while($row3 = $sum_today -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data5"][]=$row3;
}	
//パーセント処理。
$today_per = $arg["data3"][0]["vote_today"] / $arg["data4"][0]["SUM(vote_today)"] *100;
$today_all = $arg["data3"][0]["vote_all"] / $arg["data5"][0]["SUM(vote_all)"] *100;
//個人順位をとる。
$sql7 = "SELECT vote_id,vote_girlid,vote_today,vote_all,(SELECT COUNT(*) + 1 FROM vote AS vote2 WHERE vote2.vote_today > vote.vote_today) AS RANK
FROM vote where `vote_girlid` = $girlid ORDER BY vote_today";
$ranktoday = $pdo->query($sql7);
while($row4 = $ranktoday -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data6"][]=$row4;
}	

$sql8 = "SELECT vote_id,vote_girlid,vote_today,vote_all,(SELECT COUNT(*) + 1 FROM vote AS vote2 WHERE vote2.vote_all > vote.vote_all) AS RANK
FROM vote where `vote_girlid` = $girlid ORDER BY vote_all";
$rankall = $pdo->query($sql8);
while($row5 = $rankall -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data7"][]=$row5;
}	
//全体順位をとる。
$sql9 = "select count(*) from vote";
$rankall2 = $pdo->query($sql9);
while($row6 = $rankall2 -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data8"][]=$row6;
}
$score=0;
//判定を出す。
switch ($today_per) {
	case $today_per  > 30 && $today_per <= 100:
		$today_per_result ="S";
		$score = $score +5 ;
		break;
	case $today_per  > 15 && $today_per <= 30:
		$today_per_result ="A"; 
		$score = $score +3 ;
		break;
	case $today_per  > 8 && $today_per <= 15:
		$today_per_result ="B";
		$score = $score +2 ;		
		break;
	case $today_per  > 0 && $today_per <= 8:
		$today_per_result ="C"; 
		$score = $score +1 ;
		break;
}

switch ($today_all) {
	case $today_all  > 30 && $today_all <= 100:
		$today_all_result ="S";
				$score = $score +5 ;
		break;
	case $today_all  > 15 && $today_all <= 30:
		$today_all_result ="A"; 
				$score = $score +3 ;
		break;
	case $today_all  > 8 && $today_all <= 15:
		$today_all_result ="B"; 
				$score = $score +2 ;	
		break;
	case $today_all  > 0 && $today_all <= 8:
		$today_all_result ="C"; 
				$score = $score +1 ;
		break;
}



switch ($arg["data6"][0]["RANK"]) {
	case $arg["data6"][0]["RANK"]  > 0 && $arg["data6"][0]["RANK"] <= $arg["data8"][0]["count(*)"] * 0.13:
		$today_rank_result ="S"; 
		$score = $score +5 ;
		break;
	case $arg["data6"][0]["RANK"]  > $arg["data8"][0]["count(*)"] * 0.13 && $arg["data6"][0]["RANK"] <= $arg["data8"][0]["count(*)"] * 0.5:
		$today_rank_result ="A"; 
						$score = $score +3 ;
		break;
	case $arg["data6"][0]["RANK"]  > $arg["data8"][0]["count(*)"] * 0.5 && $arg["data6"][0]["RANK"] <= $arg["data8"][0]["count(*)"] * 0.87:
		$today_rank_result ="B"; 
						$score = $score +2 ;
		break;
	case $arg["data6"][0]["RANK"]  > $arg["data8"][0]["count(*)"] * 0.87 && $arg["data6"][0]["RANK"] <= $arg["data8"][0]["count(*)"] * 1.0:
		$today_rank_result ="C";
				$score = $score +1 ;		
		break;
}

switch ($arg["data7"][0]["RANK"]) {
	case $arg["data7"][0]["RANK"] > 0 && $arg["data7"][0]["RANK"]<= $arg["data8"][0]["count(*)"] * 0.13:
		$todayall_rank_result ="S";
		$score = $score +5 ;		
		break;
	case $arg["data7"][0]["RANK"] > $arg["data8"][0]["count(*)"] * 0.13 && $arg["data7"][0]["RANK"] <= $arg["data8"][0]["count(*)"] * 0.5:
		$todayall_rank_result ="A";
								$score = $score +3 ;
		break;
	case $arg["data7"][0]["RANK"] > $arg["data8"][0]["count(*)"] * 0.5 && $arg["data7"][0]["RANK"]<= $arg["data8"][0]["count(*)"] * 0.87:
		$todayall_rank_result ="B"; 
			$score = $score +2 ;
		break;
	case $arg["data7"][0]["RANK"]  > $arg["data8"][0]["count(*)"] * 0.87 && $arg["data7"][0]["RANK"] <= $arg["data8"][0]["count(*)"] * 1.0:
		$todayall_rank_result ="C"; 
						$score = $score +1 ;
		break;
}

						$score = $score /4 ;
switch ($score) {
	case $score > 4.2 && $score<= 5:
		$result_all ="S";
		break;
	case $score >3.5 && $score <= 4.2:
		$result_all ="A";
		break;
	case $score >2.0 && $score <= 3.5:
		$result_all ="B"; 
		break;
	case $score >0 && $score <= 2.0:
		$result_all ="C"; 
		break;
}
//右枠
$stmt10 = $pdo->query("SELECT * FROM girllist LEFT OUTER JOIN vote ON girllist.girllist_id = vote.vote_girlid LEFT OUTER JOIN shoplist ON girllist.girllist_shopid = shoplist.shoplist_id ORDER BY vote_today DESC LIMIT 0,5");
while($row = $stmt10 -> fetch(PDO::FETCH_ASSOC)) {

   $arg["data10"][]=$row;
}



} catch (PDOException $e) {

    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
}	

?>  

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 centerxy">
		<p>B専あぶのーまるちぇっく「指さし」-体験版-</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
		<p><img src="./img/logo.png" alt="" class="logo"></p>
		</div> 
		<div class="col-md-6 centerxy">
		<p>ようこそゲストさん</p>
		</div> 
		
	</div>
	<div class="row">
		<div class="col-md-12">
<ul class="navigation">
	<li>ログイン</li>
	<li><a href="index2.php">女の子登録</a></li>
</ul>
		</div>
	</div>
		<div class="row">
	<div class="col-md-4">
	<img src="./girlimg/<?=$arg["data2"][0]["girllist_filepath"]?>" alt="" class="girlimg">
	</div>
	<div class="col-md-6">
<div class="box20">
<p>選んだのは…	<?=$arg["data2"][0]["shoplist_name"]?> 　の　<?=$arg["data2"][0]["girllist_name"]?>　さんだぁぁ</p>
</div><!-- /.box20 -->
<table class="table">
	<tr>
		<th>名前</th>
		<td><?=$arg["data2"][0]["girllist_name"]?></td>
	</tr>
	<tr>
		<th>年齢</th>
		<td><?=$arg["data2"][0]["girllist_age"]?></td>
	</tr>
	<tr>
		<th>誕生日</th>
		<td><?=$arg["data2"][0]["girllist_birthday"]?></td>
	</tr>
	<tr>
		<th>血液型</th>
		<td><?=$arg["data2"][0]["girllist_bloodtype"]?></td>
	</tr>
	<tr>
		<th>サイズ</th>
		<td>身長：<?=$arg["data2"][0]["girllist_height"]?>　体重：<?=$arg["data2"][0]["girllist_heavy"]?>
		　B:　<?=$arg["data2"][0]["girllist_b"]?>　W:<?=$arg["data2"][0]["girllist_w"]?>H:<?=$arg["data2"][0]["girllist_h"]?>　</td>
	</tr>
	<tr>
		<th>趣味</th>
		<td><?=$arg["data2"][0]["girllist_hobby"]?></td>
	</tr>
	<tr>
		<th>コメント</th>
		<td><?=$arg["data2"][0]["girllist_comment"]?></td>
	</tr>
	<tr>
		<th>店舗名</th>
		<td><?=$arg["data2"][0]["shoplist_name"]?></td>
	</tr>
</table>
<button class="btn btn-primary">同伴出勤する</button>
<button class="btn btn-success">コメントを書く</button>
<a href="<?=$arg["data2"][0]["shoplist_url"]?>" class="btn btn-info">お店情報を見る</a>
<h2>判定結果</h2>

<table class="table">
	<tr>
		<th>本日の投票数</th>
		<td><?=$arg["data3"][0]["vote_today"]?>票/<?=$arg["data4"][0]["SUM(vote_today)"]?>票中（<?=$today_per?>％）
		<b><?=$today_per_result?></b>
		</td>
	</tr>
	<tr>
		<th>今年の投票数</th>
		<td><?=$arg["data3"][0]["vote_all"]?>票/<?=$arg["data5"][0]["SUM(vote_all)"]?>票中（<?=$today_all?>％）
		<b><?=$today_all_result?></b>
		</td>
	</tr>
	<tr>
		<th>本日の順位</th>
		<td>第<?=$arg["data6"][0]["RANK"]?>位/<?=$arg["data8"][0]["count(*)"]?>人中
		<b><?=$today_rank_result?></b>
		</td>
	</tr>
	<tr>
		<th>総合順位</th>
		<td>第<?=$arg["data7"][0]["RANK"]?>位/<?=$arg["data8"][0]["count(*)"]?>人中
		<b><?=$todayall_rank_result?></b>
		</td>
	</tr>
</table>
<h2>総合点…<?=$score?>点/5点満点　総合評価：<?=$result_all?></h2>
<?
switch ($result_all) {
	case "S":
?>
<p>普通に美人選んじゃうタイプ</p>
<p>あなたの美的センスは優秀です。</p>
<p>あなたが選んだ女の子は堂々と美人といっていいでしょう。</p>
<p>しかしながら…言い方を変えると、ありきたりです。</p>
<p>ライバルがたくさんいるので、ガンガン積極的に同伴・延長する必要がございますな。</p>
<p>たまには、普段気にかけないタイプを狙ってみるのも吉。</p>
<p>磨けば光る原石はすすきのにはたくさんいます。</p>
<?	break;
	case "A":
?>
<p>こましな子を狙っちゃうタイプ</p>
<p>あなたの美的センスはまぁまぁです。</p>
<p>合コンなど行ったときに、高嶺の花を狙わないで、自分の身の丈に会う女の子選んでませんか？</p>
<p>すすきのは夢の街です。お金を払えば高嶺の花も選び放題</p>
<p>自分の信じた嬢を愛するもよし、新規開拓もよし</p>
<p>たまには冒険に出かけるonepiece力が大事です。。</p>
<p>今すぐ航海に出かけましょう。</p>

<?		break;
	case "B":
	?>
<p>まぁまぁB専です。</p>
<p>美的センスはダメでも…大丈夫</p>
<p>すすきのではガンガン盛り上がったものが勝者なのです。</p>
<p>楽しいお話で嬢を盛り上げちゃってください。</p>
<p>うまくいけば、心も通える素敵なパートナーに出会えます。</p>
<p>周りとの競合性があまりない所を行くのはビジネスマンの基本。</p>
<p>一緒に行けるレストランなど決め店もしっかり把握して戦いに行きましょう。</p>
<? 
		break;
	case "C":
	?>
<p>B専確定です。おめでとうございます。</p>
<p>当サイトの趣旨にあった、素敵なユーザー様確定です。ありがとうございます。</p>
<p>ただ…原石を磨くのはあなた次第。</p>
<p>今人気がない嬢も、進化し、一躍のスターに躍り出ることは多々あります。</p>
<p>そうなれば最初に見つけたあなたが真の勝者です。</p>
<p>目いっぱいお気に入りの嬢を進化させに行きましょう。</p>
<p>ちなみに作者はいつもC判定です。</p>

<?
		break;
}
?>





	</div>
	<div class="col-md-2">
<h2>今日のランキング</h2>
<? $t=1;?>
<? foreach($arg["data10"] as $data){
?>
<div class="box21">
	<img src="./girlimg/<?=$data["girllist_filepath"]?>" alt="" class="girlimg">
<div class="box22">
<p><?=$data["girllist_name"]?></p>
<p><?=$data["shoplist_name"]?></p>
</div><!-- /.box22 -->

<div class="box23">
<p>第<?=$t?>位</p>
<p>得票数<?=$data["vote_today"]?>票</p>
</div><!-- /.box22 -->

</div><!-- /.box21 -->
<hr />
<?
$t = $t +1;
}?>
	</div>
		
		</div>


	

</div>


 </main>
<footer>
</footer>
  
</body>
</html>