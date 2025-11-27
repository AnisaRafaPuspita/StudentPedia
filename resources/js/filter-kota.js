document.addEventListener('DOMContentLoaded', () => {

    const provinsi = document.getElementById('provinsi');
    const kabupaten = document.getElementById('kabupaten');

    // 1. Load Provinsi
    fetch('/wilayah/provinsi')
        .then(res => res.json())
        .then(data => {
            data.forEach(item => {
                provinsi.innerHTML += `<option value="${item.kode}">${item.nama}</option>`;
            });
        });

    // 2. Provinsi → Kabupaten
    provinsi.addEventListener('change', () => {

        kabupaten.innerHTML = `<option value="">Loading...</option>`;

        fetch(`/wilayah/kabupaten/${provinsi.value}`)
            .then(res => res.json())
            .then(data => {
                kabupaten.innerHTML = `<option value="">Pilih Kabupaten</option>`;
                data.forEach(item => {
                    kabupaten.innerHTML += `<option value="${item.kode}">${item.nama}</option>`;
                });
            });
    });
});
