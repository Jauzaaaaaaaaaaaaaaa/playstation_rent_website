(function () {
  var S = {
    tri: ['#39d6a6', '<path d="M50 14L88 82H12z"/>'],
    cir: ['#ff5d6c', '<circle cx="50" cy="50" r="37"/>'],
    cro: ['#6da4ff', '<path d="M17 17L83 83M83 17L17 83"/>'],
    squ: ['#e77fd3', '<rect x="16" y="16" width="68" height="68"/>']
  };
  var svg = function (k, attr) {
    return '<svg viewBox="0 0 100 100" aria-hidden="true" stroke="' + S[k][0] + '" style="color:' + S[k][0] + ';' + attr + '">' + S[k][1] + '</svg>';
  };
  var keys = ['tri', 'cir', 'cro', 'squ'];
  window.AT = {
    label: 'Rental PlayStation',
    ms: 1700,
    intro: '<div class="ps-boot"><div class="ps-boot__row">' +
      keys.map(function (k, i) { return svg(k, '--d:' + (i * .22 + .1) + 's'); }).join('') +
      '</div><div class="ps-boot__bar"><i></i></div><p>MEMUAT KONSOL</p></div>',
    bg: function (body) {
      var b = document.createElement('div');
      b.className = 'ps-bg';
      b.setAttribute('aria-hidden', 'true');
      var html = '';
      for (var i = 0; i < 14; i++) {
        html += svg(keys[i % 4], '--s:' + (70 + (i * 37) % 130) + 'px;--x:' + ((i * 41 + 7) % 96) + '%;--y:' + ((i * 67 + 13) % 92) + '%;--t:' + (7 + i % 6) + 's');
      }
      b.innerHTML = html;
      body.insertBefore(b, body.firstChild);
    }
  };
})();

/* Alat tabel: cari langsung dan ekspor CSV, tanpa mengubah data di server */
document.addEventListener('DOMContentLoaded', function () {
  var t = document.querySelector('table');
  if (!t || !t.querySelector('tr td')) return;
  var rows = Array.prototype.slice.call(t.querySelectorAll('tr')).filter(function (r) { return r.querySelector('td'); });
  var bar = document.createElement('div');
  bar.className = 'dt-bar';
  bar.innerHTML = '<input type="search" placeholder="Cari di tabel" aria-label="Cari di tabel"><span class="dt-count"></span><button type="button">Ekspor CSV</button>';
  var box = t.closest('.table-card, .table-responsive') || t;
  box.parentNode.insertBefore(bar, box);
  var count = bar.querySelector('.dt-count');
  var show = function (n) { count.textContent = n + ' baris'; };
  show(rows.length);
  bar.querySelector('input').addEventListener('input', function () {
    var q = this.value.toLowerCase(), n = 0;
    rows.forEach(function (r) {
      var hit = r.textContent.toLowerCase().indexOf(q) > -1;
      r.style.display = hit ? '' : 'none';
      if (hit) n++;
    });
    show(n);
  });
  bar.querySelector('button').addEventListener('click', function () {
    var cell = function (c) { return '"' + c.textContent.trim().replace(/\s+/g, ' ').replace(/"/g, '""') + '"'; };
    var lines = Array.prototype.map.call(t.querySelectorAll('tr'), function (r) {
      if (r.style.display === 'none') return null;
      var cs = Array.prototype.slice.call(r.children);
      return cs.slice(0, cs.length - 1).map(cell).join(',');
    }).filter(Boolean);
    var a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob(['\ufeff' + lines.join('\n')], { type: 'text/csv;charset=utf-8' }));
    a.download = 'data.csv';
    a.setAttribute('data-no-at', '');
    document.body.appendChild(a);
    a.click();
    a.remove();
  });
});
