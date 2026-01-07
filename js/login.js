const Log = document.querySelector("#login");

Log.addEventListener("click", () => {
    const usrAccount = document.querySelector("#Loginaccount").value;
    const usrPassword = document.querySelector("#Loginpassword").value;
    const errorBox = document.querySelector(".errorBox");

    axios.post("login.php", { 
        usrAccount: usrAccount, 
        usrPassword: usrPassword 
    })
        .then(res => {
            console.log(res.data);
            if (res.data.state === true) {
                window.location.href = "index.php";
            } else {
                //  errorBox.textContent = res.data.message;
                 errorBox.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i>${res.data.message}`;
            }
        })
        .catch(err => console.error(err));
});



