document.addEventListener("DOMContentLoaded",function(){
    const monthYear = document.querySelector("#month-year");
    const daysContainer = document.querySelector("#days");
    const prevButton = document.querySelector('#prev');
    const nextButton = document.querySelector('#next');

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

    let currentDate = new Date();// 目前日曆顯示的月份
    let today = new Date();// 今天日期

    function renderCalendar(date){
        const year = date.getFullYear();
        const month = date.getMonth();
        // getDay() → 取「星期幾（0～6）」也是從 0 開始
        const firstDay = new Date(year,month,1).getDay();
        // getDate() → 取「當月的第幾號」
        const lastDay = new Date(year,month + 1, 0).getDate();
        // month+1, 0 代表「下個月的第 0 天」第 0 天就是「上個月的最後一天」
        monthYear.textContent = `${months[month]} ${year}`;

        daysContainer.innerHTML = '';// 先清空日曆內容

        const prevMonthLastDay = new Date(year,month,0).getDate();
        for(let i = firstDay; i > 0; i--){
            const dayDiv = document.createElement('div');
            dayDiv.textContent = prevMonthLastDay - i + 1 ;
            dayDiv.classList.add('prev-day');
            daysContainer.appendChild(dayDiv);
        }

        for (let i = 1; i<= lastDay; i++){
            const dayDiv = document.createElement('div');
            dayDiv.textContent = i ;
            if( i === today.getDate() && month === today.getMonth() && year === today.getFullYear()){
                dayDiv.classList.add('today');
            }
            daysContainer.appendChild(dayDiv);
        }

        const nextMonthStartDay = 7 - new Date(year,month + 1,0).getDay() - 1;
        for(let i = 1; i<= nextMonthStartDay; i++){
            const dayDiv = document.createElement('div');
            dayDiv.textContent = i ;
            dayDiv.classList.add('next-day');
            daysContainer.appendChild(dayDiv);
        }
    }

    prevButton.addEventListener("click",function(){
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextButton.addEventListener("click",function(){
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
});