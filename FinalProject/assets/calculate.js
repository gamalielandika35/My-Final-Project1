document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formNilai');
    const statusBox = document.getElementById('statusNilai');
    const btnBatal = document.getElementById('btnBatalEditNilai');
    


    if (!form) return;

    function resetFormNilai() {
        form.reset();
        document.getElementById('nilai_id').value = '';
        document.getElementById('sks').value = 2;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch('simpan_kalkulator.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            statusBox.innerHTML = `<p>${data.message}</p>`;
            if (data.status) {
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        })
        .catch(() => {
            statusBox.innerHTML = `<p>Terjadi kesalahan saat menyimpan data.</p>`;
        });
    });

    btnBatal.addEventListener('click', function () {
        resetFormNilai();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-edit-nilai')) {
            document.getElementById('nilai_id').value = e.target.dataset.id;
            document.getElementById('nama_matkul').value = e.target.dataset.nama;
            document.getElementById('semester').value = e.target.dataset.semester;
            document.getElementById('sks').value = e.target.dataset.sks;
            document.getElementById('nilai_rata_rata').value = e.target.dataset.nilai;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        if (e.target.classList.contains('btn-hapus-nilai')) {
            if (!confirm('Yakin ingin menghapus data nilai ini?')) return;

            const formData = new FormData();
            formData.append('id', e.target.dataset.id);

            fetch('ajax/hapus_nilai.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.status) {
                    window.location.reload();
                }
            })
            .catch(() => {
                alert('Gagal menghapus data.');
            });
        }
    });
});