const plusBtn = document.querySelector(".plusbtn");
const kal = document.querySelector(".kcal");
const fooditem = document.querySelector(".fooditem");
const hour = document.querySelector(".hour");
const min = document.querySelector(".min");
const sugar = document.querySelector(".sugar");
const na = document.querySelector(".na");
const uploadInput = document.querySelector("#uploadInput");
const previewImg = document.querySelector("#image");
const previewText = document.querySelector("#previewText");
const clearBtn = document.querySelector(".clearBtn");
const waterbtn = document.querySelector(".waterbtn");
const watersaveBtn = document.querySelector(".watersaveBtn");
const cc = document.querySelector(".cc");
const watercc = document.querySelector(".watercc");
const water = document.querySelector(".water");

//------------------------------------清除上次資料
function resetPreview() {
    kal.value = "";
    fooditem.value = "";
    hour.value = "";
    min.value = "";
    sugar.value = "";
    na.value = "";
    uploadInput.value = "";
    previewImg.src = "";
    previewImg.classList.add("d-none");
    previewText.classList.remove("d-none");
    watercc.value = "";
}

waterbtn.addEventListener("click", () => {
    resetPreview();
});

plusBtn.addEventListener("click", () => {
    resetPreview();
});

clearBtn.addEventListener("click", () => {
    resetPreview();
});

// --------------------------------------time-------------------------
let hourVal = hour.value;
let minvVal = min.value;

function render() {
    hour.value = String(hourVal).padStart(2, "0");
    min.value = String(minvVal).padStart(2, "0");
}

hour.addEventListener("input", () => {
    hourVal = Number(hour.value);

    // console.log(hourVal);
    if (hourVal > 23) {
        hourVal = 23;
    } else if (hourVal <= 0) {
        hourVal = 0;
    }
    render();
});

min.addEventListener("input", () => {
    minvVal = Number(min.value);

    if (minvVal > 60) {
        minvVal = 59;
    } else if (minvVal <= 0) {
        minvVal = 0;
    }
    render();
});


// --------------------------------------img-------------------------

uploadInput.addEventListener("change", function () {
    // 如果沒有選檔案就直接結束。
    const file = uploadInput.files[0];
    if (!file) return;

    // 讀取圖片：使用 FileReader
    const reader = new FileReader();

    // 讀取完成 → 顯示圖片
    reader.onload = function (e) {
        previewImg.src = e.target.result;
        previewImg.classList.remove("d-none");
        previewText.classList.add("d-none");
    };
    // 開始讀取圖片
    reader.readAsDataURL(file);
});

// --------------------------------------ADD-------------------------
const saveBtn = document.querySelector(".saveBtn");
const foodlist = document.querySelector(".food-list");

