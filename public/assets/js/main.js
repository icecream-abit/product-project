function handleCheckBox(checkbox) {
        const id = checkbox.dataset.id;
        const isChecked = checkbox.checked;
        const originalState = isChecked;

        fetch('/handlecheckbox.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&checked=${isChecked ? 1 : 0}`
        })
        .then(response => response.json()) // assuming JSON response
        .then(data => {
            if (data.success) {

                const element = document.querySelector(`#product-${id} .status`);
                element.className = (originalState ? "active status" : "inactive status");
                element.textContent = (originalState ? "(Active)" : "(Inactive)");
            } else {
                checkbox.checked = !originalState; // revert state
                alert(data.message || "Action failed.");
            }
        })
        .catch(error => {
            checkbox.checked = !originalState; // revert on error
            console.error('Error:', error);
            alert("An error occurred.");
        });
    
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
                let image_view = document.getElementById('view')
            image_view.setAttribute('src', e.target.result);
            image_view.style.display = "block";
        }
        document.getElementById('image-selector-text').style.display = 'none';
        reader.readAsDataURL(input.files[0]);
    }
}


function logout() {
  fetch('/logout.php', {
    method: 'POST',
  })
  .then(response => {
    if (response.redirected) {
      window.location.href = response.url;
    }
  });
}