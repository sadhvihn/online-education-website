let footer=document.querySelector('.footer');
let body=document.body;
let searchForm =document.querySelector('.header .flex .search-form');
let sideBar =document.querySelector('.side-bar');
let profile =document.querySelector('.header .flex .profile');
let toggleBtn=document.querySelector('#toggle-btn');
let darkMode=localStorage.getItem('dark-mode');

document.querySelector('#user-btn').onclick = () =>{
    profile.classList.toggle('active');
    searchForm.classList.remove('active');
}

document.querySelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('active');
    profile.classList.remove('active');
}
document.querySelector('#menu-btn').onclick =() =>{
    sideBar.classList.toggle('active');
    // body.classList.toggle('active');
    footer.classList.toggle('active');
}
document.querySelector('#close-bar').onclick =() =>{
    sideBar.classList.remove('active');
}

window.onscroll =() =>{
    profile.classList.remove('active');
    searchForm.classList.remove('active');

    if(window.innerWidth<1200){
        sideBar.classList.remove('active');
    // body.classList.remove('active');
        footer.classList.remove('active');
}
}

const enableDarkMode =()=>{
    toggleBtn.classList.replace('fa-sun','fa-moon');
    body.classList.add('dark');
    localStorage.setItem('dark-mode','enabled');
}

const disableDarkMode =()=>{
    toggleBtn.classList.replace('fa-moon','fa-sun');
    body.classList.remove('dark');
    localStorage.setItem('dark-mode','disabled');
}

toggleBtn.onclick=(e)=>{
    let darkMode =localStorage.getItem('dark-mode');
    if(darkMode ==='disabled'){
        enableDarkMode();
    }
    else{
        disableDarkMode();
    }
}
if(darkMode ==='enabled'){
    enableDarkMode();
}

document.querySelectorAll('input[type="number]').forEach(inputNUmber=>{
    inputNUmber.oninput=() =>{
        if(inputNUmber.value.length>inputNUmber.maxLength) inputNUmber.value=inputNUmber.value.slice(0,inputNUmber.maxLength);
    };
});