function confirmarRemocao(tipo, idForm) {
  if (confirm(`Tem certeza que deseja remover ${tipo}?`)) {
    document.querySelector(idForm).submit();
  }
}
