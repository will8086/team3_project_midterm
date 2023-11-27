<?php

require_once("../connect.php");


if(!isset($_GET["order_id"])){
    exit;
}else{
    //有網址變數的話, 才讓網址變數變成id
    $order_id = $_GET["order_id"];
}

//針對某個東西做修改
$sql = "SELECT * FROM `Order_general` WHERE order_id = $order_id ORDER BY `user_id` ASC;";

try{
  $result = $conn -> query($sql);
  $row = $result -> fetch_assoc();
// Fetch city, district, and address data
  $city = $row["city"];
  $district = $row["district"];
  $address = $row["delivery_address"];


}catch(mysqli_sql_exception $exc){
    die("讀取失敗:" .$exc->getMessage());
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <title>修改留言</title>
</head>

<body>
    <div class="container mt-3">
        <form action="../utilities/navbar.php?webpage=orderUpdate2.php" method="post">
            <!-- 讓網址列有?id -->
            <input name="order_id" type="hidden" value="<?=$order_id?>">
            
            <div class="input-group">
                <span class="input-group-text">訂單狀態</span>
                <input name="payment_status" type="text" class="form-control" value="<?=$row["payment_status"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">會員號碼</span>
                <input name="user_id" type="text" class="form-control" value="<?=$row["user_id"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">付款方式</span>
                <input name="payment_method" type="text" class="form-control" value="<?=$row["payment_method"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">運送方式</span>
                <input name="delivery_method" type="text" class="form-control" value="<?=$row["delivery_method"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">運送狀態</span>
                <input name="delivery_status" type="text" class="form-control" value="<?=$row["delivery_status"]?>">
            </div>


            <!-- <form action="./doInsert02.php" method="post">
                    <label for="city">縣市：</label>
                    <select name="city[]" id="city">
                        <option value="">請選擇縣市</option>
                        <option value="台北市">台北市</option>
                        <option value="新北市">新北市</option>
                        <option value="桃園市">桃園市</option>
                        <option value="新竹縣">新竹縣</option>
                        <option value="苗栗縣">苗栗縣</option>
                        <option value="臺中市">臺中市</option>
                        <option value="彰化縣">彰化縣</option>
                        <option value="南投縣">南投縣</option>
                        <option value="雲林縣">雲林縣</option>
                        <option value="嘉義縣">嘉義縣</option>
                        <option value="臺南市">臺南市</option>
                        <option value="高雄市">高雄市</option>
                        <option value="屏東縣">屏東縣</option>
                        <option value="宜蘭縣">宜蘭縣</option>
                        <option value="花蓮縣">花蓮縣</option>
                        <option value="臺東縣">臺東縣</option>
                        <option value="澎湖縣">澎湖縣</option>
                        <option value="金門縣">金門縣</option>
                        <option value="連江縣">連江縣</option>
                        <option value="基隆市">基隆市</option>
                        <option value="新竹市">新竹市</option>
                        <option value="嘉義市">嘉義市</option>
                    </select>

                    <label for="district">區域：</label>
                    <select name="district[]" id="district">
                        <option value="">請選擇區域</option>
                    </select>

                    <label for="address">地址：</label>
                    <input name="address[]" type="text" id="address" value="<?=$row["delivery_address"]?>">

                </form> -->

            
            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-info">送出</button>
            </div>
        </form>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>

    <!-- <script>
        // 將台北市預設選取
        var citySelect = document.getElementById("city");
        // citySelect.value = "台北市";


        // 根據預設的縣市選項，選取該縣市對應的區域選項
        var districtSelect = document.getElementById("district");


        //selectedCity 選擇的縣市
        // var selectedCity = citySelect.value;
        var districts = {
            "台北市": ["100中正區", "103大同區", "104中山區", "105松山區", "106大安區", "108萬華區", "110信義區", "111士林區", "112北投區", "114內湖區", "115南港區", "116文山區"],
            "新北市": ["220板橋區", "237三峽區", "242新莊區", "234永和區", "235中和區", "236土城區", "238樹林區", "239鶯歌區", "241三重區",
                "247蘆洲區", "248五股區", "243泰山區", "244林口區", "249八里區", "251淡水區", "252三芝區", "253石門區",
                "208金山區", "207萬里區", "221汐止區", "224瑞芳區", "228貢寮區", "226平溪區", "227雙溪區",
                "231新店區", "222深坑區", "223石碇區", "232坪林區", "233烏來區"],
            "基隆市": ["200仁愛區", "201信義區", "202中正區", "203中山區", "204安樂區", "205暖暖區", "206七堵區"],
            "宜蘭縣": ["261頭城鎮", "262礁溪鄉", "263壯圍鄉", "264員山鄉", "265羅東鎮", "266三星鄉", "267大同鄉", "268五結鄉", "269冬山鄉", "270蘇澳鎮", "272南澳鄉"],
            "新竹市": ["300東區", "300北區", "300香山區"],
            "新竹縣": ["310竹東鎮", "302竹北市", "305新埔鎮", "306關西鎮", "303湖口鄉", "304新豐鄉", "307芎林鄉", "308橫山鄉", "314北埔鄉", "308寶山鄉", "315峨眉鄉", "313尖石鄉", "311五峰鄉"],
            "桃園市": ["320中壢區", "324平鎮區", "325龍潭區", "326楊梅區", "327新屋區", "328觀音區", "330桃園區", "333龜山區", "334八德區", "335大溪區", "336復興區", "337大園區", "338蘆竹區"],
            "苗栗縣": ["360苗栗市", "351頭份市", "350竹南鎮", "356後龍鎮", "357通霄鎮", "358苑裡鎮", "369卓蘭鎮", "361造橋鄉", "368西湖鄉", "362頭屋鄉", "363公館鄉", "366銅鑼鄉", "367三義鄉", "364大湖鄉", "354獅潭鄉", "365泰安鄉"],
            "臺中市": ["400中區", "401東區", "402南區", "403西區", "404北區", "406北屯區", "407西屯區", "408南屯區", "411太平區", "412大里區", "413霧峰區", "414烏日區", "420豐原區", "421后里區", "422石岡區", "423東勢區", "424和平區", "426新社區", "427潭子區", "428大雅區", "429神岡區", "432大肚區", "433沙鹿區", "434龍井區", "435梧棲區", "436清水區", "437大甲區", "438外埔區", "439大安區"],
            "彰化縣": ["500彰化市", "510員林市", "508和美鎮", "505鹿港鎮", "514溪湖鎮", "526二林鎮", "520田中鎮", "521北斗鎮", "512永靖鄉", "513埔心鄉", "511社頭鄉", "516永康鄉", "516埔鹽鄉", "515大村鄉", "528芳苑鄉", "525竹塘鄉", "525竹塘鄉", "524溪州鄉", "504秀水鄉", "527大城鄉", "506福興鄉", "507線西鄉", "503花壇鄉", "502芬園鄉", "509伸港鄉", "511社頭鄉", "522田尾鄉", "520田中鄉", "523埤頭鄉", "513埔心鄉", "516埔鹽鄉", "515大村鄉", "528芳苑鄉", "530二水鄉"],
            "南投縣": ["540南投市", "545埔里鎮", "542草屯鎮", "557竹山鎮", "552集集鎮", "551名間鄉", "558鹿谷鄉", "541中寮鄉", "555魚池鄉", "544國姓鄉", "553水里鄉", "556義鄉", "546仁愛鄉"],
            "嘉義市": ["600東區", "600西區"],
            "嘉義縣": ["612太保市", "613朴子市", "625布袋鎮", "622大林鎮", "621民雄鄉", "623溪口鄉", "616新港鄉", "615六腳鄉", "614東石鄉", "624義竹鄉", "611鹿草鄉", "608水上鄉", "606中埔鄉", "604竹崎鄉", "603梅山鄉", "602番路鄉", "607大埔鄉", "605阿里山鄉"],
            "雲林縣": ["640斗六市", "630斗南鎮", "632虎尾鎮", "648西螺鎮", "633土庫鎮", "651北港鎮", "647莿桐鄉", "643林內鄉", "646古坑鄉", "631大埤鄉", "637崙背鄉", "649二崙鄉", "638麥寮鄉", "635東勢鄉", "634褒忠鄉", "636台西鄉", "655元長鄉", "654四湖鄉", "653口湖鄉", "652水林鄉"],
            "台南市": ["700中西區", "701東區", "702南區", "704北區", "708安平區", "709安南區", "710永康區", "711歸仁區", "712新化區", "713左鎮區", "714玉井區", "715楠西區", "716南化區", "717仁德區", "718關廟區", "719龍崎區", "720官田區", "721麻豆區", "722佳里區", "723西港區", "724七股區", "725將軍區", "726學甲區", "727北門區", "730新營區", "731後壁區", "732白河區", "733東山區", "734六甲區", "735下營區", "736柳營區", "737鹽水區", "741善化區", "742大內區", "743山上區", "744新市區", "745安定區"],
            "高雄市": ["800新興區", "801前金區", "802苓雅區", "803鹽埕區", "804鼓山區", "805旗津區", "806前鎮區", "807三民區", "811楠梓區", "812小港區",
                "813左營區", "814仁武區", "815大社區", "820岡山區", "821路竹區", "822阿蓮區", "823田寮區",
                "824燕巢區", "825橋頭區", "826梓官區", "827彌陀區", "828永安區", "829湖內區", "830鳳山區", "831大寮區", "832林園區", "833鳥松區", "840大樹區", "842旗山區", "843美濃區", "844六龜區", "845內門區", "846杉林區", "847甲仙區", "848桃源區", "849那瑪夏區", "851茂林區", "852茄萣區"],
            "澎湖縣": ["880馬公市", "881西嶼鄉", "882望安鄉", "883七美鄉", "884白沙鄉", "885湖西鄉"],
            "屏東縣": ["900屏東市", "901三地門鄉", "902霧台鄉", "903瑪家鄉", "904九如鄉", "905里港鄉", "906高樹鄉", "907鹽埔鄉",
                "908長治鄉", "909麟洛鄉", "911竹田鄉", "912內埔鄉", "913萬丹鄉", "920潮州鎮", "921泰武鄉",
                "922來義鄉", "923萬巒鄉", "924崁頂鄉", "925新埤鄉", "926南州鄉", "927林邊鄉", "928東港鎮", "929琉球鄉", "931佳冬鄉", "932新園鄉", "940枋寮鄉", "941枋山鄉", "942春日鄉", "943獅子鄉", "944車城鄉", "945牡丹鄉", "946恆春鎮", "947滿州鄉"],
            "台東縣": ["950台東市", "951綠島鄉", "952蘭嶼鄉", "953延平鄉", "954卑南鄉", "955鹿野鄉", "956關山鎮", "957海端鄉", "958池上鄉", "959東河鄉", "961成功鎮", "962長濱鄉", "963太麻里鄉", "964金峰鄉", "965大武鄉", "966達仁鄉", "951綠島鄉", "952蘭嶼鄉"],
            "花蓮縣": ["970花蓮市", "971新城鄉", "972秀林鄉", "973吉安鄉", "974壽豐鄉", "975鳳林鎮", "976光復鄉", "977豐濱鄉", "978瑞穗鄉", "979萬榮鄉", "981玉里鎮", "982卓溪鄉", "983富里鄉"],
            "金門縣": ["893金城鎮", "891金沙鎮", "892金湖鎮", "890金寧鄉", "894烈嶼鄉", "896烏坵鄉"],
            "連江縣": ["209南竿鄉", "210北竿鄉", "211莒光鄉", "212東引鄉"],

            // 其他縣市的區域資料...
        };
        citySelect.addEventListener("change", (e) => {
            let cityed = e.target.value;

            if (cityed === "") {
                // 如果縣市沒有選擇，顯示請選擇區域選項
                districtSelect.innerHTML = "<option value=''>請選擇區域</option>";
            } else {

                districtSelect.innerHTML = "<option value=''>請選擇區域</option>";
                // 根據選擇的縣市，動態生成該縣市的區域選項
                var cityDistricts = districts[cityed];
                for (var i = 0; i < cityDistricts.length; i++) {
                    var option = document.createElement("option");
                    option.text = cityDistricts[i];
                    option.value = cityDistricts[i];
                    districtSelect.add(option);
                }
            }

        });


    // districtSelect.innerHTML = ""; // 清空區域選項

    // if (selectedCity === "") {
    //     // 如果縣市沒有選擇，顯示請選擇區域選項
    //     districtSelect.innerHTML = "<option value=''>請選擇區域</option>";
    // } else {
    //     // 根據選擇的縣市，動態生成該縣市的區域選項
    //     var cityDistricts = districts[selectedCity];
    //     for (var i = 0; i < cityDistricts.length; i++) {
    //         var option = document.createElement("option");
    //         option.text = cityDistricts[i];
    //         option.value = cityDistricts[i];
    //         districtSelect.add(option);
    //     }
    // }

    // console.log(cityDistricts);
    </script> -->



</body>

</html>
