const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    })
}

if (close) {
    close.addEventListener('click', () => {
        nav.classList.remove('active');
    })
}

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('toggle-btn')) {
        const button = e.target;
        const target = document.querySelector(button.dataset.target);
        if (target) {
            target.classList.toggle('expanded');
            button.textContent = target.classList.contains('expanded') ? 'Show Less' : 'Show More';
        }
    }
});

