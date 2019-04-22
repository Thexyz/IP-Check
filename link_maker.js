function copyToClipboard(text) {
  window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}
$(document).ready(function() {
    $('.copy-button').click(function() {
      var name = $('#name').val();
      var email = $('#email').val();

      var query = '?name=' + name + '&email=' + email;
      var url = $(location).attr('hostname');

      copyToClipboard('http://'+url+query);
  })
});