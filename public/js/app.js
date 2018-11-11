(function(){
    let likes = document.querySelectorAll('.glyphicon.glyphicon-heart');

    likes.forEach(BtnLike => {
      BtnLike.addEventListener('click',e => {
        let span = e.target;
        let advert = {
          id : span.dataset.id,
          likes : span.dataset.likes,
          update : true
        };

        fetch('../process/processAddLike.php',{
          headers:{
            'Content-Type':'application/json'
          },
          method:'post',
          body:JSON.stringify(advert)
        })
        .then(res => res.json())
        .then(res => {
          span.nextElementSibling.innerText = ' ' + JSON.parse(res.likes);
          //refresh value => user can like several times whitout refresh index page
          //td.dataset.likes =  JSON.parse(res.likes);
          span.className = 'glyphicon glyphicon-heart text-success';
        })
        .catch(error => console.log(erreur));
      });
    });


  function init(){
  }

  init();

})();
