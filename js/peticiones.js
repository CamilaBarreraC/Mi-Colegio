// JS PARA CARGAR COLEGIOS SELECCIONANDO LA REGIÓN Y COMUNA

const cbxRegion = document.getElementById('region')
cbxRegion.addEventListener("change", getComunas)

const cbxComuna = document.getElementById('comuna')
cbxComuna.addEventListener("change", getColegios)

const cbxColegio = document.getElementById('colegio')

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

function getComunas() {
    let region = cbxRegion.value;
    let url = 'inc/getComunas.php';
    let formData = new FormData();
    formData.append('id_region', region);

    fetchAndSetData(url, formData, cbxComuna)
        .then(() => {
            cbxColegio.innerHTML = ''
            let defaultOption = document.createElement('option');
            defaultOption.value = 0;
            defaultOption.innerHTML = "Seleccionar";
            cbxColegio.appendChild(defaultOption);
        })
        .catch(err => console.log(err));
}

function getColegios() {
    let comuna = cbxComuna.value;
    let url = 'inc/getColegios.php';
    let formData = new FormData();
    formData.append('id_comuna', comuna);

    fetchAndSetData(url, formData, cbxColegio)
        .catch(err => console.log(err));
}