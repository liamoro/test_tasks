//sort number value
function sort_num(elem) {
  var table, tbody, cell_indx, i, j, col = [];
  cell_indx = elem.cellIndex;
  table = elem.parentNode.parentNode.parentNode;
  tbody = table.tBodies[0];
  if (!elem.classList.contains('asc') && !elem.classList.contains('desc')) {
    elem.classList.add('desc');
  }
  $(elem).siblings().removeClass('asc desc');
  
  for (i = 0; i < tbody.rows.length; i++) {
    col.push({});
    col[i].id = tbody.rows[i].cells[0].innerHTML;
    col[i].val = tbody.rows[i].cells[cell_indx].innerHTML;
  }

  elem.classList.toggle("asc");
  elem.classList.toggle("desc");

  col.sort(function (a, b) {
    if (elem.classList.contains('desc')) {
      return b.val - a.val;
    }
    return a.val - b.val;
  });
  

  for (i = 0; i < col.length; i++) {
    for (j = 0; j < tbody.rows.length; j++) {
      if (tbody.rows[j].cells[0].innerHTML == col[i].id && j != i) {
        tbody.insertBefore(tbody.rows[j], tbody.childNodes[i]);
      }
    }
  }
}

// sort string value
function sort_str(elem) {
  var table, tbody, cell_indx, i, j, col = [];
  cell_indx = elem.cellIndex;
  table = elem.parentNode.parentNode.parentNode;
  tbody = table.tBodies[0];
  
  if (!elem.classList.contains('asc') && !elem.classList.contains('desc')) {
    elem.classList.add('desc');
  }
  $(elem).siblings().removeClass('asc desc');
  
  for (i = 0; i < tbody.rows.length; i++) {
    col.push({});
    col[i].id = tbody.rows[i].cells[0].innerHTML;
    col[i].val = tbody.rows[i].cells[cell_indx].querySelector("a").innerHTML;
  }

  elem.classList.toggle("asc");
  elem.classList.toggle("desc");

  col.sort(function (a, b) {
    if ((a.val.toLocaleLowerCase() < b.val.toLocaleLowerCase() && elem.classList.contains('desc')) ||
       (a.val.toLocaleLowerCase() > b.val.toLocaleLowerCase() && elem.classList.contains('asc'))) {
      return 1;
    } else if ((a.val.toLocaleLowerCase() > b.val.toLocaleLowerCase() && elem.classList.contains('desc')) ||
       (a.val.toLocaleLowerCase() < b.val.toLocaleLowerCase() && elem.classList.contains('asc'))) {
      return -1;
    }
    return 0;
  });
  for (i = 0; i < col.length; i++) {
    for (j = 0; j < tbody.rows.length; j++) {
      if (tbody.rows[j].cells[0].innerHTML == col[i].id && j != i) {
        tbody.insertBefore(tbody.rows[j], tbody.childNodes[i]);
      }
    }
  }
}
