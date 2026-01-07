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
if($check_result->num_rows ===0){
    session_destroy();
    header("Location: index_notReg.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>管好你自己</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/color_font.css">
    <link rel="stylesheet" href="./css/diet_sport.css">
    <link rel="stylesheet" href="./css/navbar.css">
</head>

<body>
    <div class="d-flex vh-100">
        <!-- ----------------------導覽---------------------- -->
        <nav class="sidebar ">
            <div class="nav-item mt-3">
                <a><img src="./images/icons/bubbletea-color.png" alt="" width="80px" height="80px"></a>
                <a href="index.php" class="nav-home mt-3 "></a>
                <a href="diet.php" class="nav-record mt-3 active"></a>
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
                <a href="index.php" class="nav-home"></a>
                <a href="diet.php" class="nav-record active"></a>
                <a href="sport.php" class="nav-run"></a>
            </div>
            <div class="nav-date d-none">
                <div class="m-2" id="navyear"></div>
                <div id="navday"></div>
            </div>
        </nav>

        <!-- ------------------------------頂部header------------------------- -->
        <div class="flex-grow-1 vh-100 ">
            <header class="diet-topheader  bg-01">
                <div class="record d-flex h-100 align-items-center ">
                    <div class="d-flex">
                        <div class="h2">飲食紀錄</div>
                        <a href="#" class="plusbtn" data-bs-toggle="modal" data-bs-target="#plusModal"></a>
                        <a href="#" class="waterbtn" data-bs-toggle="modal" data-bs-target="#waterModal"></a>
                        <a href="#" class="calenderbtn mx-2 d-block d-md-none" data-bs-toggle="modal"
                            data-bs-target="#calendarModal"></a>
                    </div>
                </div>
            </header>

            <div class="right-content d-flex justify-content-center">
                <!-- ------------------------------日曆------------------------- -->
                <div class="d-flex flex-column calender-width">
                    <div class="calender d-none d-md-block desktop-calendar">
                        <div class="header d-flex justify-content-between align-items-center">
                            <div class="prev btn"><i class="fa-solid fa-arrow-left"></i></div>
                            <div class="month-year"></div>
                            <div class="next btn"><i class="fa-solid fa-arrow-right"></i></div>
                        </div>
                        <div class="weekdays d-flex">
                            <div class="mx-2">Sun</div>
                            <div class="mx-2">Mon</div>
                            <div class="mx-2">Tue</div>
                            <div class="mx-2">Wed</div>
                            <div class="mx-2">Thu</div>
                            <div class="mx-2">Fri</div>
                            <div class="mx-2">Sat</div>
                        </div>
                        <div class="days d-flex flex-wrap"></div>
                    </div>

                    <!-- calendarModal -->
                    <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="modal-calendar">
                                        <div class="header d-flex justify-content-between align-items-center">
                                            <div class="prev btn"><i class="fa-solid fa-arrow-left"></i></div>
                                            <div class="month-year"></div>
                                            <div class="next btn"><i class="fa-solid fa-arrow-right"></i></div>
                                        </div>
                                        <div class="weekdays d-flex">
                                            <div class="mx-2">Sun</div>
                                            <div class="mx-2">Mon</div>
                                            <div class="mx-2">Tue</div>
                                            <div class="mx-2">Wed</div>
                                            <div class="mx-2">Thu</div>
                                            <div class="mx-2">Fri</div>
                                            <div class="mx-2">Sat</div>
                                        </div>
                                        <div class="days d-flex flex-wrap"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                    <!-- ------------------------------水分--------------------------------- -->

                    <div class="d-flex justify-content-center">
                        <div class="water mt-4  d-flex flex-md-column align-items-center">
                            <div class="h2 mt-3">飲水量</div>
                            
                        </div>
                    </div>
                </div>


                <!-- ------------------------------清單------------------------- -->
                <div class="food-list d-flex flex-column align-items-center">

                </div>

            </div>

            <!-- plusModal -->
            <div class="modal fade" id="plusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-01">
                            <h5 class="modal-title" id="exampleModalLabel">飲食紀錄</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row g-2 ">
                                    <div class="col-12">
                                        <div class=" bg-07 p-3 rounded-3">
                                            <label for="" class="form-label">飲食項目</label>
                                            <input type="text" class="form-control fooditem"
                                                placeholder="請輸入飲食 ex.雞肉飯,珍珠奶茶">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-07 p-3 rounded-3 ">
                                            <label for="" class="form-label">時間</label>
                                            <div class="d-flex align-items-baseline">
                                                <input type="number" class="form-control hour" placeholder="時" max="23"
                                                    min="0">
                                                <label for="" class="form-label">：</label>
                                                <input type="number" class="form-control min" placeholder="分" max="59"
                                                    min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 ">
                                        <div class="bg-07 p-3 rounded-3">
                                            <label for="" class="form-label">總熱量</label>
                                            <input type="text" class="form-control kcal" placeholder="請輸入熱量">
                                        </div>
                                    </div>
                                    <div class="col-6 ">
                                        <div class="bg-07 p-3 rounded-3">
                                            <label for="" class="form-label">糖分</label>
                                            <input type="text" class="form-control sugar" placeholder="請輸入糖含量">
                                        </div>
                                    </div>
                                    <div class="col-6 ">
                                        <div class="bg-07 p-3 rounded-3">
                                            <label for="" class="form-label">鈉含量</label>
                                            <input type="text" class="form-control na" placeholder="請輸入鈉含量">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class=" bg-07 p-3 rounded-3">
                                            <label for="" class="form-label">上傳圖片</label>
                                            <input id="uploadInput" type="file" accept="image/*" class="form-control">

                                            <div>
                                                <div class="d-flex mt-2 mb-2 align-items-baseline">
                                                    <label class="form-label mt-3">圖片預覽</label>
                                                    <button class="btn btn-info ms-auto clearBtn">X</button>
                                                </div>
                                                <div
                                                    class="preview-area d-flex justify-content-center align-items-center rounded-3">
                                                    <img id="image" class="d-none" />
                                                    <span id="previewText" class="text-muted">預覽區</span>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            <button type="button" class="btn saveBtn" data-bs-dismiss="modal">確定</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- waterModal -->
            <div class="modal fade" id="waterModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-01">
                            <h5 class="modal-title" id="exampleModalLabel">飲水紀錄</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row g-2 ">
                                    <div class="col-12 ">
                                        <div class="bg-07 p-3 rounded-3">
                                            <label for="" class="form-label">水分</label>
                                            <input type="text" class="form-control watercc" placeholder="請輸入cc數">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            <button type="button" class="btn watersaveBtn" data-bs-dismiss="modal">確定</button>
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
    <script src="./js/addfood.js"></script>
    <script src="./js/page.js"></script>
    <script src="https://kit.fontawesome.com/513e02c78d.js" crossorigin="anonymous"></script>

</body>

</html>