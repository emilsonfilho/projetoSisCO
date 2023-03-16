function confirmarExclusao() {
    let resultado = confirm('Tem cereteza de que deseja excluir esse registro?')
    return resultado ? true : false
}

Array.from(document.getElementsByClassName('delete-form')).forEach((button) => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        if (confirmarExclusao()) {
            let form = this.closest('form')
            form.submit()
        }
    })
})