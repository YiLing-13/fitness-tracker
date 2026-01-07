const Reg = document.querySelector("#register");
const account = document.querySelector("#account");
const password = document.querySelector("#password");
const nickname = document.querySelector("#nickname");
const age = document.querySelector("#age");
const height = document.querySelector("#height");
const weight = document.querySelector("#weight");
const ac_valid_text = document.querySelector("#ac_valid_text");
const pw_valid_text = document.querySelector("#pw_valid_text");

account.addEventListener("input",()=>{
    const accountInput = account.value.trim();
    
    if(accountInput.length >=5 && accountInput.length <=10){
        account.classList.remove("is-invalid");
        account.classList.add("is-valid");
        ac_valid_text.innerHTML = "";
    }else{
        account.classList.add("is-invalid");
        account.classList.remove("is-valid");
        ac_valid_text.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i>請輸入5-10位英文數字帳號`;
    }
});

password.addEventListener("input",()=>{
    const passwordtInput = password.value.trim();
    
    if(passwordtInput.length >=8 && passwordtInput.length <=12){
        password.classList.remove("is-invalid");
        password.classList.add("is-valid");
        pw_valid_text.innerHTML = "";
    }else{
        password.classList.add("is-invalid");
        password.classList.remove("is-valid");
        pw_valid_text.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i>請輸入8-12位英文數字密碼`;
    }
});


Reg.addEventListener("click",()=>{

    const formData = new FormData();

    const activity = document.querySelector("#activity").value;
    const genderEl = document.querySelector('input[name="gender"]:checked');

    formData.append("account", account.value);
    formData.append("password", password.value);
    formData.append("nickname",nickname.value);
    formData.append("gender",genderEl.value);
    formData.append("age",age.value);
    formData.append("height",height.value);
    formData.append("weight",weight.value);
    formData.append("activity",activity)

    axios.post("register.php", formData, {
        headers: { "Content-Type": "multipart/form-data" }
    })
        .then(res => {
            console.log(res.data);
            if (res.data.state === true) {
                alert("新增成功！");
                window.location.href = "index_notReg.html";
            }else{
                alert(res.data.message);
            }
        })
        .catch(err => console.error(err));
});