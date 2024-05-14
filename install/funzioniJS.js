function responsivebutton(button, name){
    var nome= button.name;
    button.value=nome;
    button.style.opacity="0";
    button.style.backgroundColor="white";
    button.style.color="white";
    button.style.borderColor="white";
    button.name=name;
    return;
}