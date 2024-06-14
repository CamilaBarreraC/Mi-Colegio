const cbxColegio = document.getElementById('id_colegio')
cbxColegio.addEventListener("change", getCursos)

const cbxCurso = document.getElementById('id_curso')

function fetchAndSetData(url, formData, targetElement) {
    return fetch(url, {
        method: "POST",
        body: formData,
        mode: 'cors'
    })
        .then(response => response.json())
        .then(data => {
            targetElement.innerHTML = data;
        })
        .catch(err => console.log(err));
}

function getCursos() {
    let colegio = cbxColegio.value;
    let url = 'inc/getCursos.php';
    let formData = new FormData();
    formData.append('id_colegio', colegio);

    fetchAndSetData(url, formData, cbxCurso)
        .catch(err => console.log(err));
}
