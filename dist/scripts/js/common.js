const basePath = "/dist";

function createFormData(formClassname){
    const inputFields = $(formClassname+" input");
    const formData = new FormData();
    inputFields.each(function(index,element){
        if(element.value){
            formData.append(element.name,element.value);
        }
    })
    return formData;
}

async function fetchPost(url,data,headers={}){
    const response = await fetch(url,{
        method:"POST",
        mode:"same-origin",
        body:data,
        headers:headers
    });

    return response;
}

async function fetchGet(url,headers={}){
    const response = await fetch(url,{
        method:"GET",
        mode:"same-origin",
        headers:headers
    });

    return response;
}

function showSnackbar(message,indicatorClass) {
    const snackbar = document.querySelector(".snackbar");
    const snackbarMessageContainer = document.querySelector(".snackbar > div");
    snackbarMessageContainer.innerText = message;
    snackbar.classList.add(indicatorClass);
    snackbar.classList.add("show");
    setTimeout(() => snackbar.classList.remove("show"), 3000);
}

function Operation(element,loadingText,loadingSpanClass){
    this.element = element;
    this.elementInitialHTML = this.element.html();
    this.loadingText = loadingText;
    this.loadingSpanClass = loadingSpanClass;
}

Operation.prototype.enable = function(){
    this.element.removeAttr("disabled");
}

Operation.prototype.disable = function(){
    this.element.attr("disabled","true");
}

Operation.prototype.start = function(){
    this.disable();

    const operatingSpan = document.createElement("span");
    operatingSpan.innerHTML = `${this.loadingText} <img class='loading-img-svg' src='${basePath}/assets/loading.svg' alt='loading'>`;
    operatingSpan.classList.add(this.loadingSpanClass);
    
    this.element.html(" ");
    this.element.append(operatingSpan);
}

Operation.prototype.end = function(){
    this.enable();
    this.element.html(this.elementInitialHTML);
}


export {showSnackbar,fetchGet,fetchPost,createFormData,basePath,Operation}