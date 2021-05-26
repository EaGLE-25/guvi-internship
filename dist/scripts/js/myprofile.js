import {fetchGet,fetchPost,showSnackbar,createFormData,basePath,Operation} from "./common.js";
import {myProfileValidator} from "./validations.js";

const logoutBtn = $(".logout-btn");

const editBtn = $(".edit-btn");

const updateBtn = $(".update-btn");
const editCancelBtn = $(".cancel-btn");

const editLogoutContainer = $(".edit-and-logout");
const updateCancelContainer = $(".update-and-cancel");

const inputFields = $(".myProfile-form input");;

// intialize updateOperation to be called on updation.
const updateAcc = updateOperation();


window.onload = (event) => {
    const headers = {
        "Authorization":`Bearer ${sessionStorage.getItem("accessToken")}`,
        "X-Uuid":`${sessionStorage.getItem("uuid")}`
    }
    fetchGet(`${basePath}/scripts/php/myprofile.php`,headers).then(res=>{
        return res.json();
    }).then(data=>{
        // if res.ok
        if(data.code>=200 && data.code<=299){
            fillInputFields(data.userProfile);
            $(".loader").addClass("hidden");
        }else{
            throw new Error(data.message);
        }
    })
    .catch(e=>{
        $(".loader").addClass("hidden");
        sessionStorage.setItem("error",e.message);
        window.location.replace(`${basePath}/html/signin.html`);
    });
};

logoutBtn.click(function(e){
    e.preventDefault();
    // remove accessToken and credentials from session storage to logout successfully
    sessionStorage.removeItem("accessToken");
    sessionStorage.removeItem("email");
    // redirect to signin after logout
    window.location.replace(`${basePath}/html/signin.html`);
});

editBtn.click(function(e){
    e.preventDefault();

    // save input values before edit to object
    const beforeEditInputFieldValues = serializeToObj(inputFields);
    // enter edit mode
    goToEditMode();

    editCancelBtn.click(function(e){
        e.preventDefault();
        // fill in the form with values before edit
        fillInputFields(beforeEditInputFieldValues);
        goBackFromEditMode();
    })

    updateBtn.click(function(e){
        e.preventDefault();
        // check for validity
        if($(".myProfile-form").valid()){
            // update operation start
            updateAcc.start();
            // form-data of updated details
            const updatedUserProfile = createFormData(".myProfile-form");
    
            const headers = {
                "Authorization":`Bearer ${sessionStorage.getItem("accessToken")}`,
                "X-Uuid":`${sessionStorage.getItem("uuid")}`
            }
        
            fetchPost(`${basePath}/scripts/php/updateUserProfile.php`,updatedUserProfile,headers).then(res=>{
                return res.json();
            })
            .then(data=>{
                // if res.ok
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

/*
@param user obj with profile details
*/
function fillInputFields(userProfile){
    inputFields.each(function(index,element){
        element.value = userProfile[element.name];
    })
}

/*
@param inputFields - input fields to be serialized as object
return serialized object
*/
function serializeToObj(inputFields){
    const obj = {};

    inputFields.each(function(index,element){
        obj[element.name] = element.value;
    });

    return obj;
}

/*
    enables input fields for edit,
    change buttons from edit,logout to update,cancel
*/

function goToEditMode(){
    inputFields.removeAttr("disabled");

    editLogoutContainer.removeClass("show");
    editLogoutContainer.addClass("hide");
    updateCancelContainer.addClass("show");
}
/*
    disables input fields,
    change buttons from update,cancel to edit,logout
*/
function goBackFromEditMode(){
    inputFields.attr("disabled","true");

    editLogoutContainer.removeClass("hide");
    editLogoutContainer.addClass("show");
    updateCancelContainer.removeClass("show");
}

/*
    initialize new Operation object with element to operate on, loading text,loading text class
*/
function updateOperation(){
    const operation = new Operation(updateBtn,"Updating","updating-acc-span");

    return operation;
}