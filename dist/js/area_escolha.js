function showOptions(type) {
    const optionsButtons = document.getElementById('options');
    optionsButtons.innerHTML = `
      <button class="btn btn-dark" onclick="showForm('${type}')">Login</button>
    `;
    document.getElementById('form-container').style.display = 'none';
}

function showForm(type) {
    const formContainer = document.getElementById('form-container');
    formContainer.style.display = 'flex';
    formContainer.innerHTML = `
      
    `;
}