<?php
session_start();

if(!isset($_SESSION['account'])){
    header("Location: index_notReg.html");
    exit;
}

include "dp_open.php";
$check_account = $_SESSION['account'];
$check_sql = "SELECT account FROM `users` WHERE account = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $check_account);
$check_stmt->execute();
$check_result = $check_stmt->get_result();
if($check_result->num_rows ===0){}

$nickname = $_SESSION['nickname'] ?? '訪客';


?>


<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管好你自己</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/color_font.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <script src="https://kit.fontawesome.com/513e02c78d.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="d-flex custom-viewport-height">
        <!-- ----------------------導覽---------------------- -->
        <nav class="sidebar ">
            <div class="nav-item mt-3">
                <a href="#"><img src="./images/icons/bubbletea-color.png" alt="" width="80px" height="80px"></a>
                <a href="index.php" class="nav-home mt-3 active"></a>
                <a href="diet.php" class="nav-record mt-3"></a>
                <a href="sport.php" class="nav-run mt-3"></a>
            </div>
            <div class="nav-date d-flex flex-column justify-content-end align-items-center my-auto">
                <div class="m-2" id="navyear"></div>
                <div id="navday"></div>
            </div>
        </nav>

        <!-- 手機底部導覽 -->
        <nav class="bottom-nav d-flex flex-row justify-content-around align-items-center d-lg-none">
            <div class="bottom-nav-item flex-row">
                <a href="index.php" class="nav-home active"></a>
                <a href="diet.php" class="nav-record"></a>
                <a href="sport.php" class="nav-run"></a>
            </div>
            <div class="nav-date d-none">
                <div class="m-2" id="navyear"></div>
                <div id="navday"></div>
            </div>
        </nav>

        <div class="right-content">

            <!-- ----------------------頂部標題---------------------- -->
            <header>
                <div class="d-none d-lg-block mt-4 px-lg-3">
                    <div class="d-flex align-items-baseline">
                        <div class="title">Do Better You</div>
                        <div class="everyday"><i class="fa-solid fa-calendar-check"></i></i>每日建議</div>
                        <div class="reference"><i class="fa-solid fa-circle-exclamation"></i>僅供參考</div>
                        <div class="person ms-auto mx-3"><?= htmlspecialchars($nickname) ?>你好<i class="fa-solid fa-heart"></i></div>
                        <button class="btn loginout " id="loginout">登出</button>
                    </div>
                </div>

                <!-- 手機板標題 -->
                <div class="d-block d-lg-none ">
                    <div class="top-title d-flex align-items-baseline">
                        <div class="title">Do Better You</div>
                        <div class="person"><?= htmlspecialchars($nickname) ?>你好<i class="fa-solid fa-heart"></i></div>
                        <button class="btn loginout " id="loginout">登出</button>
                    </div>
                    <div class="d-flex align-items-baseline ">
                        <div class="everyday"><i class="fa-solid fa-calendar-check"></i></i>每日建議</div>
                        <div class="reference"><i class="fa-solid fa-circle-exclamation"></i>僅供參考</div>
                    </div>
                </div>
            </header>

            <!-- ----------------------營養區塊---------------------- -->
            <div class="container-fluid">
                <div class="row g-3 mt-lg-3">
                    <div class="col-6 col-lg-3">
                        <div
                            class="diet-item calorie-img bg-01 h-100 d-flex flex-column justify-content-between rounded-5">
                            <div class="d-flex justify-content-between p-4 mt-2">
                                <div class="h2 text-white fw-bold diet-title">卡路里<span class="d-flex mt-2 suggest" id="TDEE"></span></div>
                                <!-- <img src="./images/icons/fire-s-white.png" alt="" class="box-img d-block d-lg-none"> -->
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline p-4 ">
                                <div class="kalNum diet-number display-5"></div>
                                <div class="h4 text-white diet-unit">kcal</div>
                            </div>
                        </div>

                    </div>
                    <div class="col-6 col-lg-3">
                        <div
                            class="diet-item water-img bg-02 h-100  d-flex flex-column justify-content-between rounded-5">
                            <div class="d-flex justify-content-between p-4 mt-2">
                                <div class="h2 text-white fw-bold diet-title">水分<span class="d-flex mt-2 suggest" id="water_sug"></span></div>
                                <!-- <img src="./images/icons/water-white.png" alt="" class="box-img d-block d-lg-none"> -->
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline p-4 ">
                                <div class="waterNum diet-number display-5"></div>
                                <!-- <div class="display-5 text-white fw-bold ">1500</div> -->
                                <div class="h4 text-white diet-unit">cc</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6  col-lg-3">
                        <div
                            class="diet-item sugar-img bg-01 h-100 d-flex flex-column justify-content-between rounded-5 sugar-bgc">
                            <div class="d-flex justify-content-between p-4 mt-2">
                                <div class="h2 text-white fw-bold diet-title">糖分<span class="d-flex mt-2 suggest" id="sugar_sug"></span></div>
                                <!-- <img src="./images/icons/sugar-white.png" alt="" class="box-img d-block d-lg-none"> -->
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline p-4">
                                <div class="sugarNum diet-number display-5"></div>
                                <!-- <div class="display-5 text-white fw-bold diet-number">15</div> -->
                                <div class="h4 text-white diet-unit">g</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6  col-lg-3">
                        <div
                            class="diet-item na-img bg-02 h-100 d-flex flex-column justify-content-between rounded-5 na-bgc">
                            <div class="d-flex justify-content-between p-4 mt-2">
                                <div class="h2 text-white fw-bold diet-title">鈉含量<span class="d-flex mt-2 suggest" id="na_sug"></span></div>
                                <!-- <img src="./images/icons/na-white.png" alt="" class="box-img d-block d-lg-none"> -->
                                
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-baseline p-4">
                                <div class="naNum diet-number display-5"></div>
                                <!-- <div class="display-5 text-white fw-bold diet-number">15</div> -->
                                <div class="h4 text-white diet-unit">mg</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ----------------------運動區塊---------------------- -->
            <div class="container-fluid">
                <div class="row sport">
                    <div class="col-12 col-md-12 col-lg-8 col-xxl-8 d-none d-lg-block ">
                        <div class="sport-item bg-01 h-100 rounded-5 d-flex justify-content-end">
                            <div class="slogan-img d-flex flex-column justify-content-center  fw-900">
                                <div class="slogan h2 fw-bold ms-auto mx-4"></div>
                                <!-- <div class="slogan h2 fw-bold mt-3 ms-auto mx-4">消耗熱量降低20%喔!</div> -->
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xxl-4">
                        <div
                            class="sport-item sport-img bg-02 h-100 d-flex flex-column justify-content-between sport-bgc rounded-5">
                            <div class=" d-flex p-4 mt-2 justify-content-between ">
                                <div class="h2 fw-bold sport-title ">運動量</div>
                                <!-- <img src="./images/icons/Doodles-black.png" alt="" class="d-block d-lg-none box-img"> -->
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline p-4">
                                <div class="sportNum display-5 fw-bold sport-number"></div>
                                <div class="h4 sport-unit">kal</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <script src="https://unpkg.com/axios@1.6.7/dist/axios.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/calender.js"></script>
    <script>
        const kalNum = document.querySelector(".kalNum");
        function renderkal(data) {
            const kalnewRow = document.createElement("div");
            kalnewRow.classList.add("text-white", "fw-bold");
            kalnewRow.textContent= data.kal;
            kalNum.appendChild(kalnewRow);
        }

        const sugarNum = document.querySelector(".sugarNum");
        function rendersugar(data) {
            const sugarnewRow = document.createElement("div");
            sugarnewRow.classList.add("text-white", "fw-bold");
            sugarnewRow.textContent= data.sugar;
            sugarNum.appendChild(sugarnewRow);
        }

        const naNum = document.querySelector(".naNum");
        function renderna(data) {
            const nanewRow = document.createElement("div");
            nanewRow.classList.add("text-white", "fw-bold");
            nanewRow.textContent= data.na;
            naNum.appendChild(nanewRow);
        }

        const waterNum = document.querySelector(".waterNum");
        function renderwater(data) {
            const waternewRow = document.createElement("div");
            waternewRow.classList.add("text-white", "fw-bold");
            waternewRow.textContent= data.water;
            waterNum.appendChild(waternewRow);
        }

        const sportNum = document.querySelector(".sportNum");
        function rendersport(data) {
            const sportnewRow = document.createElement("div");
            sportnewRow.classList.add("fw-bold");
            sportnewRow.textContent= data.total_kcal;
            sportNum.appendChild(sportnewRow);
        }
        
        // 每日建議
        const TDEE_sug = document.querySelector("#TDEE");
        const water_sug = document.querySelector("#water_sug");
        const sugar_sug = document.querySelector("#sugar_sug");
        const na_sug = document.querySelector("#na_sug");
        function suggest(data){
            const gender = data.gender;
            let genderdata ;
            if(gender === "male"){
                genderdata = 1;
            }else{
                genderdata = 0;
            }
            
            const age       = Number(data.age);
            const height    = Number(data.height);
            const weight    = Number(data.weight);
            const activity  = Number(data.activity_level);
            const TDEE =  (weight*9.99) + (6.25*height) - (4.92*age) + ((166*genderdata)-161);

            const Water_min = (weight*30);
            const Water_max = (weight*40);
            const Sugar = (TDEE*0.1)/4;

            if(TDEE_sug){
                TDEE_sug.textContent = `每日建議: ${Math.round(TDEE)} kcal`;
            }
            if(Water_min && Water_max){
                water_sug.textContent = `每日建議: ${Math.round(Water_min)}  ~ ${Math.round(Water_max)}cc`;
            }
            if(Sugar){
                sugar_sug.textContent = `每日建議: ${Math.round(Sugar)} g`;
            }
            
            if(age >= 4 && age <= 8){
                na_sug.textContent = `每日建議: 1500 mg`;
            }else if(age >= 9 && age <= 13){
                na_sug.textContent = `每日建議: 1800 mg`;
            }else if(age >= 14 && age <= 18){
                na_sug.textContent = `每日建議: 2300 mg`;
            }else if(age >=19 && age < 65){
                na_sug.textContent = `每日建議: 2400 mg`;
            }else if(age >= 65){
                na_sug.textContent = `每日建議: 1500 mg 以下`;
            }else{
                na_sug.textContent = ``;
            }
        }
        
        //當日紀錄資料
        axios.get("showitem.php")
        .then(res => {
            console.log(res.data);
            renderkal(res.data);
            rendersugar(res.data);
            renderna(res.data);
            renderwater(res.data);
            rendersport(res.data)
        })
        .catch(err => console.error(err));

        // 每日建議資料
        axios.get("suggest.php")
        .then(res => {
            console.log(res.data);
            suggest(res.data);
        })
        .catch(err => console.error(err));

        // 登出
        const LoginOut = document.querySelectorAll("#loginout");
        LoginOut.forEach(out =>{
            out.addEventListener("click", () => {
            localStorage.removeItem("selectedDate");
            window.location.href = "logout.php";
        });
        })
        

        // 隨機標語
        fetch("/Fitness/js/content.json")
        .then(res => res.json())
        .then(data => {
            const randomIndex = Math.floor(Math.random()*data.length);
            const randomContent = data[randomIndex];
            document.querySelector(".slogan").textContent = randomContent.content;
        })
    </script>
</body>

</html>