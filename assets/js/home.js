// Kalkulator harga di hero (harga sama untuk semua kecamatan)
const rp = n => 'Rp ' + n.toLocaleString('id-ID');
function hitung() {
  const paket = +document.querySelector('input[name=paket]:checked').value;
  document.getElementById('rTotal').textContent = rp(paket);
}
document.querySelectorAll('input[name=paket]').forEach(r => r.addEventListener('change', hitung));
hitung();
