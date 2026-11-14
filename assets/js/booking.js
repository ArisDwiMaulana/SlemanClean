// Ringkasan biaya real-time (harga sama untuk semua kecamatan)
const $ = s => document.querySelector(s);
const rp = n => 'Rp ' + n.toLocaleString('id-ID');
function update() {
  const pk = $('input[name=paket]:checked');
  $('#sPaket').textContent = pk.dataset.nama;
  $('#sHargaPaket').textContent = rp(+pk.dataset.harga);
  $('#sKec').textContent = 'Kec. ' + $('#kec').value;
  $('#sTotal').textContent = rp(+pk.dataset.harga);
}
document.querySelectorAll('input[name=paket], #kec').forEach(e => e.addEventListener('change', update));
update();
