import {fetchGet,fetchPost,showSnackbar,createFormData,basePath,Operation} from "./common.js";
import {myProfileValidator} from "./validations.js";

const logoutBtn = $(".logout-btn");

const editBtn = $(".edit-btn");

const updateBtn = $(".update-btn");
const editCancelBtn = $(".cancel-btn");

const editLogoutContainer = $(".edit-and-logout");
const updateCancelContainer = $(".update-and-cancel");

const inputFields = $(".myProfile-form input");;

const updateAcc = updateOperation();


window.onload = (event) => {
    const headers = {
        "Authorization":`Bearer ${sessionStorage.getItem("accessToken")}`,
        "X-Uuid":`${sessionStorage.getItem("uuid")}`
    }
    fetchGet(`${basePath}/scripts/php/myprofile.php`,headers).then(res=>{
        return res.json();
    }).then(data=>{
        if(data.code>=200 && data.code<=299){
            fillInputFields(data.userProfile);
            $(".loader").addClass("hidden");
        }else{
            sessionStorage.setItem("error",data.message);
            window.location.replace(`${basePath}/html/signin.html`);
        }
    })
    .catch(e=>console.error(e));
};

logoutBtn.click(function(e){
    e.preventDefault();
    sessionStorage.removeItem("accessToken");
    sessionStorage.removeItem("email");

    window.location.replace(`${basePath}/html/signin.html`);
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
        if($(".myProfile-form").valid()){
            updateAcc.start();

            const updatedUserProfile = createFormData(".myProfile-form");
    
            const headers = {
                "Authorization":`Bearer ${sessionStorage.getItem("accessToken")}`,
                "X-Uuid":`${sessionStorage.getItem("uuid")}`
            }
        
            fetchPost(`${basePath}/scripts/php/updateUserProfile.php`,updatedUserProfile,headers).then(res=>{
                return res.json();
            })
            .then(data=>{
                if(data.code>=200 && data.code<=299){
                    updateAcc.end();
                    showSnackbar(data.message,"success-snackbar");
                    goBackFromEditMode();
                    myProfileValidator.resetForm();
                }else{
                    throw new Error(data.message);
                }
            })
            .catch(e=>{
                updateAcc.end();
                
                myProfileValidator.resetForm();
                showSnackbar(e.message,"error-snackbar");
            })
        }
    })
});

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

function updateOperation(){
    const operation = new Operation(updateBtn,"Updating","updating-acc-span");

    return operation;
}