$(document).ready(function () {
  // get json data from seriea.json
  var xhr = new XMLHttpRequest(),
    seriea;
  xhr.open('GET', 'js/seriea.json', false);
  xhr.send();
  if (xhr.status != 200) {
    // в случае ошбки
    console.log(xhr.status + ': ' + xhr.statusText);
  } else {
    seriea = JSON.parse(xhr.responseText);
  }

  CreateTable("raiting", seriea.teams);

  function CreateTable(id, teams) {
    var _id, tbl_r, table, th, thead, tbody, tfoot, row, cell, r_count = teams.length, col_count = 8,
      d = document,
      i, titles = ['', 'Команда', 'М', 'В', 'Н', 'П', 'Заб', 'Проп', 'О'];

    if (!(id && teams)) {
      return console.log("Input id or teams is undefined");
    } else {
      _id = d.getElementById(id);
      tbl_r = d.getElementById("tbl_raiting");
      if (!tbl_r) {
        table = d.createElement('table');
        table.id = "tbl_raiting";
        thead = table.createTHead();

        //thead
        thead.insertRow(0);
        for (i = 0; i <= col_count; i++) {
          th = d.createElement('th');
          th.innerHTML = titles[i];
          thead.rows[0].appendChild(th);
        }

        thead.rows[0].cells[0].classList.add('asc');
        for (i = 0; i <= col_count; i++) {
          if (i == 1) {
            thead.rows[0].cells[i].setAttribute("onclick", "sort_str(this)");
            continue;
          }
          thead.rows[0].cells[i].setAttribute("onclick", "sort_num(this)");
        }

        //tbody
        tbody = table.createTBody();
        for (i = 0; i < r_count; i++) {
          row = tbody.insertRow(i);

          row.insertCell(0).innerHTML = teams[i].place;
          switch (teams[i].color) {
          case "1":
            tbody.rows[i].cells[0].classList.add('bg-green');
            break;
          case "2":
            tbody.rows[i].cells[0].classList.add('bg-lgth-green');
            break;
          case "4":
            tbody.rows[i].cells[0].classList.add('bg-red');
            break;
          default:
            break;
          }
          row.insertCell(1).innerHTML = "<a href='" + teams[i].tag_url + "' target='_blank'>" + teams[i].name + "</a>";
          row.insertCell(2).innerHTML = teams[i].matches;
          row.insertCell(3).innerHTML = teams[i].win;
          row.insertCell(4).innerHTML = teams[i].draw;
          row.insertCell(5).innerHTML = teams[i].lose;
          row.insertCell(6).innerHTML = teams[i].goals;
          row.insertCell(7).innerHTML = teams[i].conceded_goals;
          row.insertCell(8).innerHTML = teams[i].score;
        }

        for (i = 0; i <= r_count; i++) {
          table.rows[i].cells[3].classList.add('hide-2');
          table.rows[i].cells[4].classList.add('hide-2');
          table.rows[i].cells[5].classList.add('hide-2');

          table.rows[i].cells[6].classList.add('hide-1');
          table.rows[i].cells[7].classList.add('hide-1');
        }

        tfoot = table.createTFoot();
        row = tfoot.insertRow(0);
        cell = row.insertCell(0);
        cell.setAttribute("colspan", 9);
        cell.classList.add('tfooter');
        cell.innerHTML = "<p><span>М</span> – матчи, <span>В</span> – выигрыши, <span>Н</span> – ничьи, <span>П</span> – проигрыши, <span>Заб</span> – забитые голы, <span>Проп</span> – пропущенные голы, <span>О</span> – очки в турнире</p>";
        _id.appendChild(table);
      } else {
        _id.innerHTML = '';
        CreateTable(id, teams);
      }
    }
    // classes for table style 
    $("#tbl_raiting").parent().addClass("tbl-parent");
    $("#tbl_raiting").addClass("tbl_raiting");
  }
});