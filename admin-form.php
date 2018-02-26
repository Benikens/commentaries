<?php
require_once('custom-functions.php');
$type = $timeframe = $commentary = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $type = test_input($_POST["type"]);
  $timeframe = test_input($_POST["timeframe"]);
  $month = test_input($_POST["month"]);
  $year = test_input($_POST["year"]);
  if(isset($_FILES['commentary'])){
    $uploaddir = '/var/www/html/wp-content/plugins/commentaries/'.dirLookup($type)."/".$year."/".timeframeHelper($timeframe, $month)."/";
    $uploadfile = $uploaddir . basename($_FILES['commentary']['name']);
    //ini_set('display_errors', 1); error_reporting(E_ALL);
    if (!is_dir($uploaddir)){
        mkdir($uploaddir, 0755, true);
    }
    $handle = fopen($uploadfile, 'w') or die('Cannot open file:  '.$uploadfile);

    echo '<pre>';
    if (move_uploaded_file($_FILES['commentary']['tmp_name'], $uploadfile)) {
      echo "File is valid, and was successfully uploaded.\n";
    } else {
      echo "Possible file upload attack!\n";
    }

    //echo 'Here is some more debugging info:';
    //print_r($_FILES);
    print "</pre>";
  }
}
?>

<div class="wrap">
  <h1>Commentary Uploader</h1>
<form method='post' class='wpcf7-form default' enctype='multipart/form-data' novalidate='novalidate'>
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row">
            <label>Trust</label>
          </th>
          <td>
            <select name='type' class='wpcf7-form-control wpcf7-select' aria-invalid="false">
              <option value=''>---</option>
              <option value='Active Plus Shares'>Active Plus Shares</option>
              <option value='Australian Shares'>Australian Shares</option>
              <option value='Wholesale Australian Shares'>Wholesale Australian Shares</option>
              <option value='Microcap Opportunities'>Microcap Opportunities</option>
              <option value='Shares for Income'>Shares for Income</option>
              <option value='Smaller Companies'>Smaller Companies</option>
              <option value='Volatility Alpha'>Volatility Alpha</option>
              <option value='Wealth Defender'>Wealth Defender</option>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label>Type</label>
          </th>
          <td>
            <label>
              <input type='radio' name='timeframe' value='Monthly' checked='checked' style="margin: .25em 0 .5em !important">
              <span style="margin: .25em 0 .5em !important">Monthly</span>
            </label>
            <br />
            <label>
              <input type='radio' name='timeframe' value='Quarterly' style="margin: .25em 0 .5em !important">
              <span style="margin: .25em 0 .5em !important">Quarterly</span>
            </label>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label>Date</label>
          </th>
          <td>
            <label>
              <select name="month" class="wpcf7-form-control wpcf7-select" aria-invalid="false" style="margin: .25em 0 .5em !important">
                <?php for($i=1;$i<=12;$i++){
                  $output = sprintf("%02d",$i);
                  if($output == date('m', strtotime("last month"))){
                    $selected = "selected='selected'";
                  } else {
                    $selected = " ";
                  }
                  echo "<option value='".$output."'".$selected.">".$output."</option>";
                }?>
              </select>
              <span style="margin: .25em 0 .5em !important">Month</span>
            </label>
            <br />
            <label>
              <select name="year" class="wpcf7-form-control wpcf7-select" aria-invalid="false" style="margin: .25em 0 .5em !important">
                <?php
                $curYear = date('y');
                for($i=16;$i<=$curYear;$i++){
                  $output = sprintf("%02d",$i);
                  if($output == $curYear){
                    $selected = "selected='selected'";
                  } else {
                    $selected = " ";
                  }
                  echo "<option value='".$output."'".$selected.">".$output."</option>";
                }?>
              </select>
              <span style="margin: .25em 0 .5em !important">Yeah</span>
            </label>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label>File:</label>
          </th>
          <td>
            <label>
              <input type='file' name='commentary' size='40' class='wpcf7-form-control wpcf7-file' aria-invalid='false'>
            </label>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="submit">
      <input type='submit' value='Save Changes' class='button button-primary'>
    </p>
</form>

<?php
// echo "<h2>Your Input:</h2>";
// echo $type;
// echo "<br>";
// echo $timeframe;
// echo "<br>";
// echo $month;
// echo "<br>";
// echo $year;
// echo "<br>";
// echo latestCommentary(dirLookup($type));
?>
