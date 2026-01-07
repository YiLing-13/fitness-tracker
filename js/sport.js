const saveBtn = document.querySelector("#saveBtn");
const sportlist = document.querySelector(".sport-list");
const weightRadios = document.querySelector("#weightRadios");
const cardioRadios = document.querySelector("#cardioRadios");
const SportItemAdd = document.querySelector("#sport-item-add");
const SportItemRemove = document.querySelector(".sport-item-remove");
const SportItems = document.querySelector("#sportitems");


// ------------------初始化-----------------------------------------
const hour = document.querySelector(".hour");
const min = document.querySelector(".min");
const kcal = document.querySelector(".kcal");
// const SportTextarea = document.querySelector("#SportTextarea");
const plusBtn = document.querySelector(".plusbtn");


function resetPreview() {
    document.querySelector("#weightRadios").checked = true;
    document.querySelector("#cardioRadios").checked = false;

    kcal.value = "";
    hour.value = "";
    min.value = "";
    SportItems.innerHTML = `
        <div class="d-flex align-items-center gap-2">
            <input type="text" class="form-control items" placeholder="ex.二頭肌.跑步">
            <input type="text" class="form-control sets" placeholder="10下/1組">
            <button class="btn sport-item-remove"></button>
        </div>
    `;
}

plusBtn.addEventListener("click", () => {
    resetPreview();
});

// --------------------------------------time-------------------------
let hourVal = hour.value;
let minvVal = min.value;

function render() {
    hour.value = String(hourVal);
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
        minvVal = 60;
    } else if (minvVal <= 0) {
        minvVal = 0;
    }
    render();
});

// ------------------新增項目-----------------------------------------
SportItemAdd.addEventListener("click", () => {
    const newRow = document.createElement("div");
    newRow.classList.add("d-flex", "align-items-center", "gap-2", "mt-1");

    newRow.innerHTML =
        `
    <input type="text" class="form-control items" placeholder="ex.二頭肌.跑步">
    <input type="text" class="form-control sets" placeholder="10下/1組">
    <button class="btn sport-item-remove"></button>
    `
    SportItems.appendChild(newRow);
});


// ------------------移除項目-----------------------------------------
document.addEventListener("click", (e) => {
    // console.log(e.target);
    if (e.target.classList.contains("sport-item-remove")) {
        e.target.parentElement.remove();
    }
});


// ------------------------------ADD--------------

saveBtn.addEventListener("click", () => {
    const selectedDate = localStorage.getItem("selectedDate");
    const today = new Date();
    const defaultDate = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, "0")}-${String(today.getDate()).padStart(2, "0")}`;
    const finalDate = selectedDate || defaultDate;// 如果 selectedDate 沒有，就用 defaultDate

    const sportType = document.querySelector('input[name="sportType"]:checked')?.value;

    const rows = document.querySelectorAll("#sportitems .items");

    let sportItems = [];

    rows.forEach(itemInput => {
        const row = itemInput.closest("div") || itemInput.parentElement;
        const setInput = row.querySelector(".sets");

        const itemVal = itemInput.value.trim();
        const setVal = setInput?.value.trim();

        if (itemVal) {
            sportItems.push({
                item: itemVal,
                set: setVal || ""
            });
        }
    });

    const formData = new FormData();

    formData.append("id", Date.now());
    formData.append("date", finalDate);
    formData.append("sportType", sportType);
    formData.append("hour", hour.value);
    formData.append("min", min.value);
    formData.append("kcal", kcal.value);
    formData.append("sport_items", JSON.stringify(sportItems));

    axios.post("addSport.php", formData, {
        // headers: { "Content-Type": "multipart/form-data" }
    })
        .then(res => {
            console.log(res.data);
            if (res.data.state === true) {

                alert("新增成功！");
                renderSportListByDate(finalDate);

            } else {
                alert("新增失敗：" + res.data.message);
            }
        })
        .catch(err => console.error(err));
});


// ------------------------------------渲染卡片
function renderSportCard(item) {

    const itemsArr = JSON.parse(item.sport_items || "[]");
    let itemHTML = "";

    itemsArr.forEach(i => {
        itemHTML += `<div class="d-flex align-items-center"><span class="mx-2" style="font-size: 10px;">●</span>${i.item} - ${i.set}</div>`;
    });

    const isWeight = item.sport_type === "weight";
    const bgClass = isWeight ? "bg-01" : "bg-02"
    const title = isWeight ? "重訓" : "有氧";

    const minStr = String(item.total_min).padStart(2, "0");

    const newRow = document.createElement("div");
    newRow.classList.add("sport-card", "d-flex", "mb-3", bgClass, "text-white");
    newRow.dataset.id = item.id;
    newRow.dataset.type = item.sport_type;
    newRow.innerHTML =
        `
        <div class="col-12">
            <div class="d-flex align-items-center">
                <div class="sporttitle mx-2">${title}</div>
                <div class="sporttime  mx-2">${item.total_hour} <span class="h6">h</span> ${minStr} <span class="h6">m</span></div>
                <div class="sportkcal mx-2">${item.total_kcal} <span class="h6">kcal</span></div>
                <button class="btn sport-list-remove ms-auto"></button>
            </div> 
            <div class="">
                <div class="items_sets mt-2">${itemHTML}</div>
            </div>
        </div>
        
    `
    sportlist.appendChild(newRow);
    addButtonVisibility();
}

// 刪除
sportlist.addEventListener("click", (e) => {
    const SportlistRemove = e.target.closest(".sport-list-remove");
    if (!SportlistRemove) return;

    const card = SportlistRemove.closest(".sport-card");// 找出你按的是哪一張卡片

    const id = Number(card.dataset.id);// 取出這張卡片的 id

    axios.post("DelSport.php", { id })
        .then(res => {
            if (res.data.state === true) {
                card.remove();
                addButtonVisibility();
            } else {
                alert("刪除失敗：" + res.data.message);
            }
        })
        .catch(err => console.error(err));

});

// 換日期
function renderSportListByDate(date) {
    // 清空畫面
    sportlist.innerHTML = "";

    axios.get(`getSport.php?date=${date}`)
        .then(res => {
            console.log("getSport 回傳：", res.data);
            res.data.forEach(item => renderSportCard(item));
        })
        .catch(err => console.error(err));
}

function addButtonVisibility() {
    const weightRadios = document.querySelector("#weightGroup");
    const cardioRadios = document.querySelector("#cardioGroup");

    const isWeight = document.querySelector('.sport-card[data-type="weight"]') !== null;
    const isCardio = document.querySelector('.sport-card[data-type="cardio"]') !== null;

    plusBtn.classList.remove('d-none');
    weightRadios.classList.remove('d-none');
    cardioRadios.classList.remove('d-none');

    if (isWeight && isCardio) {
        plusBtn.classList.add('d-none');
        return;
    }

    if (isWeight && !isCardio) {
        weightRadios.classList.add('d-none');
        return;
    }

    if (!isWeight && isCardio) {
        cardioRadios.classList.add('d-none');
        return;

    }

}













