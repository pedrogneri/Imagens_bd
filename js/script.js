var loadFile = function (event) {
  var output = document.getElementById('output');
  output.src = URL.createObjectURL(event.target.files[0]);
};

function excluir(id){
  if (confirm("Deseja realmente excluir?")){
    window.location.href = 'alteracao.php?excluir=' + id;
  }
}

function excluirImg(id){
  if (confirm("Deseja realmente excluir?")){
    window.location.href = 'pagina_usuario.php?excluir=' + id;
  }
}

function alterarImg(id){
    window.location.href = 'pagina_usuario.php?alterar=' + id;
}

function sair(){
    if (confirm("Deseja realmente sair?")){
      window.location.href = 'pagina_usuario.php?sair=true';
    }
}

function alterar(id){
  window.location.href = 'alteracao.php?alterar=' + id;
}

function btnCancelar(){
  location.href="../index.php"
}
