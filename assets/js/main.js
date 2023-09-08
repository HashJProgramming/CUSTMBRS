(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
  
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
  
          form.classList.add('was-validated')
        }, false)
      })
  })();

$(document).ready(function() {
    const currentPath = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type');
    const message = urlParams.get('message');
    
new DataTable('table.table-display',{
    dom: '<"top"Bfrtip<"clear">',
    buttons: [
        
        { 
            extend: 'excel', 
            title: 'CUSTMBRS - Cottage Usage Scheduling with Transaction Monitoring for a Beach Resort System', 
            className: 'btn btn-primary',
            text: '<i class="fa fa-file-excel"></i> EXCEL'
        },
        {
            extend: 'pdf',
            title: 'CUSTMBRS - Cottage Usage Scheduling with Transaction Monitoring for a Beach Resort System', 
            className: 'btn btn-primary',
            text: '<i class="fa fa-file-pdf"></i> PDF'
        },
        { 
            extend: 'print', 
            className: 'btn btn-primary',
            text: '<i class="fa fa-print"></i> Print',
            title: 'CUSTMBRS - Cottage Usage Scheduling with Transaction Monitoring for a Beach Resort System', 
            autoPrint: true,
            exportOptions: {
                columns: ':visible',
            },
            customize: function (win) {
                $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                    $(this).css('background-color','#D0D0D0');
                });
                $(win.document.body).find('h1').css('text-align','center');
            }
        }
    ]
});
    
    if (type == 'success') {
        Swal.fire(
            'Success!',
             message,
            'success'
          )
    } else if (type == 'error') {
        Swal.fire(
            'Error!',
             message,
            'error'
          )
    }
    
    if (currentPath.includes("/CUSTMBRS/customer.php")) {
        $('a[data-bs-target="#update"]').on('click', function() {
            var id = $(this).data('id');
            var fullname = $(this).data('fullname');
            var address = $(this).data('address');
            var phone = $(this).data('phone');

            $('input[name="id"]').val(id);
            $('input[name="fullname"]').val(fullname);
            $('input[name="address"]').val(address);
            $('input[name="phone"]').val(phone);
        });

      } else if (currentPath.includes("/CUSTMBRS/users.php")) {
        $('a[data-bs-target="#update"]').on('click', function() {
            var id = $(this).data('id');
            var username = $(this).data('username');
            var address = $(this).data('address');
            var phone = $(this).data('phone');
            $('input[name="id"]').val(id);
            $('input[name="username"]').val(username);
            $('input[name="address"]').val(address);
            $('input[name="phone"]').val(phone);
            console.log(id, username);
        });

      } else if (currentPath.includes("/CUSTMBRS/cottage.php")) {
        $('button[data-bs-target="#update"]').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var day = $(this).data('day');
            var night = $(this).data('night');
            $('input[name="id"]').val(id);
            $('input[name="name"]').val(name);
            $('input[name="priceDay"]').val(day);
            $('input[name="priceNight"]').val(night);
            console.log(id); 
        });
      }else if (currentPath.includes("/CUSTMBRS/rents.php")) {
        $('a[data-bs-target="#return"]').on('click', function() {
            var id = $(this).data('id');
            $('input[name="data_id"]').val(id);
            console.log(id); 
        });

        $('a[data-bs-target="#stock-in"]').on('click', function() {
            var id = $(this).data('id');
            console.log(id); 
            $('input[name="data_id"]').val(id);
        });

        $('a[data-bs-target="#stock-out"]').on('click', function() {
            var id = $(this).data('id');
            console.log(id); 
            $('input[name="data_id"]').val(id);
        });
      } else{
        console.log("The URL is neither /customer nor /list");
      }



    $('a[data-bs-target="#remove"]').on('click', function() {
        var id = $(this).data('id');
        console.log(id); 
        $('input[name="id"]').val(id);
    });
    $('button[data-bs-target="#remove"]').on('click', function() {
        var id = $(this).data('id');
        console.log(id); 
        $('input[name="id"]').val(id);
    });

} );
