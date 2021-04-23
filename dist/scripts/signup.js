let showPasswordToggle = $(".show-password-toggle");

showPasswordToggle.click((e)=>{
    let passwordInputField = $("#password");

    if(!passwordInputField[0].value){
        return;
    }

    showPasswordToggle.toggleClass("fa-eye fa-eye-slash");

    if(passwordInputField.attr("type") === "password"){
        passwordInputField.attr("type","text");
    }else{
        passwordInputField.attr("type","password");
    }
})
