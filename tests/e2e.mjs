// Uji alur lengkap terhadap server PHP dan MySQL sungguhan. Jalankan: node tests/e2e.mjs http://127.0.0.1:8124
import assert from 'node:assert/strict';

const BASE = process.argv[2] || 'http://127.0.0.1:8124';
let cookie = '';

async function req(path, opts = {}) {
  const r = await fetch(BASE + path, {
    redirect: 'manual',
    ...opts,
    headers: { ...(opts.headers || {}), cookie, 'content-type': 'application/x-www-form-urlencoded' },
  });
  const set = r.headers.get('set-cookie');
  if (set) cookie = set.split(';')[0];
  return { status: r.status, location: r.headers.get('location') || '', text: await r.text() };
}
const form = (o) => new URLSearchParams(o).toString();
const csrfFrom = (html) => (html.match(/name="csrf" value="([a-f0-9]+)"/) || [])[1];
const results = [];
async function test(name, fn) {
  try { await fn(); results.push(['OK', name]); } catch (e) { results.push(['GAGAL', `${name}: ${e.message}`]); }
}

await test('halaman admin mengalihkan ke login tanpa sesi', async () => {
  for (const p of ['/index.php', '/laporan.php', '/tambah.php']) {
    const r = await req(p);
    assert.equal(r.status, 302);
    assert.match(r.location, /login\.php/);
  }
});

let token;
await test('login tanpa token CSRF ditolak', async () => {
  const r = await req('/proses_login.php', { method: 'POST', body: form({ email: 'admin@gmail.com', password: 'admin123' }) });
  assert.equal(r.status, 403);
});

await test('kredensial demo tidak tampil di halaman login', async () => {
  const r = await req('/login.php');
  assert.ok(!r.text.includes('admin123'));
  token = csrfFrom(r.text);
  assert.ok(token);
});

await test('injeksi SQL pada login gagal', async () => {
  const r = await req('/proses_login.php', { method: 'POST', body: form({ csrf: token, email: "' OR '1'='1", password: "' OR '1'='1" }) });
  assert.match(r.location, /login\.php/);
});

await test('login benar berhasil dan ID sesi berganti', async () => {
  const before = cookie;
  const r = await req('/proses_login.php', { method: 'POST', body: form({ csrf: token, email: 'admin@gmail.com', password: 'admin123' }) });
  assert.match(r.location, /index\.php/);
  assert.notEqual(cookie, before);
});

await test('dasbor dan laporan tampil dengan data', async () => {
  const a = await req('/index.php');
  assert.equal(a.status, 200);
  token = csrfFrom(a.text);
  const b = await req('/laporan.php');
  assert.equal(b.status, 200);
  assert.match(b.text, /Omzet per bulan/);
  assert.match(b.text, /PlayStation 5/);
});

const NAMA = 'Tes <b>E2E</b> ' + Date.now();
let id;
await test('tambah data tersimpan dan teks di-escape', async () => {
  const r = await req('/simpan.php', { method: 'POST', body: form({ csrf: token, nama: NAMA, no_hp: '081200001111', jenis: 'PlayStation 5', durasi: 2, harga: 150000 }) });
  assert.match(r.location, /index\.php/);
  const page = await req('/index.php');
  assert.ok(!page.text.includes(NAMA));
  assert.ok(page.text.includes(NAMA.replace('<b>', '&lt;b&gt;').replace('</b>', '&lt;/b&gt;')));
  id = page.text.match(/edit\.php\?id=(\d+)/)[1];
});

await test('data tidak valid ditolak', async () => {
  for (const bad of [{ jenis: 'Xbox' }, { durasi: 99 }, { no_hp: 'abc' }, { nama: '' }, { harga: -5 }]) {
    const r = await req('/simpan.php', { method: 'POST', body: form({ csrf: token, nama: 'X', no_hp: '081200001111', jenis: 'PlayStation 5', durasi: 2, harga: 1000, ...bad }) });
    assert.equal(r.status, 422, JSON.stringify(bad));
  }
});

await test('ubah data tersimpan', async () => {
  const edit = await req(`/edit.php?id=${id}`);
  assert.equal(edit.status, 200);
  const r = await req('/update.php', { method: 'POST', body: form({ csrf: token, id, nama: 'Tes Diubah', no_hp: '081200002222', jenis: 'PlayStation 4', durasi: 3, harga: 180000 }) });
  assert.match(r.location, /index\.php/);
  const page = await req('/index.php');
  assert.ok(page.text.includes('Tes Diubah'));
});

await test('hapus lewat GET atau tanpa token ditolak', async () => {
  assert.equal((await req(`/hapus.php?id=${id}`)).status, 403);
  assert.equal((await req('/hapus.php', { method: 'POST', body: form({ id }) })).status, 403);
  assert.ok((await req('/index.php')).text.includes('Tes Diubah'));
});

await test('hapus dengan token berhasil', async () => {
  const r = await req('/hapus.php', { method: 'POST', body: form({ csrf: token, id }) });
  assert.match(r.location, /index\.php/);
  assert.ok(!(await req('/index.php')).text.includes('Tes Diubah'));
});

await test('login dikunci setelah lima kali gagal', async () => {
  cookie = '';
  const t = csrfFrom((await req('/login.php')).text);
  for (let i = 0; i < 5; i++) await req('/proses_login.php', { method: 'POST', body: form({ csrf: t, email: 'admin@gmail.com', password: 'salah' }) });
  await req('/proses_login.php', { method: 'POST', body: form({ csrf: t, email: 'admin@gmail.com', password: 'admin123' }) });
  const page = await req('/login.php');
  assert.match(page.text, /Terlalu banyak percobaan/);
});

for (const [s, n] of results) console.log(s.padEnd(6), n);
const fails = results.filter((r) => r[0] !== 'OK').length;
console.log(`\n${results.length - fails} dari ${results.length} lulus`);
process.exit(fails ? 1 : 0);
