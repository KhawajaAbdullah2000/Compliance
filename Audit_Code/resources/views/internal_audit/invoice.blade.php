<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

    <div class="container border rounded shadow-sm p-4">
        <h1 class="text-center mb-4">Invoice #{{ $invoiceNumber }}</h1>

        <table class="table table-bordered">
            <tr>
                <th>Customer</th>
                <td>{{ $customerName }}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>${{ $amount }}</td>
            </tr>
        </table>

        <div class="text-center mt-4">
            <small>Thank you for your business!</small>
        </div>
    </div>

</body>
</html>
