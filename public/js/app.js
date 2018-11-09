(function(){

  const playerForm = document.querySelector('form#playerForm');
  const name = playerForm.querySelector('#name');
  const position = playerForm.querySelector('#position');
  const team_id = playerForm.querySelector('input[type=hidden]');
  const submit = playerForm.querySelector('input[type=submit]');
  const playersTable = document.querySelector('#playersTable tbody');
  let btnsEdit = null;
  let btnsDelete = null;

  let editedPlayerId = null;
  let editedRow = null;

  submit.addEventListener('click', (e) => {
    e.preventDefault();
    let player = {
      name : name.value,
      position:position.value
    }

    let url = '';

    if(editedPlayerId == null){
      //Insert Mode
      url = '../process_player.php';
      player.team_id = team_id.value
    }
    else{
      //Update Mode
      url = 'player_update.php';
      player.id = editedPlayerId;
      console.log('player',player);
    }

    console.log('url',url);
    //AJAX to insert or update players
    fetch(url,{
      headers:{
        'Content-Type':'application/json'
      },
      method:'post',
      body:JSON.stringify(player)
    })
    .then(res => res.json())
    .then(data => {
      console.log('ajax ok');
      console.log('reponse',data);
      if(editedPlayerId == null){
        //insert Mode
        let html = playersTable.innerHTML;
        let tr = `<tr>
                    <td>${player.name}</td>
                    <td>${player.position}</td>
                    <td>
                      <button data-id="${JSON.parse(data).id}" class="btnEdit btn btn-warning" type="button" name="button">Editer</button>
                      <button data-id="${JSON.parse(data).id}" class="btnDelete btn btn-danger" type="button" name="button">Supprimer</button>
                    </td>
                    <td
                  </tr>`;
        html += tr;
        playersTable.innerHTML = html;
        //refresh btn events
        addEventsToBtns();
        console.log('lastId insert',JSON.parse(data));
      }
      else{
        //Update mode
        console.log('lastId',data);
        if(data){
          editedRow.children[0].innerText = player.name;
          editedRow.children[1].innerText = player.position;
          clear();
        }
      }

    });
  });

  function clear(){
    editedPlayerId = null;
    editedRow = null;
    name.value = '';
    position.gardien = '';
    submit.value = 'Enregistrer';
  }

  function addEventsToBtns(){
        //Update && Delete
    btnsEdit = playersTable.querySelectorAll('.btnEdit');
    btnsDelete = playersTable.querySelectorAll('.btnDelete');
    btnsEdit.forEach(btn => {
      btn.addEventListener('click', e =>{
        let tr = e.target.parentNode.parentNode;
        editedRow = e.target.parentNode.parentNode;

        let player = {
          name : tr.children[0].innerText.trim(),
          position : tr.children[1].innerText.trim(),
          id : e.target.dataset.id
        };

        editedPlayerId = player.id;
        name.value = player.name;
        position.value = player.position;
        submit.value = "Mettre à jour";
      });
    });

    btnsDelete.forEach(btn =>{
      btn.addEventListener('click', e => {
        fetch('player_delete.php?id=' + e.target.dataset.id)
        .then(res => res.text())
        .then(res => {
          console.log(res);
          if(res){
            e.target.parentNode.parentNode.remove();
          }
        });
      });
    });
  }

  function init(){
    addEventsToBtns();
  }

  init();

})();
