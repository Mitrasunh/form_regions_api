<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>

    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<body >
    <div class="container mt-3 pt-3">
        <div class="row">
            <div class="col-12 col-sm-10 col-md-8 m-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center mb-4">Form Info</h3>
                        <form action="{{ route('index.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="txtId" class="col-sm-3 col-form-label">ID</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="txtId" name="txtId">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="txtName" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="txtName" name="txtName">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="txtProvince" class="col-sm-3 col-form-label d-flex align-items-center">Province</label>
                                <div class="col-sm-9">
                                    <select id="txtProvince" name="txtProvince" class="form-select api-province">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="txtCity" class="col-sm-3 col-form-label">City</label>
                                <div class="col-sm-9">
                                    <select id="txtCity" name="txtCity" class="form-select api-city">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                {{--  <button type="submit" class="btn btn-danger">Cancel</button>  --}}
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <div class="container">
        <table class="table table-striped table-bordered" id="data-table">
            <thead>
                <tr>    
                    <th>ID</th>
                    <th>Name</th>
                    <th>Province</th>
                    <th>City</th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTables akan mengisi data di sini -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'province', name: 'province' },
                    { data: 'city', name: 'city' }
                ]
            });

            $('.api-province').select2({
                placeholder: "Select a province",
                width: 'resolve'
            });

            $('.api-city').select2({
                placeholder: "Select a city",
                width: 'resolve'
            });

            $.ajax({
                url: 'https://Mitrasunh.github.io/api-wilayah-indonesia/api/provinces.json',
                method: 'GET',
                success: function(data) {
                    var options = data.map(function(province) {
                        return new Option(province.name, province.id, false, false);
                    });

                    $('#txtProvince').append(options).trigger('change');
                },
                error: function(err) {
                    console.log('Error:', err);
                }
            });

            $('#txtProvince').on('change', function() {
                var provinceId = $(this).val();

                if (provinceId) {
                    $.ajax({
                        url: `https://Mitrasunh.github.io/api-wilayah-indonesia/api/regencies/${provinceId}.json`,
                        method: 'GET',
                        success: function(data) {
                            var options = data.map(function(city) {
                                return new Option(city.name, city.id, false, false);
                            });

                            $('#txtCity').empty().append(options).trigger('change');
                        },
                        error: function(err) {
                            console.log('Error:', err);
                        }
                    });
                } else {
                    $('#txtCity').empty().append('<option></option>').trigger('change');
                }
            });
        });
    </script>
</body>
</html>
