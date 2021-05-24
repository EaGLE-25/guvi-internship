import {fetchGet,fetchPost,showSnackbar,createFormData} from "./common.js";
import {myProfileValidator} from "./validations.js";

const logoutBtn = $(".logout-btn");
const editBtn = $(".edit-btn");
const updateBtn = $(".update-btn");
const editCancelBtn = $(".cancel-btn");

const editLogoutContainer = $(".edit-and-logout");
const updateCancelContainer = $(".update-and-cancel");

const inputFields = $(".myProfile-form input");




window.onload = (event) => {
    const headers = {
        "Authorization":`Bearer ${sessionStorage.getItem("accessToken")}`,
        "X-Uuid":`${sessionStorage.getItem("uuid")}`
    }
    fetchGet("/dist/scripts/php/myprofile.php",headers).then(res=>{
        return res.json();
    }).then(data=>{
        if(data.code>=200 && data.code<=299){
            fillInputFields(data.userProfile);
            $(".loader").addClass("hidden");
        }else{
            sessionStorage.setItem("error",data.message);
            window.location.replace("/dist/html/signin.html");
        }
    })
    .catch(e=>console.error(e));
};

logoutBtn.click(function(e){
    e.preventDefault();
    sessionStorage.removeItem("accessToken");
    sessionStorage.removeItem("email");

    window.location.replace("/dist/html/signin.html");
});

editBtn.click(function(e){
    e.preventDefault();

    const beforeEditInputFieldValues = serializeToObj(inputFields);

    goToEditMode();
    editCancelBtn.click(function(e){
        e.preventDefault();
        fillInputFields(beforeEditInputFieldValues);
        goBackFromEditMode();
    })

    updateBtn.click(function(e){
        e.preventDefault();
        const updatedUserProfile = createFormData(".myProfile-form");
    
        console.log(updatedUserProfile);
    
        const headers = {
            "Authorization":`Bearer ${sessionStorage.getItem("accessToken")}`,
            "X-Uuid":`${sessionStorage.getItem("uuid")}`
        }
    
        fetchPost("/dist/scripts/php/updateUserProfile.php",updatedUserProfile,headers).then(res=>{
            return res.json();
        })
        .then(data=>{
            if(data.code>=200 && data.code<=299){
                const errorIndingIcons =  document.querySelectorAll(".invalid-input-indicator i");

                showSnackbar(data.message,"success-snackbar");
                goBackFromEditMode();
                // remove error indicators
                errorIndingIcons.forEach(icon=>icon.remove());
                myProfileValidator.resetForm();
            }else{
                throw new Error(data.message);
            }
        })
        .catch(e=>{
            showSnackbar(e.message,"error-snackbar");
            goBackFromEditMode();
            fillInputFields(beforeEditInputFieldValues);
        })
    })
})

function fillInputFields(userProfile){
    inputFields.each(function(index,element){
        element.value = userProfile[element.name];
    })
}

function serializeToObj(inputFields){
    const obj = {};

    inputFields.each(function(index,element){
        obj[element.name] = element.value;
    });

    return obj;
}

function goToEditMode(){
    inputFields.removeAttr("disabled");

    editLogoutContainer.removeClass("show");
    editLogoutContainer.addClass("hide");
    updateCancelContainer.addClass("show");
}

function goBackFromEditMode(){
    inputFields.attr("disabled","true");

    editLogoutContainer.removeClass("hide");
    editLogoutContainer.addClass("show");
    updateCancelContainer.removeClass("show");
}