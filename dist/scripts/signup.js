let showPasswordToggle = $(".show-password-toggle");
// let inputFields = $(".signup-form input");

// console.log(inputFields);

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

// $.each(inputFields,function(index,inputField){
//     $(inputField).focus(e=>{
//         const inputGroup =  $(inputField).closest(".input-group");
//         inputGroup.addClass("focus");
//     });
//     $(inputField).focusout(e=>{
//         const inputGroup =  $(inputField).closest(".input-group");
//         inputGroup.removeClass("focus");
//     });
// });