$(document).ready(function() {
    $(document).on('submit', '.myForm', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), '', 'json').always(function(data) {
            if (data == 'success') {
                M.toast({ html: 'I am a toast!', classes: 'rounded' });
            }
            if (data == 'error') {
                M.toast({ html: 'I am a toast!', classes: 'rounded' });
            }
        }).fail(function(data) {
            if (data.status === 422) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (key, val) {
                    M.toast({ html: val, classes: 'rounded' });
                });
            }
        });
    });
});

//axios
// add this methods in button onclick="submitData()"
// document.getElementById("myForm").onclick = function () { submitData() };
// function submitData() {
//     const name = document.getElementById('name').value
//     const email = document.getElementById('email').value
//     const id = document.getElementById('id').value
//     const imagefile = document.querySelector('#file');

//     var formData = new FormData();
//     formData.append('id', id);
//     formData.append('name', name);
//     formData.append('email', email);
//     formData.append("image", imagefile.files[0]);

//     var url = 'http://127.0.0.1:8000/customer/add';

//     if (id) {
//         var url = 'http://127.0.0.1:8000/customer/edit/' + id;
//     }

//     axios.post(url, formData)
//         .then(function (response) {
//             if (response.data.status == 'redirect') {
//                 window.location = response.data.message;
//             }
//         }).catch(function (e) {
//             var er = e.response.data.errors;
//             for (var key in e.response.data.errors) {
//                 if (!e.response.data.errors.hasOwnProperty(key)) continue;
//                 var obj = e.response.data.errors[key];
//                 for (var prop in obj) {
//                     if (!obj.hasOwnProperty(prop)) continue;
//                     var para = document.createElement("p");
//                     var node = document.createTextNode(obj[prop]);
//                     para.appendChild(node);
//                     var element = document.getElementById("error");
//                     element.appendChild(para);
//                 }
//             }
//         });
// }