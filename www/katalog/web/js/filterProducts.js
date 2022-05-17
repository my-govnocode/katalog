$(document).ready(function(){
    $('.productFilter').click((e) => {
        $("#submit").click();
    })

    $('.price').change((e) => {
        $("#submit").click();
    })
})

$('#form').on('submit', function(e){
    event.preventDefault();
    let form = $(this);
    let data = $(this).serialize();

    let map = new Map()

    let url = data.split('%5B%5D').join('').split('&').forEach((element) => {
        let arr = element.split('=')
        if (map.has(arr[0])) {
            let value = map.get(arr[0]) + ',' + arr[1]
            map.set(arr[0], value)
        } else {
            map.set(arr[0], arr[1])
        }
    })

    let validUrl = ''
    map.forEach((element, key) => {
        validUrl = validUrl.length !== 0 ? validUrl + '&' + key + '=' + element : validUrl + key + '=' + element
    })

    const str = '?' + validUrl
    history.pushState(null, null, str);
  $.ajax({
    url: form.attr("action"),
    type: form.attr("method"),
    data: data,
    success: function(data){
      $('#products').html(data)
    },
    error: function(){
      alert('Ошибка!');
    }
  });
  return false;
})