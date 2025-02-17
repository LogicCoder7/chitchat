const postImageBtn = document.getElementById('postImageBtn');
const postTextBtn = document.getElementById('postTextBtn');

const fileInput = document.createElement('input');
fileInput.setAttribute('type', 'file');
fileInput.setAttribute('name', 'post');

const txtArea = document.createElement('textarea');
txtArea.setAttribute('name', 'post');

postTextBtn.addEventListener('click', () => {
    document.forms[0]['post'].replaceWith(txtArea);
});

postImageBtn.addEventListener('click', () => {
    document.forms[0]['post'].replaceWith(fileInput);
});
