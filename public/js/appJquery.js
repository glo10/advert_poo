
/******JQUERY FOR SIGN IN && SING UP *******/
(function(){
    $(document).ready(function(){
        //tags for index.php
        $('.btnSign').on('click',function(){
            var boxshow = $(this).attr('data-content');
            var boxHide = $(this).attr('data-hide');
            $(this).attr('class','btn btn-success btnSign');
            $(this).siblings().attr('class','btn btn-default btnSign');
            $(boxshow).show();
            $(boxHide).hide();
        });

        //request from client to php server in order to sign in or sign up or add Advert
        $('form').on('submit',function(e){
            e.preventDefault();
            var action = $(this).data('url');
            $.ajax({
                type:'post',
                url:action,
                data :new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success:function(response){
                    var regex = new RegExp('ajout non ok');
                    switch(response){
                      case 'connexion':
                      case 'inscription':
                        window.location.replace('accueil.php');
                      break;
                      case 'ajout ok':
                        window.location.replace('accueil.php');
                        $('#userMsg').text('L\'annonce a été ajouté avec succès');
                      break;
                      default:
                          if(regex.test(response))
                            $('#userMsg').text('L\'annonce n\'a pas été enregistré, veuillez respecter les recommandations ci-dessous');
                          else
                            $('#userMsg').text(response);
                      break;
                    }
                },
                error : function(response){
                    $('#userMsg').text('Erreur au niveau de l\'execution de la connexion côté serveur');
                }
            });
        })

    });
})();
