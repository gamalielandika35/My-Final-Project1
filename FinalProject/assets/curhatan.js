

document.addEventListener('DOMContentLoaded', function() {

   
    function loadFeed() {
        fetch('load_curhatan.php')
            .then(res => res.text())
            .then(data => {
                document.getElementById('feed').innerHTML = data;
            });
    }
    loadFeed();

    
   
    function showFileName(input, displayElement) {
        let fileName = input.files.length ? input.files[0].name : '';
        displayElement.textContent = fileName;
    }
    const mediaInput = document.getElementById('mediaInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    if (mediaInput) {
        mediaInput.addEventListener('change', function() {
        showFileName(this, fileNameDisplay);
        });
    }

  
    const postForm = document.getElementById('postForm');
    if (postForm) {
        postForm.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(postForm);

            fetch('simpan_curhat.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(resp => {
                if (resp.trim() === 'sukses') {
                    document.getElementById('postText').value = '';
                    mediaInput.value = '';
                    fileNameDisplay.textContent = '';
                    loadFeed();
                } else {
                    alert('Gagal: ' + resp);
                }
            });
        });
    }

   
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-like')) {
            e.preventDefault();
            let btn = e.target.closest('.btn-like');
            let curhatanId = btn.dataset.id;
            let icon = btn.querySelector('i');
            let countSpan = btn.querySelector('.like-count');

            fetch('toggle_like.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'curhatan_id=' + encodeURIComponent(curhatanId)
            })
            .then(res => res.json())
            .then(resp => {
                if (!resp.error) {
                    countSpan.textContent = resp.total_likes;
                    if (resp.status === 'liked') {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                        icon.style.color = '#ff0000';
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                        icon.style.color = '#8b8b8b';
                    }
                }
            });
        }
    });

});
