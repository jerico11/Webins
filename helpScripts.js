$(document).on('click', 'td.edit', function () {
    $(this).html("<input type='text' value='" + $(this).text() + "'/>");
// Что бы input не ставился повторно, запрещаем
}).on('click', 'td input', function () {
    return false;
// При потере фокуса в input, возвращаем все как было.
}).on('blur', 'td input', function () {
    // text, т.к. html теги не обрабатываются.
    $(this).parent('td').text($(this).val());
});

//определяем нажатие кнопки на клавиатуре
$(document).on('keydown', 'td.edit', function (event) {
    //получаем значение класса и разбиваем на массив
    //в итоге получаем такой массив - arr[0] = edit, arr[1] = наименование столбца, arr[2] = id строки
    arr = $(this).attr('class').split(" ");
    var value = $('input').val();
    //проверяем какая была нажата клавиша и если была нажата клавиша Enter (код 13)
    if (event.which == 13) {
        //получаем наименование таблицы, в которую будем вносить изменения
        var table = $('table').attr('id');
        //выполняем ajax запрос методом POST
        $.post("edit.php", {
            table: table,
            field: arr[1],
            id: arr[2],
            value: value
        })
        //при удачном выполнении скрипта, производим действия
            .fail(function () {
                alert("error");
            })
            .done(function (data) {
                //находим input внутри элемента с классом ajax и вставляем вместо input его значение
                $('.ajax <input id="editbox" size="' + $(this).text().length + '" value="' + $(this).text() + '" type="text">').html(value);
                //удаялем класс ajax
                $('.ajax').removeClass('ajax');
                alert("ok");
            });
    }
});
function addPerson() {
    var firstN = document.getElementById('firstName').value;
    var secondN = document.getElementById('secondName').value;
    var emailVal = document.getElementById('email').value;
    var temp = secondN;
    if ((firstN == "") || (secondN = "") || (emailVal == "")) {
        alert("Fields can't be empty");
        return;
    }
    else {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        if (!pattern.test(emailVal)) {
            alert("Not valid email");
            return;
        }
    }

    var table = $('table').attr('id');
    secondN = temp;
    $.post("add.php", {
        table: table,
        firstField: 'firstName',
        secondField: 'secondName',
        thirdField: 'email',
        firstValue: firstN,
        secondValue: secondN,
        thirdValue: emailVal,
    })
    //при удачном выполнении скрипта, производим действия
        .fail(function () {
            alert("error");
        })
        .done(function (data) {
            var add = document.getElementById('addPerson');
            add.setAttribute("style", "display:none");
            var tab = document.getElementById(table);
            var row = tab.insertRow(-1);
            var firstCell = row.insertCell(0);
            firstCell.innerHTML = firstN;
            firstCell.setAttribute("class", "edit firstName ".data);
            var secondCell = row.insertCell(1);
            secondCell.innerHTML = secondN;
            secondCell.setAttribute("class", "edit secondName".data);
            var thirdCell = row.insertCell(2);
            thirdCell.innerHTML = emailVal;
            thirdCell.setAttribute("class", "edit email".data);
            var fourthCell = row.insertCell(3);
            fourthCell.innerHTML = ">>>>>>click<<<<<";
        });

};

function addRow() {
    var add = document.getElementById('addPerson');
    add.removeAttribute("style");
};

$(document).on('click', 'td.del', function () {
    arr = $(this).attr('class').split(" ");
    var table = $('table').attr('id');
    $.post("delete.php", {
        table: table,
        id: arr[2],
    })
    //при удачном выполнении скрипта, производим действия
        .fail(function () {
            alert("error");
        })
        .done(function (data) {
            $this.parent('tr').remove();
        });
});