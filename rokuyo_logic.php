<link rel="stylesheet" type="text/css" href="../view/static/style.css">
<?php
/**
 * フォームから受け取った値をバリデーションチェックし、例外処理などを書いたプログラム
 *　用意してあるcsvは ///１９００年１月１日から２１００年１２月３１日\\\ 分までです
 * @since 1.0.0
 * @param
 */

//新暦と旧暦の記念日を出力　jsonで　何月何日でボタンを押すと検索　 日付をキーに　記念日を配列でデータ化する
$year = $_GET["target_year"];
$month = $_GET["target_month"];
$day = $_GET["target_day"];

if (strlen($month) == 1) {
    $month = "0" . $month;
}
if (strlen($day) == 1) {
    $day = "0" . $day;
}

$year = mb_convert_kana($year, "n");
$month = mb_convert_kana($month, "n");
$day = mb_convert_kana($day, "n");
$str = $year . "/" . $month . "/" . $day;//フォームからの入力を代入する
$len = mb_strlen($str, "UTF-8");//文字の長さ（バイトコード）を返す　全角半角も関係なく１文字
$wdt = mb_strwidth($str, "UTF-8");//文字列の幅を返す　半角は１、全角は２
$csv_strings = file_get_contents("../csv/" . $year . ".csv");//フォームに入力された西暦と一致するcsvファイルを開いた中身が代入される
$csv_array = explode("\n", $csv_strings);//改行で文字列を配列にする

if(is_numeric(str_replace("/","",$str))&& checkdate($month,$day,$year) && $year > 1899 && $year < 2101){
    foreach ($csv_array as $value) {
        $year_month_day = explode(",", $value);
        var_dump($value);
        if ($str == $year_month_day[0] && $len == $wdt)
        {
            echo "<div class='php_block'><h1 class='return'>旧暦 $year_month_day[1]<p>六曜は$year_month_day[2]</p></h1></div>";
            break;
        }
    }
}
else {
    echo "<h1 class='error'>正しい数値を入力してください</h1>";
}
?>

<form action="rokuyo_logic.php" method="get" class="form-example">
    <div class="form-example">
        <h2>下の入力欄に日付を入力してください 例:2000/01/02</h2>
        <input maxlength="4" type="tel" name="target_year" class="text_field">
        <label>/</label>
        <input maxlength="2" type="tel" name="target_month" class="text_field">
        <label>/</label>
        <input maxlength="2" type="tel" name="target_day" class="text_field">
        <input type="submit" value="計算する！">
    </div>
</form>

<?php
