// Kalkulator harga di hero beranda
    const rp = (n) => "Rp " + n.toLocaleString("id-ID");

    function hitung() {
      const el = document.querySelector("input[name=paket]:checked");
      const harga = +(el.dataset.harga || 120000);
      document.getElementById("rTotal").textContent = rp(harga);
    }

    document
      .querySelectorAll("input[name=paket]")
      .forEach((r) => r.addEventListener("change", hitung));

    hitung();