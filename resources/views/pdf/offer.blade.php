<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Offer</title>
    <style>
        .table-container {
            width: 100%;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000000;
        }

        .custom-table th,
        .custom-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #000000;
        }

        .custom-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            padding: 2px 8px;
            text-align: justify;
        }

        th,
        td {
            line-height: normal;
            border: 1px solid #1a1919;
        }
    </style>

</head>

<body>
    <div class="table-container">
        <div class="title">
            <h2 style="text-align: center; margin:0px; padding:0px;">Offer</h2>
            <p style="text-align: center; margin:0px; padding:0px;">Date: <?php echo  date('Y-m-d h:i:s a'); ?></p>
        </div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Created by</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>DateTime</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offers as $key => $offer)
                <tr>
                    <td style="font-family:kalpurush;text-align:justify;">{{ $key+1 }}</td>
                    <td style="font-family:kalpurush;text-align:justify;">{{ $offer->author->name }}</td>
                    <td style="font-family:kalpurush;text-align:justify;">{{ $offer->title }}</td>
                    <td style="font-family:kalpurush;text-align:justify;"><img src="{{ asset($offer->image_url) }}" alt="Avatar" class="rounded-circle" width="50px" /></td>
                    <td style="font-family:kalpurush;text-align:justify;">{{ $offer->price }}</td>
                    <td style="font-family:kalpurush;text-align:justify;">{{ getTitles($offer->categories) }}</td>
                    <td style="font-family:kalpurush;text-align:justify;">{{ getTitles($offer->locations) }}</td>
                    <td style="font-family:kalpurush;text-align:justify;">{{ date('Y-m-d h:i:s a', strtotime($offer->created_at)) }}</td>
                </tr>
                @endforeach
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</body>

</html>