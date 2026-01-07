document.addEventListener("DOMContentLoaded", function () {
    const months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    function initCalendar(parentSelector) {
        // 在指定的父容器 (parent) 內查找其子元素
        const parent = document.querySelector(parentSelector);
        if (!parent) return; // 如果找不到父容器，就停止執行

        const monthYear = parent.querySelector(".month-year");
        const daysContainer = parent.querySelector(".days");
        const prevButton = parent.querySelector('.prev');
        const nextButton = parent.querySelector('.next');

        let currentDate = new Date();// 目前日曆顯示的月份
        let today = new Date();// 今天日期

        function renderCalendar(date) {
            const year = date.getFullYear();
            const month = date.getMonth();
            // getDay() → 取「星期幾（0～6）」也是從 0 開始
            const firstDay = new Date(year, month, 1).getDay();
            // getDate() → 取「當月的第幾號」
            const lastDay = new Date(year, month + 1, 0).getDate();
            // month+1, 0 代表「下個月的第 0 天」第 0 天就是「上個月的最後一天」
            monthYear.textContent = `${months[month]} ${year}`;
            daysContainer.innerHTML = '';// 先清空日曆內容

            const prevMonthLastDay = new Date(year, month, 0).getDate();
            for (let i = firstDay; i > 0; i--) {
                const dayDiv = document.createElement('div');
                dayDiv.textContent = prevMonthLastDay - i + 1;
                dayDiv.classList.add('prev-day');
                daysContainer.appendChild(dayDiv);
            }

            for (let i = 1; i <= lastDay; i++) {
                const dayDiv = document.createElement('div');
                dayDiv.textContent = i;

                const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(i).padStart(2, "0")}`;
                dayDiv.dataset.date = dateStr;

                const saved = localStorage.getItem("selectedDate");
                if (saved === dateStr) {
                    dayDiv.classList.add("selected-day");
                }

                if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    dayDiv.classList.add('today');
                }
                daysContainer.appendChild(dayDiv);
            }

            const nextMonthStartDay = 7 - new Date(year, month + 1, 0).getDay() - 1;
            for (let i = 1; i <= nextMonthStartDay; i++) {
                const dayDiv = document.createElement('div');
                dayDiv.textContent = i;
                dayDiv.classList.add('next-day');
                daysContainer.appendChild(dayDiv);
            }

        }

        prevButton.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });

        nextButton.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });

        daysContainer.addEventListener("click", function (e) {
            const target = e.target;
            if (!target.dataset.date) return;
            // 如果這個東西沒有 data-date，就不是日期格子 → 不處理。

            daysContainer.querySelectorAll(".selected-day").forEach(d => {
                d.classList.remove("selected-day");
            });
            // 把之前選過的黃色 .selected-day 全部移除

            target.classList.add("selected-day");
            // 讓現在點到的格子變成黃色

            // 存起來
            localStorage.setItem("selectedDate", target.dataset.date);

            // 呼叫 diet.js 的渲染函式

            if (typeof renderFoodListByDate === "function") {
                renderFoodListByDate(target.dataset.date);
            }

            if (typeof renderWaterByDate === "function") {
                renderWaterByDate(target.dataset.date);
            }

            if (typeof renderSportListByDate === "function") {
                renderSportListByDate(target.dataset.date);
            }

        });

        renderCalendar(currentDate);


    }

    initCalendar(".desktop-calendar");
    initCalendar(".modal-calendar");

    // ----------------------------------narbar日期-----------------------
    function NavDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, "0");
        const day = String(today.getDate()).padStart(2, "0");

        const navyear = document.querySelector("#navyear");
        const navday = document.querySelector("#navday");
        navyear.textContent = `${year}`;
        navday.textContent = `${month}${day}`;
    }
    NavDate();
});