saveBtn.addEventListener("click", () => {

    const file = uploadInput.files[0];
    const reader = new FileReader();
    // 讀取完成 → 顯示圖片
    reader.onload = function (e) {
        const imgSrc = e.target.result;
        const selectedDate = localStorage.getItem("selectedDate");
        const today = new Date();
        const defaultDate = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, "0")}-${String(today.getDate()).padStart(2, "0")}`;
        const finalDate = selectedDate || defaultDate;// 如果 selectedDate 沒有，就用 defaultDate

        const formData = new FormData();

        formData.append("id", Date.now());
        formData.append("date", finalDate);
        formData.append("fooditem", fooditem.value);
        formData.append("hour", hour.value);
        formData.append("min", min.value);
        formData.append("sugar", sugar.value);
        formData.append("na", na.value);
        formData.append("kal", kal.value);
        formData.append("image", uploadInput.files[0]);


        axios.post("addFood.php", formData, {
            // headers: { "Content-Type": "multipart/form-data" }
        })
            .then(res => {
                console.log(res.data);
                if (res.data.state === true) {

                    alert("新增成功！");
                    renderFoodListByDate(finalDate);  // 前端畫面更新
                } else {
                    alert("新增失敗：" + res.data.message);
                }
            })
            .catch(err => console.error(err));

    };
    // 開始讀取圖片
    if (file) {
        reader.readAsDataURL(file);
    } else {
        reader.onload({ target: { result: "" } });
    }
});

// ------------------------------------畫卡片
function renderFoodCard(data) {
    const newRow = document.createElement("div");
    newRow.classList.add("food-card", "d-flex", "align-items-center", "mb-3");
    newRow.dataset.id = data.id;
    // data.id =localStorage 存起來的那個 id（Date.now() 產生的）
    // newRow.dataset.id = HTML 卡片的 data-id 屬性
    let imgHTML = "";
    const hourStr =  String(data.hour).padStart(2, "0");
    const minStr = String(data.min).padStart(2, "0");

    if (data.img && data.img.trim() !== "") {
        imgHTML = `<div class="food-img ms-auto">
                <img src="${data.img}" alt="food image">
            </div>`;
    }
    newRow.innerHTML =
        `
        <div class="d-flex flex-column h-100 justify-content-end">
            <div>
                <button class="btn food-list-remove"></button>
            </div>
            <div class="food-time">${hourStr}:${minStr}</div>
                <div class="d-flex">
                    <div class="food-sugar mt-auto">糖分:${data.sugar}g</div>
                    <div class="food-na mt-auto">鈉含量:${data.na}mg</div>
                </div>
                <div class="d-flex">
                    <div class="food-name">${data.fooditem}</div>
                    <div class="food-cal mx-4 mt-auto">${data.kal}kcal</div>
                </div>
                </div>
                    ${imgHTML}
                </div>
    `
    foodlist.appendChild(newRow);
};


// ------------------------------------刪除卡片
foodlist.addEventListener("click", (e) => {
    const removeBtn = e.target.closest(".food-list-remove");
    if (!removeBtn) return;

    const card = removeBtn.closest(".food-card");// 找出你按的是哪一張卡片
    const id = Number(card.dataset.id);// 取出這張卡片的 id

    axios.post("DelFood.php", { id })
        .then(res => {
            if (res.data.state === true) {
                card.remove();

            } else {
                alert("刪除失敗：" + res.data.message);
            }
        })
        .catch(err => console.error(err));
});


// ------------------------------------水卡片


function renderWaterCard(data) {
    const waternewRow = document.createElement("div");
    waternewRow.classList.add("d-flex", "align-items-center", "waterCard" ,"justify-content-center");
    waternewRow.dataset.id = data.id;
    waternewRow.innerHTML =
        `
    <div class="h3 cc d-flex ">
        <div>${data.water}</div> <span class="mx-3">cc</span>
        <button class="btn water-remove ms-auto"></button>
    </div>
    `
    water.appendChild(waternewRow);
}

watersaveBtn.addEventListener("click", () => {
    const selectedDate = localStorage.getItem("selectedDate");
    const today = new Date();
    const defaultDate = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, "0")}-${String(today.getDate()).padStart(2, "0")}`;
    const finalDate = selectedDate || defaultDate;// 如果 selectedDate 沒有，就用 defaultDate

    const formData = new FormData();

    formData.append("id", Date.now());
    formData.append("date", finalDate);
    formData.append("water", watercc.value);

    axios.post("addWater.php", formData, {
        // headers: { "Content-Type": "multipart/form-data" }
    })
        .then(res => {
            console.log(res.data);
            if (res.data.state === true) {

                alert("新增成功！");
                renderWaterByDate(finalDate);
            } else {
                alert("新增失敗：" + res.data.message);
            }
        })
        .catch(err => console.error(err));
});

// ------------------------------------刪除水卡片
water.addEventListener("click", (e) => {
    const removeBtn = e.target.closest(".water-remove");
    if (!removeBtn) return;

    const card = removeBtn.closest(".waterCard");// 找出你按的是哪一張卡片

    const id = Number(card.dataset.id);// 取出這張卡片的 id

    axios.post("DelWater.php", { id })
        .then(res => {
            if (res.data.state === true) {
                card.remove();
            } else {
                alert("刪除失敗：" + res.data.message);
            }
        })
        .catch(err => console.error(err));
});

// ------------------------------------換日期重畫
function renderFoodListByDate(date) {
    // 清空畫面
    foodlist.innerHTML = "";

    axios.get(`getFood.php?date=${date}`)
        .then(res => {
            res.data.forEach(item => renderFoodCard(item));  // 假設 renderFoodCard 存在
        })
        .catch(err => console.error(err));
}

function renderWaterByDate(date) {
    const cards = water.querySelectorAll(".waterCard");
    cards.forEach(c => c.remove());

    axios.get(`getWater.php?date=${date}`)
        .then(res => {
            res.data.forEach(item => renderWaterCard(item));  // 假設 renderFoodCard 存在
        })
        .catch(err => console.error(err));
}

