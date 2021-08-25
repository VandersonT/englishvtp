let btnChangeTheme = document.querySelector('.themeLever');
let themeBar = document.querySelector('.themeBar');
let themeLever = document.querySelector('.themeLever');
let transition = '1s';

if(theme == 'dark'){
    changeThemeToDark();
}

function activeTransition(){
    document.body.style.transition = transition;
    document.querySelector('.box-menu').style.transition = transition;
    document.querySelector('.selected').style.transition = transition;
}

function desactiveTransition(){
    document.body.style.transition = 'none';
    document.querySelector('.box-menu').style.transition = 'none';
    document.querySelector('.selected').style.transition = 'none';
}

function changeThemeToDark(){
    document.documentElement.style.setProperty('--defaultColor', 'rgb(171, 171, 171)');
    document.documentElement.style.setProperty('--defaultBackground', 'rgb(18, 18, 20)');
    document.documentElement.style.setProperty('--defaultBackgroundContent', '#1c1c1c');
    document.documentElement.style.setProperty('--select', 'gray');
    document.documentElement.style.setProperty('--menuBackground', 'rgb(14, 21, 39)');
    document.documentElement.style.setProperty('--menuBackground2', 'rgb(9, 14, 26)');
    document.documentElement.style.setProperty('--defaultBackground2', 'rgb(23, 23, 23)');
    document.documentElement.style.setProperty('--border', 'rgb(18, 18, 20)');
    document.documentElement.style.setProperty('--border2', '#4d4d4d');
    document.documentElement.style.setProperty('--border3', '#141414');
    document.documentElement.style.setProperty('--form', 'rgb(48, 48, 48)');
}