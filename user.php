<?php
$min_angka = 1;
$max_angka = 10;

$rand_angka1 = mt_rand($min_angka, $max_angka);
$rand_angka2 = mt_rand($min_angka, $max_angka);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User perpuss</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>

<body>
    <div class="contact-form">
        <h1>Library</h1>
    </div>

    <div class="table-container">
        <h2>Data Masuk</h2>
        <table id="dataTable" class="display">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Telepon</th>
                    <th>Website</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody id="dataBody"></tbody>
        </table>
    </div>

    <!-- Include jQuery and DataTables JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script>
        var dataTableInstance;
        const resultCaptcha = <?php 
        echo $rand_angka1 + $rand_angka2; 
        ?>;

        function saveFormData(formData) {
            var entries = JSON.parse(localStorage.getItem('capca_entries')) || [];
            entries.push(formData);
            localStorage.setItem('capca_entries', JSON.stringify(entries));
        }

        function deleteRow(index) {
            var entries = JSON.parse(localStorage.getItem('capca_entries')) || [];
            entries.splice(index, 1);
            localStorage.setItem('capca_entries', JSON.stringify(entries));
            updateDataTable();
        }

        function submitForm(event) {
            event.preventDefault();

            var userAnswer = parseInt(document.getElementById('jawaban').value, 10);

            if (userAnswer === resultCaptcha) {
                var formData = {
                    'buku': document.getElementById('buku').value,
                    'penerbit': document.getElementById('penerbit').value,
                    'tahun': parseInt(document.getElementById('tahun').value, 10),
                    'kategori': document.getElementById('kategori').value,
                    'telepon': parseInt(document.getElementById('telepon').value, 10),
                    'website': document.getElementById('website').value,
                    'message': document.getElementById('message').value,
                };

                saveFormData(formData);
                alert('Data berhasil masuk');
                document.getElementById('contactForm').reset();
                updateDataTable();
            } else {
                alert('Captcha is incorrect');
                document.getElementById('jawaban').value = '';
            }
        }

        function updateDataTable() {
            var entries = JSON.parse(localStorage.getItem('capca_entries')) || [];
            var tableBody = document.getElementById('dataBody');
            tableBody.innerHTML = '';

            for (var i = 0; i < entries.length; i++) {
                var row = '<tr>';
                row += '<td>' + entries[i].buku + '</td>';
                row += '<td>' + entries[i].penerbit + '</td>';
                row += '<td>' + entries[i].tahun + '</td>';
                row += '<td>' + entries[i].kategori + '</td>';
                row += '<td>' + entries[i].telepon + '</td>';
                row += '<td>' + entries[i].website + '</td>';
                row += '<td>' + entries[i].message + '</td>';
                row += '</tr>';
                tableBody.innerHTML += row;
            }

            if (dataTableInstance) {
                dataTableInstance.destroy();
            }

            dataTableInstance = $('#dataTable').DataTable({
                "paging": true,
                "pageLength": 5,
            });
        }

        updateDataTable();  // Initialize DataTable with existing data
    </script>
</body>

</html>
