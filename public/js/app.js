(function(){
    let tbody = document.querySelector('tbody');
    let likes = document.querySelectorAll('.glyphicon.glyphicon-heart');
    let trsBody = document.querySelectorAll('tbody tr');

    trsBody.forEach(tr => {
      tr.addEventListener('dblclick', e => {
        //TODO redirect to annonceDetail?id=
      });
    });

    likes.forEach(BtnLike => {
      BtnLike.addEventListener('click',e => {
        let td = e.target.parentElement;
        let advert = {
          id : td.dataset.id,
          likes : td.dataset.likes,
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
          td.lastChild.nodeValue = ' ' + JSON.parse(res.likes);
          //refresh value => user can like several times whitout refresh index page
          //td.dataset.likes =  JSON.parse(res.likes);
          td.lastElementChild.className = 'glyphicon glyphicon-heart text-success';
        })
        .catch(error => console.log(erreur));
      });
    });


  function init(){
  }

  init();

})();
