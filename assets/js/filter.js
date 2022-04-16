document.querySelectorAll('input[type="radio"]').onclick = function () {
    // access properties using this keyword
    if (this.checked) {
        // Returns true if checked
        alert(this.value);
    } else {
        // Returns false if not checked
    }
};


let btnFilter = document.querySelector('.btnFilter');
let filter = document.querySelector('.filter');

filter.style.display = 'none';

btnFilter.addEventListener('click', (e) => {
    e.preventDefault();
    filter.style.display === 'none' ? filter.style.display = 'flex' : filter.style.display = 'none';

})
//



document.querySelectorAll('.categories input').forEach(input => {
    addEventListener('change', (e) => {
        console.log('clicj')
// //    intercepte les click && recupere les données du form
//         const Form = new FormData('form-check');
//
// //    on creer la queryString
//         const Params = new URLSearchParams();
//
//         Form.forEach((value, key) => {
//             Params.append(key, value);
//         });
//
// //    on recupere l'url active
//         const Url = new URL(window.location.href);
//
// //    lance requete ajax
//         fetch(URL.pathname + "?" + Params.toString(),{
//             headers: {
//                 "x-Requested-With": "XMLHttpRequest"
//             }
//         }).then(response => {
//             console.log(response)
//         }).catch(e => alert(e));
    })
})