export function createFormData(formClassname){
    const inputFields = $(formClassname+" input");
    const formData = new FormData();
    inputFields.each(function(index,element){
        if(element.value){
            formData.append(element.name,element.value);
        }
    })
    return formData;
}

export async function fetchPost(url,data,headers={}){
    const response = await fetch(url,{
        method:"POST",
        mode:"same-origin",
        body:data,
        headers:headers
    });

    return response;
}

export function showSnackbar(message,indicatorClass) {
    const snackbar = document.querySelector(".snackbar");
    const snackbarMessageContainer = document.querySelector(".snackbar > div");
    snackbarMessageContainer.innerText = message;
    snackbar.classList.add(indicatorClass);
    snackbar.classList.add("show");
    setTimeout(() => snackbar.classList.remove("show"), 3000);
}