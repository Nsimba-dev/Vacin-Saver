document.querySelector('form').addEventListener('submit', (e)=>{
    let mdp , confirm_mdp ;

    mdp = document.getElementById('password').value ;
    confirm_mdp = document.getElementById('confirm_password').value ;

    mdp = mdp.trim();
    confirm_mdp = confirm_mdp.trim();

    if(mdp == "" || confirm_mdp ==""){
        e.preventDefault()
        alert('Veuillez Remplir les champs vide !');
    }
    else{
        if(mdp != confirm_mdp){
            e.preventDefault()
            alert("Le mot de passe n'est pas egale !");
        }
        else{
            if(mdp.length < 8 || confirm_mdp.length <8 ){
                e.preventDefault()                
                alert("Le nombre de caractere est inferieurs a 8 !")
            }
            document.getElementById('password') = mdp ;
            document.getElementById('confirm_password') = confirm_mdp ;
        }
    }
})