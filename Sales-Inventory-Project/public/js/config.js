function showLoader() {
    document.getElementById('loader').classList.remove('d-none')
}
function hideLoader() {
    document.getElementById('loader').classList.add('d-none')
}

function successToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        style: {
            background: "green",
        },
        offset: {
            x: 20,
            y: 70
        },
    }).showToast();
}

function errorToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        style: {
            background: "red",
        },
        offset: {
            x: 20,
            y: 70
        },
    }).showToast();
}


function unauthorized(code){
    if(code===401){
        localStorage.clear();
        sessionStorage.clear();
        window.location.href="/logout"
    }
}

function setToken(token){
    localStorage.setItem("token",`Bearer ${token}`)
}

function getToken(){
   return  localStorage.getItem("token")
}


function HeaderToken(){
   let token=getToken();
   return  {
        headers: {
            Authorization:token
        }
    }
}

function HeaderTokenWithBlob(){
    let token=getToken();
    return  {
        responseType: 'blob',
        headers: {
            Authorization:token
        }
    }
}
