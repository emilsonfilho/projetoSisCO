/**
 * Dispatch a confirm and sets a hidden input
 * @param {string} formId - Sets the form id
 * @param {string} inputName - Sets the name of the input hidden
 * @param {string | number} inputValue - Sets the value of the hidden input
 * @param {string} confirmMessage - String to complete the confirm message
 * @returns {boolean}
 */
function confirmAndSetId(formId, inputName, inputValue, confirmMessage) {
  var confirmacao = confirm(
    `Tem certeza que deseja remover ${confirmMessage}?`
  );

  if (confirmacao) {
    var form = document.getElementById(formId);
    var input = document.createElement("input");

    input.type = "hidden";
    input.name = inputName;
    input.value = inputValue;

    form.appendChild(input);
    form.submit();

    return true;
  } else {
    return false;
  }
}
