// diet-page-init.js
document.addEventListener("DOMContentLoaded", function () {
    // 這個函式專門用來「進入飲食頁面時，強制選今天」
    function initializeDietPageToToday() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, "0");
        const day = String(today.getDate()).padStart(2, "0");
        const todayStr = `${year}-${month}-${day}`;

        // 找到今天的那一格（桌面版和 modal 版都找）
        const todayCells = document.querySelectorAll(`[data-date="${todayStr}"]`);

        if (todayCells.length > 0) {
            // 移除所有舊的選取
            document.querySelectorAll(".selected-day").forEach(el => {
                el.classList.remove("selected-day");
            });

            // 把今天標成黃色
            todayCells.forEach(cell => {
                cell.classList.add("selected-day");
            });

            // 渲染今天的運動
            if (typeof window.renderSportListByDate === "function") {
                window.renderSportListByDate(todayStr);
            }

        }
    }

    // 自動執行：當這個 JS 載入時（也就是進入飲食頁面時），就選今天
    initializeDietPageToToday();
});